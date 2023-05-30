<?php
    if(isset($_GET['filename'])) {
        // 파일 이름 및 경로 가져오기
        $filename = basename(filter_var(strip_tags($_GET['filename']),FILTER_SANITIZE_SPECIAL_CHARS));
        $filepath = '/path/to/upload/directory/'.$filename;
    
        // 파일이 존재하는지 확인
        if(file_exists($filepath)) {
            // 다운로드 헤더 설정
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.$filename.'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            readfile($filepath);
            exit;
        } else {
            echo '파일이 존재하지 않습니다.';
        }
    } else {
        echo '파일 이름이 전달되지 않았습니다.';
    }
?>