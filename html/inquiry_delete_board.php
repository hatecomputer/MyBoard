<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    session_start(); //세션 시작
    
    //게시판 데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password, $db_inquiry);
    
    //데이터베이스 오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }

    //POST로 전달된 정보 받기
    $board_id = filter_var(strip_tags($_GET['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);
    
    //삭제용 sql문 작성
    $sql = "DELETE FROM $db_inquiry WHERE board_id= ? ";

    //비밀번호 조회용 sql문 작성
    $sql_pw = "SELECT pw FROM $db_inquiry WHERE board_id= ? ";


    $stmt = mysqli_prepare($conn,$sql); //삭제용sql
    $stmt2 = mysqli_prepare($conn,$sql_pw); //비밀번호sql

    mysqli_stmt_bind_param($stmt , 'i' , $board_id);
    mysqli_stmt_bind_param($stmt2, 'i' , $board_id);

    mysqli_stmt_execute($stmt2); //비밀번호부터 실행
    //실행(비밀번호)
    $result = mysqli_stmt_get_result($stmt2);

    //결과값 가져오기
    $row = mysqli_fetch_assoc($result);

    if(isset($_POST['pw'])) {
        //비밀번호 값을 가져온다
        $hashed_pw = $row['pw'];

        if(password_verify($_POST['pw'],$hashed_pw)) {
            //실행
            if(mysqli_stmt_execute($stmt)) {
                //실행 후 게시판으로 이동
                header("Location: inquiry_board.php");
            } else {
                //오류 발생 시 메시지 호출
                $_SESSION['write_error'] = '삭제하는데 실패했습니다! 조금 있다 하십시오';
                header("Location: view_inquiry_board.php");
            }

        } else {
            //비밀번호 틀린경우
            $_SESSION['write_error'] = '비밀번호가 틀립니다!';
            header("Location: view_inquiry_board?index=$board_id");
        }
    } else {
        echo "<form method='POST' action='inquiry_delete_board.php?board_id=$board_id'>
                <input type='password' name='pw' value=''>
                <p><button type='submit'>인증하기</button></p>
             </form>";
    }
    mysqli_stmt_close($stmt); //preparedstatement 종료
    mysqli_stmt_close($stmt2);
    exit();
?>