<?php

include 'dbConnect2Member.php';
session_start();
//ini_set("display_errors", 1);
// 뉴스피드를 불러오는 php

$searchWord = $_POST['searchWord'];

//$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  where id < 20 order by id" ;

// 먼저 DB에서 최근 10개의 뉴스피드를 불러온다.
$query = "select * from dbMember2.table_newsfeed WHERE title LIKE '%$searchWord%'";
$result = $db->query($query);


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

$email = $_SESSION['ses_email'];
$type = 'feed';

while ( $row = mysqli_fetch_assoc ( $result ) ) {


//피드의 번호와 타입이 맞는 좋아요를 찾는다.

    $typeID = $row ['id'];

    //isLiked 변수를 보내어 true 면 좋아요가 된 상태로, false 면 좋아요 되지 않은 상태로 클라이언트에서 세팅한다.
//    $sql = "SELECT *from dbMember2.table_like WHERE  like_type = '$type'
//                  AND like_type_id = '$typeID' AND like_by_email = '$email'   ";

    $sql = "SELECT count(*) FROM dbMember2.table_like WHERE  like_type = '$type'
    AND like_type_id = '$typeID' AND like_by_email = '$email' ";
    $result2 = $db->query($sql);
    $row2 = mysqli_fetch_assoc($result2);

    //좋아요를 찾았다면 이 피드에는 좋아요가 된 상태로 버튼을 세팅하게 한다.
    if( $row2['count(*)'] > 0 ){

        $isLiked = "true";
    }
    //좋아요를 못찾았다. 좋아요가 되지 않은 상태로 버튼을 세팅할 것이다.
    else{

        $isLiked = "false";
    }


    // row들로부터 피드들의 배열을 만들어낸다. 이후 json에 담겨짐
    //헷깔린다 -> 배열 안에 피드의 정보가 담긴 배열이 담겨있다.
    $arrayFeed = array (
        "feedNum" => $row ['id'],
        "writer" => urlencode($row ['writer']) ,
        "writer_profile" => urlencode($row['writer_profile_url']),
        "title" =>  urlencode ($row ['title']) ,
        "text_content" => urlencode ($row['text_content']),
        "imgUrl" => urlencode($row['img_url']),
        "written_time" => urlencode($row['feed_written_time']),
        "comment_num" => urlencode($row['comment_num']),
        "writer_email"=>urlencode($row['writer_email']),

        "feed_like" => urlencode($row['feed_like']),
        "is_liked"=>urlencode($isLiked)
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