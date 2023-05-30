<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>게시판 수정 중</title>
    </head>
    <body>

        <?php 
            include 'DB_INFO.php'; //데이터 베이스 정보

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$db_board);

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
            //GET방식으로 board_id 받기
            $board_id = filter_var(strip_tags($_GET['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);

            //작성된 게시물들 조회 문
            $sql = "SELECT * FROM $db_board WHERE board_id = ? ";

            //preparedStatement 적용
            $stmt = mysqli_prepare($conn, $sql);
    
            //바인딩
            mysqli_stmt_bind_param($stmt,'s', $board_id );
            
            //실행
            mysqli_stmt_execute($stmt);

            //실행 결과 가져오기
            $result = mysqli_stmt_get_result($stmt);

            //결과값 가져오기
            $row = mysqli_fetch_assoc($result);
        ?>
        <form action="write_process_board.php" method="POST" enctype="multipart/form-data"> 
            <p><input type="text" name="title" maxlength="44" value="<?php echo $row['title']; ?>" placeholder="제목 입력, 최대 44자까지 가능합니다"></p>
            <p><textarea name="detail" rows="20" cols="20" maxlength="254" placeholder="내용 작성,최대 254자 가능합니다"><?php echo $row['detail']; ?></textarea></p>
            <p><input type="file" name="file" id="fileToUpload"></p>
            <?php
                if (isset($row['file_name'])) {
                    $file_name = implode('_', array_slice(explode('_', $row['file_name']), 1)); // '_' 문자를 기준으로 분리 후 첫 번째 요소를 제외한 나머지 요소를 모두 합쳐서 파일명을 구성합니다.
                    echo '<p>FILE: '.$file_name.'</p>';
                }
            ?>
            <p><input type="submit" value="수정하기"></p>
            <input type="hidden" name='board_id' value="<?php echo $row['board_id']; ?>">
        </form>

        <p>
        <?php session_start();
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
                
                //prepared 종료
                mysqli_stmt_close($stmt);
        ?>
        </p>
    </body>
</html>