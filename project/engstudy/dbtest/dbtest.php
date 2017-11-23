<?php
echo "MySql 연결 테스트<br>";
$host = '127.0.0.1';
$user = 'root';
$passWord = 'dbdb';
$dbName = 'dbMember';




$db2 = mysqli_connect($host, $user,$passWord,$dbName);

if($db2){
    echo "connect : 성공<br>";
    echo "<p>connect =$dbName</p>";
}
else{
    echo "disconnect : 실패<br>";
}

$result = mysqli_query($db2, 'SELECT VERSION() as VERSION');

////$sql = "create table php_tbl(num int, name varchar(10))";
//
//mysqli_query($db, $sql);

$data = mysqli_fetch_assoc($result);
echo $data['VERSION'];
?>
