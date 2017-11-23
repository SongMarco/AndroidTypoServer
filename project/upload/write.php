<?php
$id = $_POST['id'];
$content = $_POST['content'];
ini_set("display_errors", 1);




include "../dbconfig.php";

// 데이터베이스에 게시판 제목 내용 넣는다.
$sql = "insert into test_bbs (id ,content) values( '$id', '$content')";
$result = $db->query($sql);


if($result){
    echo "test bbs insert succeedded";
}
else{
    echo "test bbs insert failed";
}


// 게시판 아이디를 얻고, 패스를 정하여 업로드한 파일을 옮겨준다.
// @@@@@@@@@@@@@@주의사항 @@@ :::: 반드시 해당 패스에 권한부여할것.
//ini_set("display_errors", 1); 이거로 에러를 반드시 확인할 것!!!!
////chmod -R 777 /app/apache/htdocs/project/engstudy/freeboard2/image_up

$bbsid = $db->insert_id;

$path = './testBBS';


//$path = "/testBBS";
$filename =  date("YmdHis").".jpg";
move_uploaded_file($_FILES['imageform']['tmp_name'],"$path/$filename");

$query = "insert into test_image (bbsNo,path,filename) values ('$bbsid', '$path','$filename')";

$result = $db->query($query);

if($result){
    echo "insert image success";
}

?>


<!DOCTYPE html>
<html>
<head lang="ko">
    <meta charset=utf-8">
    <title>게시물 작성 예제 폼</title>
</head>
<body>
<table>
    <tr>
        <td>전송아이디:</td>
        <td><?php echo $id;?></td>
    </tr>
    <tr>
        <td>전송내용:</td>
        <td><?php echo $content;?></td>
    </tr>
    <tr>
        <td>전송이미지</td>
        <?php echo $id;?>
        <td><img src="<?=$path."/".$filename;?>" style="width: 50%; height: auto;"/></td>





    </tr>
</table>
<p><b>전송완료</b></p>
<p><a href='index.php'>목록가기</a></p>
</body>
</html>
