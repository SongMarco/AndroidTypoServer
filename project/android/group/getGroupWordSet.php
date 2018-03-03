<?php




include '../dbConnect2Member.php';
session_start();
ini_set("display_errors", 1);
// 그룹의 단어장 리스트를 가져오는 스크립트

// 단어장 목록은 게시물 목록에 비해 페이징의 필요성이 크지 않으므로,
// 일단 페이징 없이 구현해둔다. 필요시 구현할 것





$user_email =  $_SESSION['ses_email'];
//echo $owner_email;


//클라이언트가 post로 보내온 내용을 변수에 담는다. (그룹 이름, 그룹 설명, 그룹 이미지)
$idGroup = $_POST['idGroup'];


// 그룹에 포함된 단어장의 이름들을 가져온다.
$query = "select name_wordset from dbMember2.table_group_wordset WHERE id_group= '$idGroup'
                                                   order by id_group DESC ";

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

while ( $rowSetName = mysqli_fetch_row ( $result ) ) {

    //이 row 에는 사용자가 가입한 그룹의 id 값만 존재한다.
    // 그러므로 id 값을 이용하여 그룹의 정보를 가져오는 과정이 아래에서 수행됨

    //먼저 가져온 row에서 그룹의 id 값을 가져온다.
    $nameWordSet = $rowSetName[0];

    //단어장 이름 값으로 단어장 테이블로부터 단어장 정보를 가져온다.

    $query = "SELECT *from dbMember2.table_wordset WHERE name_set = '$nameWordSet' ";

    $resultGroup = $db->query($query);

    // 쿼리문의 결과를 fetch하여 row를 취한다.
    $row = mysqli_fetch_array($resultGroup);

    // 단어장 주인의 이메일을 가져오고, 이 이메일로 단어장 주인의 프로필 사진을 가져온다.
    $emailSetOwner = $row ['email_set_owner'];

    //프로필 이미지 url은 이메일을 멤버 DB로 보내어 가져온다.
    $sql = "SELECT profile_url from dbMember2.member WHERE email = '$emailSetOwner' ";

    $resultImgProfile = $db->query($sql);

    $rowImgProfile = mysqli_fetch_array($resultImgProfile);


    // 각 그룹 row 의 정보를 배열에 담는다. 이 배열은 이후 결과배열(resultArray) 에 담기고, json 으로 변환한다.
    $arrayGroup = array (
        "id_wordset" => $row ['id_wordset'],

        "name_set" =>  urlencode ($row ['name_set']),

        "email_set_owner" =>  urlencode ($row ['email_set_owner']),

        "name_set_owner" => urlencode($row['name_set_owner']),

        "num_set_like"=>urlencode($row['num_set_like']),

        "num_set_words"=>urlencode($row['num_set_words']),

        "date_set_made"=>urlencode($row['date_set_made']),

        "owner_img_profile" => urlencode($rowImgProfile['profile_url'])


    );

    //그룹 정보를 담은 배열을, 결과 배열에 담는다. -> 이 결과 배열은 json 으로 변환 후 전송.
    array_push ( $resultArray, $arrayGroup );

}

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
//배열을 json으로 변경한다.
$json_result = json_encode ( $resultArray , JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array

//결과값을 출력한다.(json 값)
print( urldecode ( $json_result ) );

?>