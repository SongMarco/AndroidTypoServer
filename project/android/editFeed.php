<?php
include 'dbConnect2Member.php';
session_start();

$feedID = $_POST['feedID'];
$writer = $_POST['writer'];
$email = $_POST['email'];
$title = $_POST['title'];
$content = $_POST['content'];
$imgUrl = $_POST['imgUrl'];


$profile_url = "http://115.68.231.13/project/android/profileimage/profile_".$email.'.png';

//$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  where id < 20 order by id" ;


$sql = "UPDATE dbMember2.table_newsfeed SET 
 title = '$title', text_content = '$content', img_url = '$imgUrl' WHERE id = '$feedID'";

$result = $db->query($sql);
if (! $result) {

    $delete_msg = "edit failed";
//    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
//    $message .= 'Whole query: ' . $query;
//    die ( $message );
}
else $delete_msg = "edit success";

$delete_result = array('delete_msg'=>$delete_msg);

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
$json_result = json_encode ( $delete_result , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array
print( urldecode ( $json_result ) );

?>