<?php
include 'dbConnect2Member.php';
session_start();

$feedID = $_POST['feedID'];
$type = $_POST['type'];

echo 'feedID = '.$feedID;


$email = $_SESSION['ses_email'];


/*
 * 먼저, 게시물 ID에 작성자가 좋아요를 했는지를 검사한다.
 * table_like에서 작성자, 게시물 ID가 같은 경우를 찾는다.
 */

// delete를 시킨다. delete가 된다 -> 좋아요 취소 진행
// delete가 안된다 -> 좋아요 적용 진행


//$sql = "SELECT *from dbMember2.table_like WHERE  like_type = '$type'
//                  AND like_type_id = '$feedID' AND like_by_who = '$email'   ";
$sql = "DELETE from dbMember2.table_like WHERE  like_type = '$type'
                  AND like_type_id = '$feedID' AND like_by_email = '$email'   ";
$result = $db->query($sql);



//성공적으로 결과가 세팅된다면(좋아요 내역이 DB에서 삭제) 좋아요를 취소한다.
if($result){
    $sql = "UPDATE dbMember2.table_newsfeed SET 
 feed_like = feed_like -1 WHERE id = '$feedID'";

    $result = $db->query($sql);
}

//좋아요가 적용되지 않은 글이다. 좋아요를 적용한다.
else{
    //게시글의 좋아요 수를 1 증가시킨다.
    $sql = "UPDATE dbMember2.table_newsfeed SET 
 feed_like = feed_like +1 WHERE id = '$feedID'";

    $result = $db->query($sql);

    //좋아요 DB에 좋아요를 추가한다.

    $sql = "INSERT INTO dbMember2.table_like (like_type, like_type_id, like_by_email)
                                      VALUES ('$type', '$feedID','$email')";

    $result = $db->query($sql);


}

if (! $result) {

    $like_msg = "like failed";
//    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
//    $message .= 'Whole query: ' . $query;
//    die ( $message );
}
else $like_msg = "like success";

$like_result = array('like_msg'=>$like_msg);

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
$json_result = json_encode ( $like_result , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array
print( urldecode ( $json_result ) );

?>