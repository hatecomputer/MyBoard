<?php
    $conn = mysqli_connect("localhost:3306","user2","elgbnas26!@","test");

    $sql =  "SELECT * FROM test";

    $result = mysqli_query($conn,$sql);

    while($row=mysqli_fetch_array($result)) {
        echo $row["id"],"   ", $row["title"],"   ",$row["description"],"   ",$row["created"];
   }
?>