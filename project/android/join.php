<?php
ini_set("display_errors", 1);

$host ="localhost:3306";
$user = "root";
$password = "ehrhekrk527";
$database = "dbMember";

$db = mysqli_connect($host, $user, $password, $database);
//echo "db connection test<br>";
//if($db){
//    echo "connection success<br>";
//}
//else{
//    echo "connection FAILED <br>";
//}

//mysqli_query($db, "SET NAMES UTF8");
// 데이터베이스 선택

// 세션 시작
session_start();


$email = $_POST['u_email'];
$pw = $_POST['u_pw'];
$pw_encrypted = md5($pw);
$name = $_POST['u_name'];
$birthday = $_POST['u_birthday'];




$sql = "INSERT INTO member(email, password, memberName, birthday) VALUES('$email', '$pw_encrypted', '$name', '$birthday')";

$result = mysqli_query($db, $sql);

if(!$result)
    die("mysql query error");
else
    echo "insert success"
?>


