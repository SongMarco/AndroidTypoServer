<?php




include '../dbConnect2Member.php';
session_start();
ini_set("display_errors", 1);
// 가입된 그룹 목록을 가져오는 스크립트

// 그룹 목록은 게시물 목록에 비해 페이징의 필요성이 크지 않으므로,
// 일단 페이징 없이 구현해둔다. 필요시 구현할 것

$user_email =  $_SESSION['ses_email'];
//echo $owner_email;

//// 멤버가 가입한 그룹 목록을 가져온다.
//$query = "select id_group from dbMember2.table_group_member WHERE '$user_email' = email_member
//                                                   order by id_group DESC ";

//전체 그룹 목록을 가져온다.
$query = "select *from dbMember2.table_group order by id_group DESC ";
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

    //이 row 에는 사용자가 가입한 그룹의 id 값만 존재한다.
    // 그러므로 id 값을 이용하여 그룹의 정보를 가져오는 과정이 아래에서 수행됨

    //먼저 가져온 row에서 그룹의 id 값을 가져온다.
    $idGroup = $row ['id_group'];

    //사용자의 그룹 가입 여부를 확인한다.
    $query = "select * from dbMember2.table_group_member WHERE email_member = '$user_email' AND id_group = '$idGroup'";
    $resultApplied = $db->query($query);

    //해당 row 갯수를 세어 0보다 크면 -> 가입된 것임.
    if(mysqli_num_rows($resultApplied) > 0){

        $isMemberGroup='true';
    }
    else{
        $isMemberGroup='false';
    }


    // 각 그룹 row 의 정보를 배열에 담는다. 이 배열은 이후 결과배열(resultArray) 에 담기고, json 으로 변환한다.
    $arrayGroup = array (
        "id_group" => $row ['id_group'],

        "name_group" =>  urlencode ($row ['name_group']),

        "content_group" =>  urlencode ($row ['content_group']),

        "email_group_owner" => urlencode($row['email_group_owner']),

        "name_group_owner"=>urlencode($row['name_group_owner']),

        "num_group_members"=>urlencode($row['num_group_members']),

        "date_group_made"=>urlencode($row ['date_group_made']),

        "img_url_group"=>urlencode($row['img_url_group']),

        "isMemberGroup"=>urlencode($isMemberGroup)



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