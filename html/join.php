<!DOCTYPE html>
<html>
<head>
    <title>회원가입</title>
    <link rel="stylesheet" href = "/css/style_join.css">
</head>
<body>
    <h1>회원가입</h1>
    <form action="process_join.php" method="POST">
        
        <div class = "form-group">
            <label>ID:</label><br>
            <input type="text" name="id" placeholder="ID 입력" class="id-text" required><br><br>
       
            <label>비밀번호:</label><br>
            <input type="password" name="pw" class="id-text" required><br><br>
        </div>
    
        <div class = "adr-group">

            <div class = "adr-value">
                <div class = "adr-value2">
                    <label>주소:</label>
                    <div class = "adr-btn">
                        <input type="button" value="주소 찾기" onclick="search_address()"><br><br> <!-- 주소 찾기 버튼 -->
                    </div>
                </div>
                <input type="text" name="address" id="address" value="<?php echo $_GET['address']; ?>" class="adr-text" readonly> <!-- 검색된 주소를 표시할 입력란 -->
            
            </div>
            
        </div>

        <div class="ERROR-text">
            <?php session_start();
                if (isset($_SESSION['join_error'])) {
                    echo $_SESSION['join_error'];
                    unset($_SESSION['join_error']);
                }
            ?>
        </div>

        <div class = "join-btn-block">
            <input type="submit" value="회원가입" class = "join-btn">
        </div>
    </form>
    <script>
        function search_address() {
            window.open("search_address.php", "주소 찾기"); // 새로운 창에서 search_address.php 호출
            window.close();
        }
    </script>

    <form action="login.php" method="POST">
        <div class = "login-btn">
            <p><input type="submit" value="로그인하러가기" class="login-btn-set"></p>
        </div>
    </form>
</body>
</html>



