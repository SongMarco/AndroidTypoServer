<?php
require "./dbConnect2Member.php";
//ini_set("display_errors", 1);
session_start();

$login_info = array('email'=>$_SESSION['ses_email'], 'name'=>$_SESSION['ses_name'],
    'birthday'=>$_SESSION['ses_birthday'] );

$json_result=json_encode($login_info, JSON_UNESCAPED_UNICODE);
Header('Content-Type: application/json');

print $json_result;
//echo session_id();

?>
