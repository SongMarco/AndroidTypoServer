<?php

include 'dbConnect2Member.php';

// 댓글을 불러오는 php




$commentID = $_POST['commentID'];

// 먼저 DB에서 해당 피드id를 지닌 댓글을 불러온다.
$query = "select * from dbMember2.table_comment WHERE subcomment_comment_id = '$commentID' AND depth = 2";
$result = $db->query($query);

////////테스트용 코드
//$query = "select * from dbMember2.table_comment WHERE subcomment_comment_id = '158' AND depth = 2";
//$result = $db->query($query);

//결과가 제대로 오지 않으면 에러메시지를 출력하고 종료
if (! $result) {
    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
    $message .= 'Whole query: ' . $query;
    die ( $message );
}

//
$num_rows = mysqli_num_rows($result);
// make json from database result set
$resultArray = array();
//
//array_push($resultArray, array("feedNum" => $num_rows) );

// fetch_assoc으로 반환된 row들의 정보를 배열로 빼낸다.
//while조건 : result의 row들을 빼낼 수 있을 때 계속 작동

while ( $row = mysqli_fetch_assoc ( $result ) ) {


    // row들로부터 피드들의 배열을 만들어낸다. 이후 json에 담겨짐
    //헷깔린다 -> 배열 안에 피드의 정보가 담긴 배열이 담겨있다.
    $arrayFeed = array (
        // comment ID : 대댓글이 달린 댓글의 ID값
        // subComment ID : 원래 대댓글의 ID값

        "commentID" => $row['subcomment_comment_id'],
        "subCommentID" => $row['id'],

        "writer" => urlencode($row ['writer']) ,
        "writer_email" => urlencode($row['writer_email']),

        "writer_profile_url" => urlencode($row['comment_profile_url']),

        "text_content" => urlencode ($row['comment_content']),

        "written_time" => urlencode($row['comment_written_time']),
        "depth" => urlencode($row['depth'])


    );

    array_push ( $resultArray, $arrayFeed );

}

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
//배열을 json으로 변경한다.
$json_result = json_encode ( $resultArray , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array

//결과값을 출력한다.(json 값)
print( urldecode ( $json_result ) );

?>