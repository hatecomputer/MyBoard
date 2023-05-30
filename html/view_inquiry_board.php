<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>문의게시물 보는중</title>
    </head>
    <body>
        <p>
        <?php 

            include 'DB_INFO.php'; //데이터 베이스 정보

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$db_inquiry);

            //데이터베이스 오류시 종료
            if(mysqli_connect_errno()) {
                die("데이터 베이스 오류: ". mysqli_connect_error());
            }

            //GET방식으로 전달된 index 받는다
            $board_id = filter_var(strip_tags($_GET['index']),FILTER_SANITIZE_SPECIAL_CHARS);

            //작성된 게시물들 조회 문
            $sql = "SELECT * FROM $db_inquiry WHERE board_id = ? ";

            $stmt = mysqli_prepare($conn,$sql);

            mysqli_stmt_bind_param($stmt, 'i', $board_id);

            mysqli_stmt_execute($stmt);

            //결과 가져오기
            $result = mysqli_stmt_get_result($stmt);
            
            //게시물 출력
            while($row = mysqli_fetch_assoc($result)) {
                echo '<p>ID: '.$row['user_id'].'</p>';
                echo '<p>Title: '.$row['title'].'</p>';
                echo '<p>Detail: '.$row['detail'].'</p>';
                echo '<p>Date: '.$row['date_value'].'</p>';

                //게시물 수정 버튼을 보여준다
                echo "<form method='GET' action='inquiry_fix_process_board.php'>
                        <input type='hidden' name='board_id' value='".$row['board_id']."'>
                        <p><button type='submit'>게시물 수정</button></p>
                      </form>";

                //게시물 삭제 버튼을 보여준다
                echo "<form method='GET' action='inquiry_delete_board.php'>
                        <input type='hidden' name='board_id' value='".$row['board_id']."'>
                        <p><button type='submit'>삭제</button></p>
                      </form>";          
            }

            mysqli_stmt_close($stmt);
        ?>
        </p>
        <p>
        <?php session_start();
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
        </p>
        <p></p>
        <form action="inquiry_board.php">
            <p><input type="submit" value="문의페이지로"></p>
        </form>
        <form action="login.php">
            <p><input type="submit" value="로그인페이지로"></p>
        </form>
    </body>
</html>
