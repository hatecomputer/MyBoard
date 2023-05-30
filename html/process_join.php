<?php
    include 'DB_INFO.php'; //데이터 베이스 정보

    session_start(); //세션 시작

    //데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password,$dbname);

    //데이터베이스 오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }
    
    
    //POST로 전달된 정보 받기
    $login_id = filter_var(strip_tags($_POST['id']),FILTER_SANITIZE_SPECIAL_CHARS);
    $login_pw = $_POST['pw'];
    $adr = trim(filter_var(strip_tags($_POST['address']),FILTER_SANITIZE_SPECIAL_CHARS));
    
    //비밀번호는 해싱
    $hashed_pw = password_hash($login_pw, PASSWORD_DEFAULT);

    //암호화 키
    $encryption_key = 'my_secret_key';
    
    //주소는 암호화
    $encrypted_address = openssl_encrypt($adr, 'aes-256-cbc', $encryption_key, OPENSSL_ZERO_PADDING, '1234567890123456');

    //ID 중복 검사용 sql문
    $check_id = "SELECT id FROM LOGIN_INFO WHERE id= ? ";

    $stmt = mysqli_prepare($conn,$check_id);
    mysqli_stmt_bind_param($stmt, 's', $login_id);
    mysqli_stmt_execute($stmt);

    //중복 검사 sql문 실행
    $result_id = mysqli_stmt_get_result($stmt);

    if(mysqli_num_rows($result_id) > 0 ) { 
        //중복이 있을때
        $_SESSION['join_error'] = '아이디가 중복입니다!';
        header("Location: join.php");
    } else {
        //중복이 아닐때
        //새로운 사용자를 데이터베이스에 삽입문
        $sql = "INSERT INTO $dbname (id, pw, adr)
        VALUES (?,'$hashed_pw','$encrypted_address')";

        $stmt2 = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt2, 's', $login_id);

        //sql문 실행
        if(mysqli_stmt_execute($stmt2)) {
            $_SESSION['join_error'] = '회원가입이 완료되었습니다!';
            header("Location: join.php");
        } else {
            $_SESSION['join_error'] = '회원가입 오류가 발생하였습니다.';
            header("Location: join.php");
        }

    }

    mysqli_stmt_close($stmt);
    mysqli_stmt_close($stmt2);

    //회원가입 후 닫기
    exit();
?>