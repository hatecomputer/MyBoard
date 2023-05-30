<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판 작성 중</title>
    </head>
    <body>
        <h1>게시판 작성!</h1>
        <?php 
            session_start(); //세션 시작

            if(!isset($_SESSION['login_id'])) {
                //로그인하지 않은 사용자
                header("Location: login.php"); //login 화면으로 바꾼다
                exit(); //이 페이지를 바로 닫는다
            }
        ?>
        <form action="write_process_board.php" method="POST"  enctype="multipart/form-data"> 
            <p><input type="text" name="title" maxlegth="44" placeholder="제목 입력, 최대 44자까지 가능합니다" required></p>
            <p><textarea name="detail" rows="20" cols="20" maxlength="254" placeholder="내용 작성,최대 254자 가능합니다" required></textarea></p>
            <p><input type="file" name="file" id="fileToUpload"></p>
            <p><input type="submit" value="올리기"></p>
        </form>
        
        <form action="board.php"> 
            <p><input type="submit" value="돌아가기"></p>
        </form>
        <p>
        <?php session_start();
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
        </p>
    </body>
</html>