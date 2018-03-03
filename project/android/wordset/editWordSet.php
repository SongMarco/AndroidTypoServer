<?php
include '../dbConnect2Member.php';


//세트 id를 수정하는 스크립트



$setId = $_POST['setId'];
$nameWordSet = $_POST['nameWordSet'];

//세트 이름을 수정한다.
$sql = "UPDATE dbMember2.table_wordset SET 
 name_set = '$nameWordSet' WHERE id_wordset = '$setId'";

$result = $db->query($sql);

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