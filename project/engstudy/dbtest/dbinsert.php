<?php
$host="127.0.0.1";
$user="root";
$password="dbdb";
$database = "dbtest";


$dbconn = mysqli_connect( $host, $user, $password, $database);
$query = mysqli_query($dbconn, 'set names utf8')
or die("encoding change failed");



$sql="insert into php_tbl values(6, '프라다')";
$query = mysqli_query($dbconn, $sql)
or die("데이터베이스 연결중 문제가 발생했습니다. 함수 및 데이터베이스 확인을해주세요.");


?>

<script>
    alert("DB 입력 성공! mysql에서 확인해보세요!");
</script>
