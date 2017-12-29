<?php

include 'dbConnect2Member.php';

// 댓글을 불러오는 php




$feedID = $_POST['feedID'];

$type = 'feed';


// 먼저 DB에서 해당 피드를 좋아했던 사람 리스트를 불러온다.
$query = "select * from dbMember2.table_like WHERE like_type_id = '$feedID' AND like_type = '$type' ";
$result = $db->query($query);

////////테스트용 코드
//$query = "select * from dbMember2.table_like WHERE like_type_id = '414' AND like_type = '$type' ";
//$result = $db->query($query);


//결과가 제대로 오지 않으면 에러메시지를 출력하고 종료
if (! $result) {
    $message = 'Invalid query: ' . mysqli_error ($db) . "\n";
    $message .= 'Whole query: ' . $query;
    die ( $message );
}


// make json from database result set
$resultArray = array();
//
//array_push($resultArray, array("feedNum" => $num_rows) );

// fetch_assoc으로 반환된 row들의 정보를 배열로 빼낸다.
//while조건 : result의 row들을 빼낼 수 있을 때 계속 작동

while ( $row = mysqli_fetch_assoc ( $result ) ) {

    //result row 1개에서 이메일을 추출
    $email = $row['like_by_email'];

    //이메일로부터 사용자의 프로필 url, 이름을 꺼낸다.
    $sql = "SELECT profile_url, memberName, email from dbMember2.member WHERE email = '$email' ";
    $subResult = $db->query($sql);
    $subRow = mysqli_fetch_array($subResult);

    $profile_url = $subRow['profile_url'];
    $likerName = $subRow['memberName'];
    $likerEmail = $subRow['email'];

    // array에 사용자 정보를 집어넣는다.
    $arrayLikeList = array (
        "likerEmail" => $likerEmail,
        "likerName" => urlencode($likerName),
        "liker_profile_url" => $profile_url
    );

    array_push ( $resultArray, $arrayLikeList );

}

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
//배열을 json으로 변경한다.
$json_result = json_encode ( $resultArray , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array

//결과값을 출력한다.(json 값)
print( urldecode ( $json_result ) );

?>