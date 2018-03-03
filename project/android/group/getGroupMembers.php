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


// 그룹 멤버 테이블에서 그룹 멤버의 이름과 이메일을, 그룹 id를 이용하여 가져온다.
$query = "select * from dbMember2.table_group_member WHERE id_group= '$idGroup'
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

while ( $row = mysqli_fetch_array($result) ) {


    $emailMember = $row ['email_member'];

    //멤버 테이블에서 사용자의 이메일로 사용자의 프로필 사진 url 을 꺼낸다.
    $sql = "SELECT profile_url from dbMember2.member WHERE email = '$emailMember' ";
    $resultProfile = $db->query($sql);
    $rowProfile = mysqli_fetch_array($resultProfile);


    // 각 그룹 row 의 정보를 배열에 담는다. 이 배열은 이후 결과배열(resultArray) 에 담기고, json 으로 변환한다.
    $arrayGroup = array (
        "id_group" => $row ['id_group'],

        "name_member" =>  urlencode ($row ['name_member']),

        "email_member" =>  urlencode ($emailMember),

        "profile_url" => urlencode ($rowProfile['profile_url'])
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