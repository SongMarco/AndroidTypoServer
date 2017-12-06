<?php


$host = '127.0.0.1:3306';
$user = 'root';
$passWord = 'ehrhekrk527';
$dbName = 'dbMember';

$db = new mysqli($host,$user,$passWord,$dbName);
if($db->connect_error) {
    die('데이터베이스 연결에 문제가 있습니다.\n관리자에게 문의 바랍니다.');
}


$db->set_charset('utf8');
//
?>
