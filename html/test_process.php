<?php
    include 'DB_INFO.php'; //데이터 베이스 정보
    
    $test = "test";
    //데이터베이스 연결
    $conn = mysqli_connect($host,$username,$password,$test);

    session_start(); //세션 시작
    //오류시 종료
    if(mysqli_connect_errno()) {
        die("데이터 베이스 오류: ". mysqli_connect_error());
    }
    //POST로 전달된 정보 받기
    $login_id = $_POST['id'];
    $login_pw = $_POST['pw'];

    /*1번째
    //ID 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE id='$login_id'";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);
        $pw = $row['pw'];
        if($login_pw==$pw) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*2번쨰
    //ID 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE (id='$login_id') ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);
        $pw = $row['pw'];
        if($login_pw==$pw) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    } */ 

    /*3번째
    //ID 찾는 쿼리문
    $sql = " SELECT id FROM test WHERE id='$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);$sql = "SELECT * FROM test WHERE id='admin' #
    AND pw = '$login_pw' ";

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);
        $pw = $row['pw'];
        if($login_pw==$pw) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*4번쨰
    //ID 찾는 쿼리문
    $sql = " SELECT id,pw FROM test WHERE id='$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);
        $pw = $row['pw'];
        if($login_pw==$pw) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*5번째
    //ID 찾는 쿼리문
    $sql = " SELECT id,pw FROM test WHERE (id='$login_id') ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증
        $row = mysqli_fetch_array($result);
        $pw = $row['pw'];
        if($login_pw==$pw) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $row['id'];
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*6번째
    //ID 찾는 쿼리문
    $sql = " SELECT * FROM test WHERE id='$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증용 sql
        $sql2 = " SELECT * FROM test WHERE pw='$login_pw' ";
        //쿼리 실행
        $result2 = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result2) > 0) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $login_id;
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*7번째
    //ID 찾는 쿼리문
    $sql = " SELECT * FROM test WHERE id='$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    //쿼리 실행 결과 확인
    if(mysqli_num_rows($result) > 0 ) { 
        //ID있으니 비밀번호 검증용 sql
        $sql2 = " SELECT * FROM test WHERE (pw='$login_pw') ";
        //쿼리 실행
        $result2 = mysqli_query($conn, $sql2);
        if(mysqli_num_rows($result2) > 0) {
            //로그인 성공
            session_regenerate_id(); //ID 자동 갱신
            $_SESSION['login_id'] = $login_id;
            header("Location: test_test.php");
        } else {
            //로그인 실패
            $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
            header("Location: test.php");
        }
    }
    else {
        //로그인 실패
        $_SESSION['login_error'] = '아이디 또는 비밀번호가 일치 하지 않습니다.';
        header("Location: test.php");
    }*/

    /*8번쨰
    //ID,PW 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE id='$login_id' AND pw = '$login_pw' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);

    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*9번쨰
    //ID,PW 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE (id='$login_id') AND (pw = '$login_pw') ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*10번째
    //ID,PW 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE id='$login_id'
    AND pw = '$login_pw' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*11번째
    //ID,PW 찾는 쿼리문
    $sql = "SELECT id,pw FROM test WHERE id='$login_id' AND pw = '$login_pw' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*12번째
    //ID,PW 찾는 쿼리문
    $sql = "SELECT id,pw FROM test WHERE (id='$login_id') AND (pw = '$login_pw') ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*13번째
    //ID,PW 찾는 쿼리문
    $sql = "SELECT id,pw FROM test WHERE id='$login_id'
    AND pw = '$login_pw' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*14번쨰
    //ID,PW 찾는 쿼리문
    $sql = "SELECT id,pw FROM test WHERE (id='$login_id')
    AND (pw = '$login_pw') ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/

    /*15번째
    //ID,PW 찾는 쿼리문
    $sql = "SELECT id,pw FROM test WHERE pw = '$login_pw' AND id = '$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/ 

    /*16번쨰
    //ID,PW 찾는 쿼리문
    $sql = "SELECT * FROM test WHERE pw = '$login_pw' AND id = '$login_id' ";

    //쿼리 실행
    $result = mysqli_query($conn, $sql);
    
    if(mysqli_num_rows($result) > 0) {
        //ID,PW가 있으니 로그인 성공
        $row = mysqli_fetch_array($result);
        session_regenerate_id(); //ID 자동 갱신
        $_SESSION['login_id'] = $row['id'];
        header("Location: test_test.php");
    } else {
        //로그인 실패
        $_SESSION['login_error'] = "비밀번호가 일치하지 않습니다.";
        header("Location: test.php");
    }*/




?>