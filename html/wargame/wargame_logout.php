<?php
    session_start(); //세선 시작

    // 로그아웃 버튼 클릭 세션 제거
    if(isset($_POST['logout'])) {
        session_unset();
        session_destroy();
        header("Location: wargame_loginsqli.php"); //로그인 페이지 이동
    }
    exit(); //코드 종료
?>