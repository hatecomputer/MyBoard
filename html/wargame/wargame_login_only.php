<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome! HACKER!</title>
    </head>
    <body>
        <h1>Welcome! User!</h1>
        <p>
        <?php 
            session_start(); //세션 시작

            if(!isset($_SESSION['login_id'])) {
                //로그인하지 않은 사용자
                header("Location: login.php"); //login 화면으로 바꾼다
                exit(); //이 페이지를 바로 닫는다
            }

            echo "당신은 ", $_SESSION['login_id'], " 입니다! 환영합니다! HAPPYHACKING!!";
        ?>
        </p>
        <p></p>
        <form action="wargame_logout.php" method="POST"> 
            <p><input type="submit" name="logout" value="로그아웃"></p>
        </form>

        <p></p>
    </body>
</html>