<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2018-01-14
 * Time: 오전 1:29
 */


include '../dbConnect2Member.php';
session_start();
ini_set("display_errors", 1);

//wordSet 은 클라이언트에서 보내온 string array List.
$wordSet = $_POST['listWord'];

$emailSetOwner = $_SESSION['ses_email'];
$nameSetOwner = $_SESSION['ses_name'];

// 단어장 이름을 정하지 않았다. - 클라이언트에 추가할 것
$nameWordSet = "문자인식 단어장";

//먼저, 새 단어장을 생성한다.

//db에 단어장 정보를 저장
$sql = "INSERT INTO dbMember2.table_wordset
      ( email_set_owner,   name_set_owner, name_set, date_set_made  ) 
VALUES('$emailSetOwner', '$nameSetOwner', '$nameWordSet', '$dateGroupMade' )";

$result = $db->query($sql);


//단어장 주인 메일과 만들어진 시각 기준으로 단어장의 id 값을 가져온다.

$sql = "select id_wordset from dbMember2.table_wordset WHERE date_set_made = '$dateGroupMade' 
                                                        AND email_set_owner = '$emailSetOwner'";
$result = $db->query($sql);

$row = mysqli_fetch_array($result);
$idWordSet = $row['id_wordset'];


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

        $idWord = $row['id'];
        $nameWord = $row['title'];

//단어와 단어장을 table_stored_words 테이블에 저장한다.
//이 테이블은 단어가 어떤 단어장에 담겨있는지를 저장한 장부 역할을 한다.
//추후 단어장 화면에서 단어를 세팅할 때 이곳을 조회한다.

        $sql = "INSERT INTO dbMember2.table_stored_words 
        (id_word_set, id_word_feed  ,name_word, name_word_set, email_set_owner)
 VALUES ('$idWordSet', '$idWord' ,'$nameWord', '$nameWordSet', '$emailSetOwner' )";

        $result = $db->query($sql);


        //단어-단어장 테이블에 저장 완료.

        /*
         * 단어장 테이블의 단어 수를 증가시킨다.
         */
        $sql = "UPDATE dbMember2.table_wordset SET 
 num_set_words = num_set_words+1 WHERE name_set = '$nameWordSet' 
                                   AND email_set_owner = '$emailSetOwner'";

        $result = $db->query($sql);

    }

    // 단어 테이블에 해당 단어가 존재하지 않는다.
    // 이 경우 단어 뜻은 구글 번역 api 로, 단어 이미지는 디폴트 이미지를 세팅한 뒤
    // 사용자가 스스로 이미지를 추가하고, 뜻을 (원한다면) 수정해야 한다.
    else {


    }
}


?>