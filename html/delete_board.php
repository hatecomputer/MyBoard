<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    session_start(); //세션 시작
    
    if(!isset($_SESSION['login_id'])) {
        //로그인하지 않은 사용자
        header("Location: login.php"); //login 화면으로 바꾼다
        exit(); //이 페이지를 바로 닫는다
    }
    
    //게시판 데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password, $db_board);
    
    //데이터베이스 오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }

    //POST로 전달된 정보 받기
    $board_id = filter_var(strip_tags($_POST['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);

    //session으로 유저 이름 받기
    $user_id = $_SESSION['login_id'];
    
    //삭제용 sql문 작성
    $sql = "DELETE FROM $db_board WHERE board_id= ? ";

    //preparedStatement 적용
    $stmt = mysqli_prepare($conn, $sql);
    
    //바인딩
    mysqli_stmt_bind_param($stmt,'s', $board_id );

    //실행
    if(mysqli_stmt_execute($stmt)) {
        //실행 후 게시판으로 이동
        header("Location: board.php");
    } else {
        //오류 발생 시 메시지 호출
        $_SESSION['write_error'] = '삭제하는데 실패했습니다! 조금 있다 하십시오';
        header("Location: view_board.php");
    }
    //prepared 종료
    mysqli_stmt_close($stmt);

    exit();
?>