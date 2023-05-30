<!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <link rel="stylesheet" href = "/css/style_board.css">
        <title>Welcome!</title>
    </head>
    <body>
        <h1>MENU</h1>
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
        ?>

        <form method ="GET" action="board.php" class="board-top">
            <input type = "text" name="search" class="board-top1" value="<?php echo filter_var(strip_tags($_GET['search']),FILTER_SANITIZE_SPECIAL_CHARS);?>" placeholder="검색" >
            <input type="submit" class="board-top2" value="검색">
            <select name="sort" onchange="this.form.submit()">
                <option value="">정렬 방식 선택</option>
                <option value="date" <?php if(filter_var(strip_tags($_GET['sort']),FILTER_SANITIZE_SPECIAL_CHARS)=='date'){echo ' selected';} ?> >날짜순</option>
                <option value="likes" <?php if(filter_var(strip_tags($_GET['sort']),FILTER_SANITIZE_SPECIAL_CHARS)=='likes'){echo ' selected';} ?> >추천순</option>
                <option value="author" <?php if(filter_var(strip_tags($_GET['sort']),FILTER_SANITIZE_SPECIAL_CHARS)=='author'){echo ' selected';} ?> >작성자순</option>
            </select>          
            <label for="date">날짜 선택:</label>
            <input type="date" id="date_value" name="date_value" value="<?php echo isset($_GET['date_value']) ? filter_var(strip_tags($_GET['sort']),FILTER_SANITIZE_SPECIAL_CHARS) : ''; ?>">
        </form>
        
        <div class = "board-title-bar">
            <div class= "board-title-bar1">제목</div>
            <div class= "board-title-bar2">작성자</div>
            <div class= "board-title-bar3">날짜</div>
            <div class= "board-title-bar4">조회수</div>
            <div class= "board-title-bar5">좋아요</div>
        </div>
                
        <?php 
            //한 페이지에 보여줄 게시물 수
            $num_per_page = 5;

            //현재 페이지 번호
            if(isset($_GET['page'])) {
                $page = mysqli_real_escape_string($conn,filter_var(strip_tags(intval($_GET['page'])),FILTER_SANITIZE_SPECIAL_CHARS));
            } else {
                $page = 1;
            }
            
            //검색이 입력된 경우
            if(isset($_GET['search'])) {
                $search = filter_var(strip_tags($_GET['search']),FILTER_SANITIZE_SPECIAL_CHARS);
                
                if(isset($_GET['date_value']) && strtotime($_GET['date_value'])) {
                    //날짜 선택한 경우, strtotime() 이용해 유효한 값인지 확인
                    $date_value = filter_var(strip_tags($_GET['date_value']),FILTER_SANITIZE_SPECIAL_CHARS);
                    $date_value = DateTime::createFromFormat('Y-m-d', $date_value)->format('Y-m-d'); //날짜 값으로 다시 바꾼다
                }
                else {
                    //날짜가 선택이 안된 경우
                    $date_value = '';
                }
            } else {
                //검색이 입력되지 않은 경우
                $search = '';
                $date_value = '';
            }
            //각 %을 붙여서 포함 된 문자열을 찾을 수 있게 한다
            $search_value = '%'.$search.'%';
            $date_value_value = '%'.$date_value.'%';


            $sql = "SELECT * FROM $db_board WHERE title LIKE ? AND date_value LIKE ? ";
            $total_sql = "SELECT count(*) AS cnt FROM $db_board WHERE title LIKE ? AND date_value LIKE ? ";

            $stmt2 = mysqli_stmt_init($conn); //preparedstatement 초기화 

            //total_sql문 preparedStatement 적용
            $stmt2 = mysqli_prepare($conn, $total_sql);
            mysqli_stmt_bind_param($stmt2, 'ss', $search_value , $date_value_value); //s는 string, i는 정수형을 뜻한다
            mysqli_stmt_execute($stmt2); //실행
            $total_result = mysqli_stmt_get_result($stmt2); //결과
            $total_row = mysqli_fetch_assoc($total_result); //결과를 배열로 가져온다
            $total_posts = $total_row['cnt']; //배열 중 cnt의 값을 가져온다

            //전체 페이지 수
            $total_pages = ceil($total_posts / $num_per_page);

            //각 페이지 시작 인덱스
            $start = ($page - 1) * $num_per_page;

            //정렬해주는 조건문
            if (isset($_GET['sort'])) {
                $sort = filter_var(strip_tags($_GET['sort']),FILTER_SANITIZE_SPECIAL_CHARS);
                if ($sort == 'date') {
                    //날짜순
                    $sql .= " ORDER BY date_value DESC";
                } else if ($sort == 'likes') {
                    //추천순
                    $sql .= " ORDER BY like_value DESC";
                } else if ($sort == 'author') {
                    //작성자순
                    $sql .= " ORDER BY id DESC";
                }
            } 
            
            $sql .= " LIMIT $start, $num_per_page "; //최대 5개씩 호출

            $stmt = mysqli_stmt_init($conn); //preparedstatement 초기화 

            //쿼리문 실행 preparedstatement 적용
            $stmt = mysqli_prepare($conn,$sql);
            mysqli_stmt_bind_param($stmt, 'ss',  $search_value , $date_value_value); //s는 string, i는 정수형을 뜻한다
            mysqli_stmt_execute($stmt);
            $result = mysqli_stmt_get_result($stmt);
            

            
            if(mysqli_num_rows($result) > 0) {
                //게시물 출력
                while($row = mysqli_fetch_assoc($result)) {
                    $index = $row['board_id'];
                    $id = $row['id'];
                    $title = $row['title'];
                    $like_value = $row['like_value'];
                    $date = $row['date_value'];
                    echo '

                    <div class="board-main">
                        <div class = "board-main1">
                            <a href="view_board.php?index='.$index.'">'.$title.'</a> 
                        </div>

                        <div class = "board-main2">
                            '.$id.'
                        </div>

                        <div class = "board-main3">
                            '.$date.'  
                        </div>

                        <div class = "board-main4">
                            '.$row['views'].'
                        </div>

                        <div class = "board-main5">
                            '.$like_value.'
                        </div>

                    </div>

                    ';

                }
            } else {
                echo "게시물이 없습니다!";
            }
            ?>

            <div class = "paging-num">
            <?php

            echo ' [ ';
            
            // 현재 페이지를 10으로 나눈 몫에 10을 곱한 값에서 1을 빼면
            // 현재 페이지가 몇 번째 페이지 블록에 있는지 알 수 있습니다.
            $block_start = floor(($page-1)/10)*10;

            if ($block_start > 1) {
                // 이전 페이지 블록이 있다면, 다음 버튼을 출력합니다.
                $next_block_start = $block_start - 10;
                if($next_block_start == 0) {
                    $next_block_start += 1; //0페이지는 존재 하지 않기에 1더한다
                }
                echo '<a href="?page=' . $next_block_start .'"><< </a>';
            }

            // 이전 버튼 출력
            if ($page > 1) {
                echo '<a href="?page=' . ($page-1) .'">< </a> ';
            }
            
            // 페이지 링크 출력
            for ($i = $block_start+1; $i <= min($block_start+10, $total_pages); $i++) {
                if($i == $page) {
                    echo '<strong>'.$i.' </strong>';
                } else {
                    echo '<a href="?page=' . $i .'">'.$i. '</a> ';
                }
                echo ' ';
            }

            // 다음 버튼 출력
            if ($page < $total_pages) {
                echo '<a href="?page=' . ($page+1) .'">> </a> ';
            }
            
            if ($block_start+10 < $total_pages) {
                // 다음 페이지 블록이 있다면, 다음 버튼을 출력합니다.
                $next_block_start = $block_start + 11;
                echo '<a href="?page=' . $next_block_start .'">>></a>';
            } 

            echo ' ]';

            mysqli_stmt_close($stmt); //preparedstatement 종료
            mysqli_stmt_close($stmt2);
            
        ?>

        </div>


        <p></p>
        <form action="write_board.php" method="POST"> 
            <p><input type="submit" name="write" value="게시판 작성"></p>
        </form>
        <form action="only_login.php"> 
            <p><input type="submit" value="메인페이지로"></p>
        </form>
        <form action="board.php" method="GET"> 
            <p><input type="submit" value="검색 초기화"></p>
            <input type="hidden" name="search" value="">
            <input type="hidden" name="sort" value="">
            <input type="hidden" name="date_value" value="">
        </form>
    </body>
</html>

