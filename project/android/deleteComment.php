<?php
include 'dbConnect2Member.php';




$commentID = $_POST['commentID'];


/*
 depth 가 1일 때(댓글) 와, 2일 때(대댓글 혹은 답글)의 경우를 나누어 생각해야 한다
 */
$query = "select * from dbMember2.table_comment where table_comment.id = '$commentID'";
$result = $db->query($query);

$row = mysqli_fetch_assoc ( $result );

$depth = $row['depth'];

//삭제 - 댓글인 경우
/*
 * 댓글이 달린 게시물의 댓글수를 감소시키고 댓글을 삭제한다.
 */
if($depth == 1){

    $comment_feed_id = $row['comment_feed_id'];

//댓글이 달린 게시물을 찾아 댓글 수를 감소시키는 업데이트 쿼리문
    $query = "UPDATE dbMember2.table_newsfeed SET comment_num = comment_num-1   
              WHERE id ='$comment_feed_id' ";
    $result = $db->query($query);

    //댓글을 삭제하는 쿼리문
    $query = "delete from dbMember2.table_comment where table_comment.id = '$commentID'";
    $result = $db->query($query);
}

//삭제 - 답글(대댓글)인 경우
/*
 * 답글이 달린 댓글의 답글수를 감소시키고 답글을 삭제한다.
 */
else{
    $subcomment_comment_id = $row['subcomment_comment_id'];

    //답글이 달린 댓글을 찾아 답글 수를 감소시키는 업데이트 쿼리문
    $query = "UPDATE dbMember2.table_comment SET comment_subcomment_num = comment_subcomment_num-1   
              WHERE table_comment.id ='$subcomment_comment_id' ";
    $result = $db->query($query);

    //답글을 삭제하는 쿼리문
    $query = "delete from dbMember2.table_comment where table_comment.id = '$commentID'";
    $result = $db->query($query);

}


$query = "delete from dbMember2.table_comment where table_comment.id = '$commentID'";
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