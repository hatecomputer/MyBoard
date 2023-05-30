<!DOCTYPE html>
<html>
<head>
    <title>주소찾기</title>
</head>
<body>
    <h1>주소찾기</h1>
    <form action="search_address.php" method="GET">
        <label>주소입력: </label>
        <p><input type="text" name="search" placeholder="주소 입력" required></p>
        <input type="submit" value="검색">
    </form>
    <?php
        include 'DB_INFO.php';

        //데이터베이스 연결
        $conn = mysqli_connect($host,$username,$password,$db_address);

        //데이터베이스 오류시 종료
        if(mysqli_connect_errno()) {
            die("데이터 베이스 오류: ". mysqli_connect_error());
        }
        
        //검색이 입력된 경우
        if(isset($_GET['search'])) {
            $search = filter_var(strip_tags($_GET['search']),FILTER_SANITIZE_SPECIAL_CHARS);
        } else {
            //검색이 입력되지 않은 경우
            $search = '';
        }

        $sql = "SELECT *
                FROM 우편번호
                WHERE CONCAT(우편번호,' ',시도,' ',시군구,' ',읍면,' ',도로명) LIKE ? limit 0,50";

        $search_value = '%'.$search.'%';

        $stmt = mysqli_prepare($conn,$sql);
        mysqli_stmt_bind_param($stmt, 's' , $search_value);
        mysqli_stmt_execute($stmt);

        //쿼리문 실행
        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {
            //주소 출력
            while($row = mysqli_fetch_assoc($result)) {

                $address = $row['우편번호'].' '.$row['시도'].' '.$row['시군구'].' '.$row['읍면'].' '.$row['도로명'];

                echo '<p><a href="join.php?address='.$address.'">'.$address.'</a></p>';

            }
        } else {
            echo "주소가 없습니다!";
        }

        mysqli_stmt_close($stmt);
    ?>
</body>
</html>
