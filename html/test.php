<!--<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>HAPPY HACKING!</title>
    </head>
    <body>
        <h1>Login_test</h1>
        <form action="test_process.php" method="POST"> 
            <p><input type="text" name="id" placeholder="ID입력"></p>
            <p><input type="text" name="pw" placeholder="PW입력"></p>
            <p><input type="submit" value="로그인하기"></p>
        </form>
        <p>
        <?php session_start();
                if (isset($_SESSION['login_error'])) {
                    echo $_SESSION['login_error'];
                    unset($_SESSION['login_error']);
                }
        ?>
        </p>
    </body>
</html>-->



