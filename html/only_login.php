<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href = "/css/style_only.css">
        <title>Welcome! HACKER!</title>
    </head>
    <body>
        <h1>Welcome! User!</h1>
        
        <?php 
            session_start(); //세션 시작

            if(!isset($_SESSION['login_id'])) {
                //로그인하지 않은 사용자
                header("Location: login.php"); //login 화면으로 바꾼다
                exit(); //이 페이지를 바로 닫는다
            }
        ?>

        <div class = "welcome-text">
            당신은 <?php echo $_SESSION['login_id'];?> 입니다! 환영합니다! HAPPYHACKING!!
        </div>


        <form action="board.php" class = "board-btn">
            <p><input type="submit" value="메뉴" class = "board-btn-1"></p>
        </form>
        
        <div class = "logout-info">
            <form action="process_logout.php" method="POST" class = "logout-btn"> 
                <p><input type="submit" name="logout" value="로그아웃" class = "logout-btn-1"></p>
            </form>
            <p>|</p>
            <form action="my_info.php" class = "info-btn">
                <p><input type="submit" value="마이페이지" class= "info-btn-1"></p>
            </form>
        </div>

    </body>
</html>
