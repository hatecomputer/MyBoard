<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>주소 검색</title>
    <script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=c1f446298e730adc6c1b208150504fe2"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <form method="post">
        <label for="address">주소 검색</label>
        <input type="text" name="address" id="address">
        <button type="button" onclick="searchAddress()">검색</button>
        <input type="submit" value="확인">
    </form>
    <div id="map" style="width:100%;height:300px;"></div>
    <script>
        function searchAddress() {
            new daum.Postcode({
                oncomplete: function(data) {
                    var fullAddress = data.address; // 선택한 주소 전체 주소 변수에 담기
                    document.getElementById('address').value = fullAddress; // 주소 입력란에 값 넣기
                    var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
                    mapOption = {
                        center: new daum.maps.LatLng(data.y, data.x), // 지도의 중심좌표
                        level: 5 // 지도의 확대 레벨
                    };  
                    var map = new daum.maps.Map(mapContainer, mapOption); // 지도 생성
                    var markerPosition  = new daum.maps.LatLng(data.y, data.x); // 마커 위치
                    var marker = new daum.maps.Marker({ position: markerPosition }); // 마커 생성
                    marker.setMap(map); // 지도에 마커 표시
                }
            }).open();
        }
    </script>
    <script type="text/javascript" src="//t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
</body>
</html>