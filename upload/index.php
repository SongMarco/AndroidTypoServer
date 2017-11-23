<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<?php
include "../dbconfig.php";
$result = $db->query("select * from test_bbs");

echo "<table border=1>";
while($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>".$row['bbsNo']."</td>";
    echo "<td>".$row['id']."</td>";
    echo "<td><a href='see.php?bbsno=".$row['bbsNo']."'>".$row['content']."</a></td>";
    echo "<td>".$row['regdate']."</td>";


    echo "</tr>";



}

echo "<tr>";

echo "<td><a href='form.php'>글쓰기</a></td>";



echo "</tr>";

?>