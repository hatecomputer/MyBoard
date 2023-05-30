<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판 수정 중</title>
    </head>
    <body>

        <?php 
            include 'DB_INFO.php'; //데이터 베이스 정보

            session_start();

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$db_inquiry);

            //데이터베이스 오류시 종료
            if(mysqli_connect_errno()) {
                die("데이터 베이스 오류: ". mysqli_connect_error());
            }

            //GET방식으로 board_id 받기
            $board_id = filter_var(strip_tags($_GET['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);


            //작성된 게시물들 조회 문
            $sql = "SELECT * FROM $db_inquiry WHERE board_id = ? ";

            $stmt = mysqli_prepare($conn,$sql);

            mysqli_stmt_bind_param($stmt, 'i' , $board_id);

            mysqli_stmt_execute($stmt);

            //결과값 옮기기
            $result = mysqli_stmt_get_result($stmt);

            //결과값 가져오기
            $row = mysqli_fetch_assoc($result);

            
            if(isset($_POST['pw'])) {
                //비밀번호 값을 가져온다
                $hashed_pw = $row['pw'];

                if(password_verify($_POST['pw'],$hashed_pw)) {
                    //비밀번호가 맞으면
                    echo "<form action='inquiry_write_process_board.php' method='POST'>
                            <p><input type='text' name='user_id' maxlength='44' value='".$row['user_id']."' placeholder='작성자이름'></p>
                            <p><input type='text' name='title' maxlength='44' value='".$row['title']."' placeholder='제목 입력, 최대 44자까지 가능합니다'></p>
                            <p><textarea name='detail' rows='20' cols='20' maxlength='254' placeholder='내용 작성,최대 254자 가능합니다'>".$row['detail']."</textarea></p>
                            <p><input type='submit' value='수정하기'></p>
                            <input type='hidden' name='board_id' value='".$row['board_id']."'>
                        </form>";


                } else {    
                    //비밀번호 틀린경우
                    $_SESSION['write_error'] = '비밀번호가 틀립니다!';
                    
                    header("Location: view_inquiry_board.php?index=".$board_id);
                    exit();
                }
            } else {
                echo "<form method='POST' action='inquiry_fix_process_board.php?board_id=$board_id'>
                    <input type='password' name='pw' value=''>
                    <p><button type='submit'>인증하기</button></p>
                  </form>";
            }
          
            mysqli_stmt_close($stmt); //preparedstatement 종료
        ?>

        <p>
        </p>
    </body>
</html>