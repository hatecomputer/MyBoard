<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome! HACKER!</title>
    </head>
    <body>
        <h1>MY PAGE!</h1>
        <p>
        <?php 
            include 'DB_INFO.php'; //데이터 베이스 정보

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$dbname); //로그인
            $conn_for_board = mysqli_connect($host,$username,$password,$db_board); //게시판

   
            //데이터베이스 오류시 종료
            if(mysqli_connect_errno()) {
                die("데이터 베이스 오류: ". mysqli_connect_error());
            }

            session_start(); //세션 시작

            if(!isset($_SESSION['login_id'])) {
                //로그인하지 않은 사용자
                header("Location: login.php"); //login 화면으로 바꾼다
                exit(); //이 페이지를 바로 닫는다
            }        
        ?>
        </p>
        <form action="change_id.php" method="GET"> 
            <p><input type="text" name="old_id" placeholder="기존 ID입력" required></p>
            <p><input type="text" name="new_id" placeholder="변경할 ID,특수기호는 입력X" required></p>
            <p><input type="submit" value="수정하기"></p>
        </form>
        
        <p></p>
        <form action="only_login.php">
            <p><input type="submit" value="메인으로 돌아가기"></p>
        </form>
        
        <?php
            if(isset($_GET['new_id']) && isset($_GET['old_id'])) {
                //보안 검사
                $old_id = filter_var(strip_tags($_GET['old_id']),FILTER_SANITIZE_SPECIAL_CHARS);
                $new_id = filter_var(strip_tags($_GET['new_id']),FILTER_SANITIZE_SPECIAL_CHARS);

                if($_SESSION['login_id'] == $old_id) {
                    //ID 변경, 게시물도 전부 id 수정
                    $sql = "UPDATE LOGIN_INFO SET id= ? WHERE id = ? ";
                    $sql_board = "UPDATE BOARD_INFO SET id=? WHERE id = ?";

                    //세션 할당
                    $_SESSION['login_id'] = $new_id;

                    //preparedStatement 적용
                    $stmt = mysqli_prepare($conn, $sql);
                    $stmt_board = mysqli_prepare($conn_for_board,$sql_board);

                    //바인딩
                    mysqli_stmt_bind_param($stmt,'ss',$new_id, $old_id);
                    mysqli_stmt_bind_param($stmt_board,'ss',$new_id,$old_id);

                    //sql 실행
                    if(mysqli_stmt_execute($stmt)) {
                        $_SESSION['write_error'] = "ID가 수정 됬습니다!";
                    } else {
                        //실패시
                        $_SESSION['write_error'] = '작성 중 오류가 발생하였습니다.';
                    }

                    //게시판sql 실행
                    if(mysqli_stmt_execute($stmt_board)) {
                        $_SESSION['write_error'] = "ID가 수정 됬습니다!";
                    } else {
                        //실패시
                        $_SESSION['write_error'] = '작성 중 오류가 발생하였습니다.';
                    }
                    
                    //prepared statement 종료
                    mysqli_stmt_close($stmt);
                    mysqli_stmt_close($stmt_board);

                    //전 페이지로 이동
                    header("Location: my_info.php");
                    exit();

                } else {
                    $_SESSION['write_error'] = 'ID가 틀립니다!';
                }
            }
        ?>
        <p></p>
        <?php 
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
    </body>
</html>