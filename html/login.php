<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HAPPY HACKING!</title>
        <link rel="stylesheet" href = "/css/style.css">
    </head>
    <body>
        <h1>Login</h1>
        <form action="process_login.php" method="POST">
            <div class = "form-group"> 
                <input type="text" name="id" class = "form-group" placeholder="ID입력">
            </div>

            <div class = "form-group">
                <p><input type="password" name="pw" class = "form-group" placeholder="PW입력"></p>
            </div>
            <br>
            <div class = "login-button">
                <p><input type="submit" value="로그인하기" class = "btn-primary"></p>
            </div>

        </form>

        <div class="btn-btn">
            <form action="join.php">
                <div class = "join-button">
                    <p><input type="submit" value="회원가입" class = "btn-primary2"><p>
                </div>
            </form>
            <p>|</p>
            <form action="inquiry_board.php"> 
                <div class = "inquiry-button">
                    <p><input type="submit" value="문의게시판" class = "btn-primary3"></p>
                </div>
            </form>
        </div>
        
        <footer class="footer">
            <p>
            <?php session_start();
                    if (isset($_SESSION['login_error'])) {
                        echo $_SESSION['login_error'];
                        unset($_SESSION['login_error']);
                    }
            ?>
            </p>
        </footer>

    </body>
</html>
        