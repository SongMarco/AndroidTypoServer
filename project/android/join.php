<?php
ini_set("display_errors", 1);

$host ="localhost:3306";
$user = "root";
$password = "ehrhekrk527";
$database = "dbMember2";

$db = mysqli_connect($host, $user, $password, $database);

session_start();


$email = $_POST['u_email'];
$pw = $_POST['u_pw'];

$name = $_POST['u_name'];
$birthday = $_POST['u_birthday'];

if($email){
    echo $email.$pw;
}
//이메일 중복체크
$sql = "SELECT * FROM member WHERE email = '{$email}'";
$res = $db->query($sql);
if($res->num_rows >= 1){
    echo "email exists";
    exit;
}


$sql = "INSERT INTO dbMember2.member(email, password, memberName, birthday) VALUES('$email', '$pw', '$name', '$birthday')";

$result = mysqli_query($db, $sql);

if(!$result)
    die("mysql query error");
else
    echo "insert success"
?>


