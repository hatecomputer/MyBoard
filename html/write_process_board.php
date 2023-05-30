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
    if(isset($_POST['board_id'])){
        $board_id = filter_var(strip_tags($_POST['board_id']),FILTER_SANITIZE_SPECIAL_CHARS);
    } else {
        $board_id = null;
    }
    $title = filter_var(strip_tags($_POST['title']),FILTER_SANITIZE_SPECIAL_CHARS);
    $detail = filter_var(strip_tags($_POST['detail']),FILTER_SANITIZE_SPECIAL_CHARS);

    if ($_SERVER['REQUEST_METHOD'] == 'POST' && !empty($_FILES['file'])) {
        // 업로드된 파일 정보 가져오기
        $file_name = $_FILES['file']['name'];
        $timestamp = time(); // 현재 시간을 초로 반환
        $new_file_name = $timestamp . '_' . $file_name; // 현재 시간과 원래 파일 이름을 합쳐 새로운 파일 이름 생성
        $file_tmp_name = $_FILES['file']['tmp_name'];
        $file_size = $_FILES['file']['size'];
        $file_error = $_FILES['file']['error'];
        $allowed_mime_types = ['image/jpeg', 'image/png', 'image/gif','text/plain','application/zip','application/x-hwp','application/msword','application/vnd.ms-excel','application/pdf']; //MIME 허락 된 것
        //확장자 허락 된 것
        $allowed_extensions = array("jpg","png","gif","txt","zip","hwp","word","xls","xlsx","pdf");

        //sql공격 방지용
        $new_file_name = mysqli_real_escape_string($conn,$new_file_name);

        // 파일 업로드가 정상적으로 처리되었는지 확인
        if ($file_error === UPLOAD_ERR_OK) {
            // 파일 MIME 타입 확인, 조작됬는지 확인
            $file_mime_type = mime_content_type($file_tmp_name);
            $finfo = finfo_open(FILEINFO_MIME_TYPE);
            $file_mime_type = finfo_file($finfo, $file_tmp_name);
            finfo_close($finfo);
            
            if (in_array($file_mime_type, $allowed_mime_types)) {

                //파일 확장자 확인
                $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
                if(in_array($file_ext, $allowed_extensions)) {
                // 파일 저장 경로
                $upload_path = '/path/to/upload/directory/' . $new_file_name;

                    // 파일 이동 및 저장
                    if (move_uploaded_file($file_tmp_name, $upload_path)) {
                        $_SESSION['file_error'] =  '파일 업로드 성공';
                    } else {
                        $_SESSION['file_error'] =  '파일 업로드 실패';
                    }
                } else {
                    $_SESSION['file_error'] =  '잘못된 파일 형식입니다';
                }
            } else {
                $_SESSION['file_error'] =  '잘못된 파일 형식입니다';
            }
        }
    }
    //session으로 유저 이름 받기
    $user_id = $_SESSION['login_id'];

    if(isset($board_id)) {
        //board_id가 있다는 것은 수정을 의미
        $sql = "UPDATE $db_board SET title = ?, detail= ?, file_name= ? WHERE board_id= ? ";
        //preparedstatement 적용
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'sssi', $title, $detail, $new_file_name, $board_id);
    }
    else {
        //board_id가 없으니 새로 만드는 sql문
        $sql = "INSERT INTO $db_board (id, title, detail,file_name) VALUES (?, ?, ?,?)";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, 'ssss', $user_id ,$title, $detail, $new_file_name);
    }

    //sql문 실행
    if(mysqli_stmt_execute($stmt)) {
        //수정인 경우 바로 게시판 보이게 함
        if(isset($board_id)) {
            $_SESSION['write_error'] = '수정되었습니다!';
            header("Location: view_board.php?index=$board_id");
        }
        else {
            $board_id = mysqli_insert_id($conn); // 새로 생성한 게시물의 id를 가져옴
            $_SESSION['write_error'] = '작성되었습니다!';
            header("Location: view_board.php?index=$board_id");
        }
    } else {
        $_SESSION['write_error'] = '작성 중 오류가 발생하였습니다.';
        header("Location: view_board.php");
    }

    mysqli_stmt_close($stmt);

    exit();
?>