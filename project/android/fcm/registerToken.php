<?php
include '../dbConnect2Member.php';
session_start();

// 토큰을 등록하는 php 코드
/*
 * 문제점 - 한 계정에 하나의 토큰이 바람직하지 않나?
 *
 * 토큰 정책을 결정해보자
 *
 * 1) 한 계정 1 토큰 : 동일 계정 여러 토큰으로 인한 문제 없음.
 *  그러나 여러 기기를 쓸 경우 가장 최근에 로그인 했던 하나의 기기에만 알림이 가게 됨
 *
 * 2) 한 계정 여러 토큰 : 여러 기기를 써도 커버되지만, 기존의 토큰을 언제 삭제할 지 결정하기 어려움
 * 로그아웃 할 때 세션의 토큰을 가진 레코드를 삭제하면 되지!
 *
 * 또한 여러 기기를 쓰는 상황은 자주 생기지 않는다.
 *
 * 추가해야 할 것 - 로그아웃 할 때 세션의 토큰을 가진 레코드 삭제하기. 세션 만료시키기
*/

ini_set("display_errors", 1);


$token = $_POST["Token"] or $_GET["Token"];

//이메일 정보와 기존 토큰을 세션에서 가져온다.
$email = $_SESSION['ses_email'];

//세션에서 이메일을 가져왔다면 로그인된 상태이므로, 그대로 DB를 갱신한다.
if($email){
    $sql = "INSERT INTO dbMember2.fcm_test (Token, member_email) Values ('$token', '$email' ) 
                ON DUPLICATE KEY UPDATE Token = '$token', member_email = '$email' ";

    $result = $db->query($sql);

}
// 세션에서 이메일을 못 가져왔다. 로그인을 안한 상태니까 토큰만 등록한다.
else{
    $sql = "INSERT INTO dbMember2.fcm_test (Token) Values ('$token') 
                ON DUPLICATE KEY UPDATE Token = '$token' ";

    $result = $db->query($sql);


}


?>