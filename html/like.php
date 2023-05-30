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

    //세션ID 저장
    $login_id = $_SESSION['login_id'];
    //POST 받은 id값 저장
    $board_id = filter_var(strip_tags($_POST['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);

    //ID통해 좋아요 누른 게시물 조회
    $sql = "SELECT likes_board FROM LOGIN_INFO WHERE id = ? AND ( FIND_IN_SET( ? ,likes_board ) > 0 )";

    $stmt = mysqli_prepare($conn,$sql);
    mysqli_stmt_bind_param($stmt, 'ss' , $login_id, $board_id);
    mysqli_stmt_execute($stmt);
    //쿼리문 실행
    $result = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result) > 0) {
        //좋아요 누른 경우 취소하기
        $stmt2 = mysqli_prepare($conn, "UPDATE LOGIN_INFO SET likes_board = REPLACE(likes_board, ? , '') WHERE id = ? ");
        $stmt3 = mysqli_prepare($conn_for_board, "UPDATE BOARD_INFO SET like_value = like_value - 1 WHERE board_id = ? ");

        mysqli_stmt_bind_param($stmt2, 'ss', $board_id,$login_id);
        mysqli_stmt_bind_param($stmt3, 's', $board_id);
    }
    else {
        //좋아요 안 누른 경우 추가
        $stmt2 = mysqli_prepare($conn, "UPDATE LOGIN_INFO SET likes_board = CONCAT_WS( ? , likes_board, ',') WHERE id = ? ");
        $stmt3 = mysqli_prepare($conn_for_board, "UPDATE BOARD_INFO SET like_value = like_value + 1 WHERE board_id = ? ");

        mysqli_stmt_bind_param($stmt2, 'ss', $board_id,$login_id);
        mysqli_stmt_bind_param($stmt3, 's', $board_id);
    }

    mysqli_stmt_execute($stmt2);
    mysqli_stmt_execute($stmt3);

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);
    mysqli_stmt_close($stmt3);
    
    header("Location: view_board.php?index=".$board_id);

    exit();

?>