<?php
$bbsno = $_GET['bbsno'];
include "../dbconfig.php";
$result = $db->query("select * from test_bbs where bbsNo=".$bbsno);
$row = $result->fetch_assoc();

$result = $db->query("select * from test_image where bbsNo=".$bbsno);
$row2 = $result->fetch_assoc();
?>
<html xmlns:height="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<title>게시물 보기</title>
</head>
<body>
<table>
<tr>
	<td>번호</td>
	<td><?=$row['bbsNo'];?></td>
</tr>
<tr>
	<td>아이디</td>
	<td><?=$row['id'];?></td>
</tr>
<tr>
	<td>내용</td>
	<td><?=$row['content'];?></td>
</tr>
<tr>
	<td>작성시간</td>
	<td><?=$row['regdate'];?></td>
</tr>
<tr>
	<td>이미지</td>
	<td>
<?php
if(!empty($row2)){
//    echo "<img src='".$row2['path']."/".$row2['filename']."' style=\"max-width: 70%; height: auto;\" />";

	?>
    <img src='<?php echo $row2['path']."/".$row2['filename']?>' style="max-width: 400px; height: auto;" />

    <?php


}
else
	echo "이미지 없음";

?>

	</td>
</tr>
</table>

<p><a href='index.php'>목록가기</a></p>

</body>
</html>
