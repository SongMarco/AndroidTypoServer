<?php
ini_set("display_errors", 1);

$host ="localhost:3306";
$user = "root";
$password = "ehrhekrk527";
$database = "dbMember";

$db = mysqli_connect($host, $user, $password, $database);
//echo "db connection test<br>";
//if($db){
//    echo "connection success<br>";
//}
//else{
//    echo "connection FAILED <br>";
//}


mysqli_query($db, "SET NAMES UTF8");
// 데이터베이스 선택

// 세션 시작
session_start();

// 쿼리문 생성
$sql = "select * from member";

// 쿼리 실행 결과를 $result에 저장
$result = mysqli_query($db, $sql);
// 반환된 전체 레코드 수 저장.
$total_record = mysqli_num_rows($result);



// JSONArray 형식으로 만들기 위해서...
echo "{\"status\":\"OK\",\"num_results\":\"$total_record\",\"results\":[";

// 반환된 각 레코드별로 JSONArray 형식으로 만들기.
for ($i=0; $i < $total_record; $i++)
{
    // 가져올 레코드로 위치(포인터) 이동
    mysqli_data_seek($result, $i);

    $row = mysqli_fetch_array($result);




//    echo "{\"name\":$row[name],\"birthday\":\"$row[birthday]\"
//    ,\"email\":\"$row[email], \"password\":\"$row[password]\"}";
    echo "{\"email\":\"$row[email]\", \"password\":\"$row[password]\",
   \"name\":\"$row[name]\",\"birthday\":\"$row[birthday]\"}";

    // 마지막 레코드 이전엔 ,를 붙인다. 그래야 데이터 구분이 되니깐.
    if($i<$total_record-1){
        echo ",";
    }

}
// JSONArray의 마지막 닫기
echo "]}";

?>

