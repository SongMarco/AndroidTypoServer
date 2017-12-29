<?php
include 'dbConnect2Member.php';
session_start();

$commentID = $_POST['commentID'];
$content = $_POST['content'];

echo $commentID.$content;
$sql = "UPDATE dbMember2.table_comment SET 
 comment_content = '$content' WHERE id = '$commentID'";

$result = $db->query($sql);
if (! $result) {

    $edit_msg = "edit failed";
//    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
//    $message .= 'Whole query: ' . $query;
//    die ( $message );
}
else $edit_msg = "edit success";

$delete_result = array('edit_msg'=>$edit_msg);

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
$json_result = json_encode ( $delete_result , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array
print( urldecode ( $json_result ) );

?>