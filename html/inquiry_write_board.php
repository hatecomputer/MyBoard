<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>문의게시판 작성 중</title>
    </head>
    <body>
        <h1>문의게시판 작성!</h1>
        <form action="inquiry_write_process_board.php" method="POST">
            <label>ID:</label>
            <input type="text" name="user_id" placeholder="작성자이름,특수기호X" required><br><br>
            <p><input type="text" name="title" maxlegth="44" placeholder="제목 입력, 최대 44자까지 가능합니다" required></p>
            <p><textarea name="detail" rows="20" cols="20" maxlength="254" placeholder="내용 작성,최대 254자 가능합니다" required></textarea></p>
            <p><input type="password" name="pw" maxlegth="44" placeholder="비밀번호입력" required></p>
            <p><input type="submit" value="올리기"></p>
        </form>
        
        <form action="inquiry_board.php"> 
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