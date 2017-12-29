<?php
session_start();
require "./dbConnect2Member.php";

/*
 * //이미지 업로드 용량 관리는 /etc/php.ini에서 할 것!!
// -> https://conory.com/blog/44009 참고
//

//* upload_max_filesize = 2M
//php 파일 업로드 최대용량입니다. 기본 2M... 이걸 필요한만큼 늘린다. 나는 사진을 위해 10메가 까지.
//
//
//* post_max_size = 8M
포스트 전송 최대용량

 *
 */
ini_set("display_errors", 1);

$file_path = "./profileimage/";
//$var = $_POST['result'];

$var = 'normal';
$email = $_SESSION['ses_email'];
//echo $email;


$file_name = basename( $_FILES['uploaded_file']['name']);
echo "file name = ".$file_name.'\n';
$file_path = $file_path . $file_name;
echo "file path = ".$file_path;

//unlink($file_path);

$url_path = "http://115.68.231.13/project/android/profileimage/".$file_name;
if(move_uploaded_file($_FILES['uploaded_file']['tmp_name'], $file_path)) {

    $result = array("result" => "success", "value" => $var, "path" => $url_path);
    $_SESSION['ses_profile_url'] = $url_path;
    $sql = "UPDATE dbMember2.member SET profile_url='$url_path' WHERE email='$email'";
    $db->query($sql);

} else{
    $result = array("result" => "error");
}
echo json_encode($result);
?>