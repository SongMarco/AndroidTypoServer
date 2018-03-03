<?php
include '../dbConnect2Member.php';




$setId = $_POST['setId'];

//$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  where id < 20 order by id" ;
$query = "delete from dbMember2.table_wordset where table_wordset.id_wordset = '$setId'";

$result = $db->query($query);

if (! $result) {

    $delete_msg = "del failed";
//    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
//    $message .= 'Whole query: ' . $query;
//    die ( $message );
}
else $delete_msg = "del success";

$delete_result = array('delete_msg'=>$delete_msg);

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
$json_result = json_encode ( $delete_result , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array
print( urldecode ( $json_result ) );

?>