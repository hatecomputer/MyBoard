<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    session_start(); //세션 시작

    //문의게시판 데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password, $db_inquiry);

    //데이터베이스 오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }

    //POST로 전달된 정보 받기
    if(isset($_POST['board_id'])){ //수정시 받아온다
        $board_id = filter_var(strip_tags($_POST['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $board_id = null;
    }
    $title = filter_var(strip_tags($_POST['title']),FILTER_SANITIZE_SPECIAL_CHARS);
    $detail = filter_var(strip_tags($_POST['detail']),FILTER_SANITIZE_SPECIAL_CHARS);

    //POST으로 유저 이름 받기
    $user_id = filter_var(strip_tags($_POST['user_id']),FILTER_SANITIZE_SPECIAL_CHARS);

    if(isset($_POST['pw'])){
        //비밀번호가 있으면 해싱
        $hashed_pw = password_hash($_POST['pw'], PASSWORD_DEFAULT);
    }

    if(isset($board_id)) {
        //board_id가 있다는 것은 수정을 의미
        $sql = "UPDATE $db_inquiry SET user_id= ?, title = ? , detail= ? WHERE board_id= ? ";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $user_id,$title,$detail,$board_id);
    }
    else {
        //board_id가 없으니 새로 만드는 sql문
        $sql = "INSERT INTO $db_inquiry (user_id, title, detail,pw) VALUES ( ?, ?, ?,'$hashed_pw')";
        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, 'sss', $user_id,$title,$detail);
    }

    //sql문 실행
    if(mysqli_stmt_execute($stmt)) {
        //수정인 경우 바로 게시판 보이게 함
        if(isset($board_id)) {
            $_SESSION['write_error'] = '수정되었습니다!';
            header("Location: view_inquiry_board.php?index=$board_id");
        }
        else {
            $board_id = mysqli_insert_id($conn); // 새로 생성한 게시물의 id를 가져옴
            $_SESSION['write_error'] = '작성되었습니다!';
            header("Location: view_inquiry_board.php?index=$board_id");
        }
    } else {
        $_SESSION['write_error'] = '작성 중 오류가 발생하였습니다.';
        header("Location: view_inquiry_board.php");
    }

    mysqli_stmt_close($stmt);

    exit();
?>