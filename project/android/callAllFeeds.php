<?php

include 'dbConnect2Member.php';


//$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  where id < 20 order by id" ;
$query = "select id, writer, title, text_content from dbMember2.table_newsfeed  order by id desc limit 10";

$result = $db->query($query);

if (! $result) {
    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
    $message .= 'Whole query: ' . $query;
    die ( $message );
}

$num_rows = mysqli_num_rows($result);
// make json from database result set
$resultArray = array();
//
//array_push($resultArray, array("feedNum" => $num_rows) );

$num = 1;
while ( $row = mysqli_fetch_assoc ( $result ) ) {


    $arrayFeed = array (
        "feedNum" => $row ['id'],
        "writer" => urlencode($row ['writer']) ,
        "title" =>  urlencode ($row ['title']) ,
        "text_content" => urlencode ($row['text_content'])
    );

    array_push ( $resultArray, $arrayFeed );
    $num++;
}

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
$json_result = json_encode ( $resultArray , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array
print( urldecode ( $json_result ) );

?>