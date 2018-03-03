<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-13
 * Time: 오후 5:26
 */
include '../dbConnect2Member.php';
session_start();

//wordSet 은 클라이언트에서 보내온 string array List.
$wordSet = $_POST['listWord'];


//서버에서 반환할 단어장 리스트를 집어넣을 배열.
$resultArray = array();


// wordSet의 word를 조회하고, 이 word 가 단어 DB에 저장된지 확인한다.
foreach ($wordSet as $word) {

    //$word 가 조회한 단어가 된다.
    //단어를 db에서 확인한다.

    //단어 테이블의 단어명이 word 와 일치하는 지를 찾는다.
    $sql = "SELECT *from dbMember2.table_newsfeed where title = '$word'";

    $result = $db->query($sql);

    $num_rows = mysqli_num_rows($result);

    //num_rows > 0 이면 단어 DB에 $word 가 존재하는 것. -> json 에 해당 단어 세팅
    if ($num_rows > 0) {
        $row = mysqli_fetch_array($result);

        // row들로부터 피드들의 배열을 만들어낸다. 이후 json에 담겨짐
        //헷깔린다 -> 배열 안에 피드의 정보가 담긴 배열이 담겨있다.
        $arrayWordItem = array(
            //단어 id
            "idWord" => $row ['id'],

            //단어명
            "nameWord" => urlencode($row ['title']),

            //단어 뜻
            "meanWord" => urlencode($row['text_content']),


            //단어 이미지 url
            "imgUrl" => urlencode($row['img_url']),


        );

        // 제이슨에 넣을 단어 아이템 배열 세팅 완료. 배열에 단어 아이템 배열을 넣는다.
        array_push($resultArray, $arrayWordItem);
    }



    // 단어 테이블에 해당 단어가 존재하지 않는다.
    // 이 경우 단어 뜻은 구글 번역 api 로, 단어 이미지는 디폴트 이미지를 세팅한 뒤
    // 사용자가 스스로 이미지를 추가하고, 뜻을 (원한다면) 수정해야 한다.
    else{


        $arrayWordItem = array(
            //단어 id가 없으므로 -1 세팅해서 보냄(클라이언트에서 get Int 를 할 수 있도록)
            "idWord" => "-1",

            //단어명
            "nameWord" => urlencode($word),

            //단어 뜻
            "meanWord" =>"",

            //단어 이미지 url
            "imgUrl" => ""


        );

        // 제이슨에 넣을 단어 아이템 배열 세팅 완료. 배열에 단어 아이템 배열을 넣는다.
        array_push($resultArray, $arrayWordItem);

    }
}

//pretty print + 헤더 설정으로 제이슨 출력이 깔끔해진다!
//배열을 json으로 변경한다.
$json_result = json_encode($resultArray, JSON_PRETTY_PRINT);
Header('Content-Type: application/json');
// print result array

//결과값을 출력한다.(json 값)
print(urldecode($json_result));




?>