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

            echo "당신은 ", $_SESSION['login_id'], " 입니다";
        ?>
        </p>
        <form action="change_id.php">
            <p><input type="submit" value="ID 수정하기"></p>
        </form>

        <form action="change_pw.php">
            <p><input type="submit" value="PW 수정하기"></p>
        </form>
        
        <p></p>
        <form action="process_logout.php" method="POST"> 
            <p><input type="submit" name="logout" value="로그아웃"></p>
        </form>
        
        <p></p>
        <form action="board.php">
            <p><input type="submit" value="메뉴"></p>
        </form>
        <?php //오류문 출력
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
    </body>
</html>