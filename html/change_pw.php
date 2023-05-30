<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Welcome! HACKER!</title>
    </head>
    <body>
        <h1>MY PAGE!</h1>
        <p>
        <?php 
            include 'DB_INFO.php'; //데이터 베이스 정보

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$dbname); //로그인
   
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
        ?>
        </p>
        <form action="change_pw.php" method="POST"> 
            <p><input type="password" name="old_pw" placeholder="기존 PW입력" required></p>
            <p><input type="password" name="new_pw" placeholder="변경할 PW" required></p>
            <p><input type="submit" value="수정하기"></p>
        </form>
        
        <p></p>
        <form action="only_login.php">
            <p><input type="submit" value="메인으로 돌아가기"></p>
        </form>
        
        <?php
            if(isset($_POST['new_pw']) && isset($_POST['old_pw'])) {
                $login_id = $_SESSION['login_id'];

                //PW 찾는 쿼리문
                $sql = "SELECT pw FROM LOGIN_INFO WHERE id='$login_id'";

                //쿼리 실행
                $result = mysqli_query($conn, $sql);

                //쿼리 실행 결과 확인
                if(mysqli_num_rows($result) > 0 ) { 
                    $row = mysqli_fetch_array($result)  ;
                    $hashed_pw = $row['pw']; //결과 배열 중 pw을 가져온다

                    //old_pw와 hashed_pw 비교
                    if(password_verify($_POST['old_pw'],$hashed_pw)) {
                        //일치시

                        //비밀번호는 해싱
                        $hashed_pw = password_hash($_POST['new_pw'], PASSWORD_DEFAULT);

                        $sql = "UPDATE LOGIN_INFO SET pw = '$hashed_pw' WHERE id = '$login_id' ";

                        //sql 실행
                        if(mysqli_query($conn,$sql)) {
                            $_SESSION['write_error'] = "PW가 수정 됬습니다!";
                        } else {
                            //실패시
                            $_SESSION['write_error'] = '작성 중 오류가 발생하였습니다.';
                        }
                        
                        //전 페이지로 이동
                        header("Location: my_info.php");
                        exit();                                            
                
                    } else {
                        //불일치
                        $_SESSION['write_error'] = "비밀번호가 일치하지 않습니다.";
                    }
                }
                
            }
        ?>
        <p></p>
        <?php 
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
    </body>
</html>