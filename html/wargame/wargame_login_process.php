<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    $username = 'root';
    $wardb = 'wargame';
    $host = 'localhost';
    $password = '!Kemalxo:(26';
    //데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password,$wardb);

    session_start(); //세션 시작
    //오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }
    //POST로 전달된 정보 받기
    $login_id = strip_tags($_POST['id']);
    $login_pw = strip_tags($_POST['pw']);

    //ID 찾는 쿼리문
    $sql = "SELECT * FROM login_info WHERE id = '$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);

        if($login_pw == $row['pw']) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: wargame_login_only.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: wargame_loginsqli.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: wargame_loginsqli.php");
    }
?>