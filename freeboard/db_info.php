<?
$host = '127.0.0.1';
$user = 'root';
$passWord = 'dbdb';
$dbName = 'dbMember';

$conn = new mysqli($host,$user,$passWord,$dbName);
$query = mysqli_query($conn, 'set names utf8');

?>
