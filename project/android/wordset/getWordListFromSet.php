<?php

include '../dbConnect2Member.php';
session_start();
//ini_set("display_errors", 1);
// 단어장 목록을 가져오는 스크립트

// 단어장 목록은 게시물 목록에 비해 페이징의 필요성이 크지 않으므로,
// 일단 페이징 없이 구현해둔다. 필요시 구현할 것

$idWordSet = $_POST['idWordSet'];


    $_SESSION['ses_email'];
//echo $owner_email;

$query = "select * from dbMember2.table_stored_words WHERE '$idWordSet' = id_word_set
                                                   order by id_word_set DESC ";

//$query = "select * from dbMember2.table_wordset WHERE 'jamsya@naver.com' = email_set_owner
//                                                   order by id_wordset DESC ";

$result = $db->query($query);

//결과가 제대로 오지 않으면 에러메시지를 출력하고 종료
if (! $result) {
    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
    $message .= 'Whole query: ' . $query;
    die ( $message );
}

// make json from database result set
$resultArray = array();

// fetch_assoc으로 반환된 row들의 정보를 배열로 빼낸다.
//while조건 : result의 row들을 빼낼 수 있을 때 계속 작동





while ( $row = mysqli_fetch_assoc ( $result ) ) {

//피드의 번호와 타입이 맞는 좋아요를 찾는다.

    // row들로부터 피드들의 배열을 만들어낸다. 이후 json에 담겨짐
    //헷깔린다 -> 배열 안에 피드의 정보가 담긴 배열이 담겨있다.


    $idWord = $row['id_word_feed'];

//단어 이미지 url과 단어 뜻은 단어 id를 단어 테이블로 보내어 가져온다.
    $sql = "SELECT text_content, img_url from dbMember2.table_newsfeed WHERE id = '$idWord' ";

//$sql = "SELECT profile_url from dbMember2.member WHERE email = 'jamsya@naver.com' ";
    $resultWordInfo = $db->query($sql);
    $rowWordInfo = mysqli_fetch_array($resultWordInfo);

    //단어 이미지와 뜻을 변수에 세팅한다 -> 제이슨에 넣을 것.
    $img_url = $rowWordInfo['img_url'];
    $mean_word = $rowWordInfo['text_content'];

    $arrayFeed = array (
        "id_word" => $row ['id_word_feed'],

        "name_word" => urlencode( $row ['name_word']),

        "img_url"=> urlencode($img_url),
        "mean_word"=> urlencode($mean_word)

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