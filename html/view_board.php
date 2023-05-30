<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href = "/css/style_view.css">
        <title>게시물 보는중</title>
    </head>
    <body>
        <h1>VIEWING</h1>
        <p>
        <?php 

            include 'DB_INFO.php'; //데이터 베이스 정보

            //데이터베이스 연결
            $conn = mysqli_connect($host,$username,$password,$db_board);

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

            //GET방식으로 전달된 index 받는다
            $board_id = filter_var(strip_tags($_GET['index']),FILTER_SANITIZE_SPECIAL_CHARS);
            //가독성 위해 다른 변수에 저장
            $last_viewed_time_for_board_id = 'last_view_time_'.$board_id;

            // 세션에 마지막 조회 시간 정보가 있는지 확인
            if (!isset($_SESSION[$last_viewed_time_for_board_id])) {
                // 세션에 마지막 조회 시간 정보가 없으면 현재 시간을 저장
                $_SESSION[$last_viewed_time_for_board_id] = time();
            } else {
                // 세션에 마지막 조회 시간 정보가 있으면 일정 시간이 지났는지 확인
                $last_view_time = $_SESSION[$last_viewed_time_for_board_id];
                $current_time = time();
                $time_diff = $current_time - $last_view_time;
                if ($time_diff >= 60) { // 60초(1시간) 이상 지났으면 조회수 증가
                //조회수 증가하는 sql문
                $sql_view = "UPDATE $db_board SET views = views + 1 WHERE board_id = ? ";

                //prepared 적용
                $stmt = mysqli_prepare($conn, $sql_view);
                //바인딩
                mysqli_stmt_bind_param($stmt, 'i' , $board_id);
                //실행
                mysqli_stmt_execute($stmt);

                // 세션에 현재 조회 시간을 저장
                $_SESSION[$last_viewed_time_for_board_id] = $current_time;
                }
            }

            //작성된 게시물들 조회 문
            $sql = "SELECT * FROM $db_board WHERE board_id = ? ";
            //prepared 적용
            $stmt = mysqli_prepare($conn, $sql);
            //바인딩
            mysqli_stmt_bind_param($stmt, 'i' , $board_id);
            //실행
            mysqli_stmt_execute($stmt);
            //결과값 받기
            $result = mysqli_stmt_get_result($stmt);
            
            //게시물 출력
            while($row = mysqli_fetch_assoc($result)) {

            ?>
            <div class="view-top">
            <?php
                    echo '
                        <div class="view-top-title">'.$row['title'].'</div>

                        <div class="view-top2">
                            <div>ID: '.$row['id'].'</div>
                            
                            <div> 조회수: '.$row['views'].'</div>
                            
                            <div> 좋아요: '.$row['like_value'].'</div>
                            
                            <div> Date: '.$row['date_value'].'</div>              
                        </div>
                        <hr>
                        <div class="view-mid"> '.$row['detail'].' </div>
                        <hr>
                    ';

                

                if (isset($row['file_name'])) {
                    $file_name = implode('_', array_slice(explode('_', $row['file_name']), 1)); // '_' 문자를 기준으로 분리 후 첫 번째 요소를 제외한 나머지 요소를 모두 합쳐서 파일명을 구성합니다.
                    $download_url = 'download_process.php?filename='.$row['file_name'];
                    echo '
                        <div class="view-bottom"> FILE: <a href="'.$download_url.'">'.$file_name.'</a> </div>
                    
                    ';
                }
            ?>
                
                
                <div class="view-btn">
                    <!--게시물 좋아요 버튼을 보여준다-->
                    <form method='POST' action='like.php'>
                        <input type='hidden' name='board_id' value=' <?php echo $row['board_id'] ?> '>
                        <button>좋아요!</button>
                    </form>

                    <form action="write_board.php" method="POST"> 
                        <button name="write">게시판 작성</button>
                    </form>

                    <form action="board.php">
                        <button>메인페이지로</button>
                    </form>

            
            <?php


                //로그인한 사용자의 정보 가져온다
                $user_id = $_SESSION['login_id'];

                //게시물 작성자와 로그인한 ID와 일치한 경우
                if($row['id'] == $user_id) {
                    //게시물 수정 버튼을 보여준다
                    echo "<form method='GET' action='fix_board.php'>
                            <input type='hidden' name='board_id' value='".$row['board_id']."'>
                            <button>게시물 수정</button>
                          </form>";

                    //게시물 삭제 버튼을 보여준다
                    echo "<form method='POST' action='delete_board.php'>
                            <input type='hidden' name='board_id' value='".$row['board_id']."'>
                            <button>삭제</button>
                          </form>";
                }
                            
            }


            mysqli_stmt_close($stmt);
        ?>
                
            </div><!--view-btn의 div 종료점 입니다.-->
        </div> <!--view-top의 div 종료점 입니다.-->


        </p>
        <p>
        <?php session_start();
                if (isset($_SESSION['write_error'])) {
                    echo $_SESSION['write_error'];
                    unset($_SESSION['write_error']);
                }
        ?>
        </p>
        <p>
        <?php session_start();
                if (isset($_SESSION['file_error'])) {
                    echo $_SESSION['file_error'];
                    unset($_SESSION['file_error']);
                }
        ?>
    </body>
</html>
