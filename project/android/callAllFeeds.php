<?php

include 'dbConnect2Member.php';


$query = "select writer, title, text_content from dbMember2.table_newsfeed";
$result = $db->query($query);

if (! $result) {
    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
    $message .= 'Whole query: ' . $query;
    die ( $message );
}

// make json from database result set
$resultArray = array ();
while ( $row = mysqli_fetch_assoc ( $result ) ) {
    $arrayMiddle = array (
        "writer" => urlencode($row ['writer']) ,
        "title" =>  urlencode ($row ['title']) ,
        "text_content" => urlencode ($row['text_content'])
    );


    array_push ( $resultArray, $arrayMiddle );
}

// print result array
print_r ( urldecode ( json_encode ( $resultArray ) ) );

?>