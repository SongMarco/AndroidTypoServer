<?php

include '../dbConnect2Member.php';
session_start();
//ini_set("display_errors", 1);
// 알림 목록을 불러오는 php

//$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  where id < 20 order by id" ;


// 알림 목록은 게시물 목록에 비해 페이징의 필요성이 크지 않으므로,
// 일단 페이징 없이 구현해둔다. 필요시 구현할 것

$owner_email =  $_SESSION['ses_email'];

$query = "select * from dbMember2.fcm_notice_list WHERE '$owner_email' = notice_owner_email
                                                   order by id DESC ";
//$query = "select * from dbMember2.fcm_notice_list WHERE 'hh@hh.com' = notice_owner_email order by id DESC;";
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


// fetch_assoc으로 반환된 row들의 정보를 배열로 빼낸다.
//while조건 : result의 row들을 빼낼 수 있을 때 계속 작동


while ( $row = mysqli_fetch_assoc ( $result ) ) {


//피드의 번호와 타입이 맞는 좋아요를 찾는다.




    // row들로부터 피드들의 배열을 만들어낸다. 이후 json에 담겨짐
    //헷깔린다 -> 배열 안에 피드의 정보가 담긴 배열이 담겨있다.
    $arrayFeed = array (
        "notice_id" => $row ['id'],

        // 이건 뉴스피드 작성자의 이메일이다.
        "notice_owner_email" => urlencode($row ['notice_owner_email']) ,

        "notice_commenter_email" => urlencode($row['notice_commenter_email']),

        "notice_content" => urlencode($row['notice_content']),


        "notice_word_name" => urlencode($row['word_name']),

        "notice_sender_profile_url" =>  urlencode ($row ['notice_sender_profile_url']) ,

        "to_where_activity" => urlencode ($row['to_where_activity']),

        "notice_date"=> urlencode($row['notice_date']),

        "feed_id" => urlencode($row['feed_id']),

        "comment_id" => urlencode( $row['comment_id'])


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