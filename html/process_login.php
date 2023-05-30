<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    //데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password,$dbname);

    session_start(); //세션 시작
    //오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }
    //POST로 전달된 정보 받기
    $login_id = filter_var(strip_tags($_POST['id']),FILTER_SANITIZE_SPECIAL_CHARS);
    $login_pw = $_POST['pw'];

    //ID 찾는 쿼리문
    $sql = "SELECT * FROM LOGIN_INFO WHERE id= ? ";

    $stmt = mysqli_prepare($conn,$sql);

    mysqli_stmt_bind_param($stmt, 's', $login_id);
    mysqli_stmt_execute($stmt);

    //쿼리 실행
    $result = mysqli_stmt_get_result($stmt);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result)  ;
        $hashed_pw = $row['pw']; //결과 배열 중 pw을 가져온다
        if(password_verify($login_pw,$hashed_pw)) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: only_login.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: login.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: login.php");
    }

    mysqli_stmt_close($stmt);
?>