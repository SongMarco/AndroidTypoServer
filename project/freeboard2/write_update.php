<?php
	include"../dbconfig.php";

	include "../include/session.php";
//ini_set("display_errors", 1);

	//$_POST['bno']이 있을 때만 $bno 선언
	if(isset($_POST['bno'])) {
		$bNo = $_POST['bno'];

        // 게시판 이미지 불러오기. isset(row2)를 통해 기존 이미지 유무 확인 가능.
        $result2 = $db->query("select * from test_image where bbsNo=".$bNo);
        $row2 = $result2->fetch_assoc();
	}

	//bno이 없다면(글 쓰기라면) 변수 선언
	if(empty($bNo)) {
		$bID = $_POST['bID'];
		$date = date('Y-m-d H:i:s');
	}

	//항상 변수 선언
	$bPassword = $_POST['bPassword'];
	$bTitle = $_POST['bTitle'];
	$bContent = $_POST['bContent'];





//글 수정
if(isset($bNo)) {
	//수정 할 글의 비밀번호가 입력된 비밀번호와 맞는지 체크
	$sql = 'select count(b_password) as cnt from board_free where b_password=password("' . $bPassword . '") and b_no = ' . $bNo;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();
	
	//비밀번호가 맞다면 업데이트 쿼리 작성
	if($row['cnt']) {
		$sql = 'update board_free set b_title="' . $bTitle . '", b_content="' . $bContent . '" where b_no = ' . $bNo;
		$msgState = '수정';
	//틀리다면 메시지 출력 후 이전화면으로
	} else {
        $sql = 'update board_free set b_title="' . $bTitle . '", b_content="' . $bContent . '" where b_no = ' . $bNo;
        $msgState = '수정';
	}
	
//글 등록
} else {
	$sql = 'insert into board_free (b_no, b_title, b_content, b_date, b_hit, b_id) values(null, "' . $bTitle . '", "' . $bContent . '", "' . $date . '", 0 ,"' . $_SESSION['ses_userName'] . '" )';
	$msgState = '등록';



}

//메시지가 없다면 (오류가 없다면)
if(empty($msg)) {
	$result = $db->query($sql);
	
	//쿼리가 정상 실행 됐다면,
	if($result) {
		$msg = '정상적으로 글이 ' . $msgState . '되었습니다.';
        //쓰기모드였으면 bno를 새로 세팅한다.


        //신규 작성!!@@
		if(empty($bNo)) {
			$bNo = $db->insert_id;

//// 게시판 아이디를 얻고, 패스를 정하여 업로드한 파일을 옮겨준다.

            $path = '../assets/img';


//$path = "/testBBS";
            $filename =  $_FILES['imageform']['name'];
            $move = move_uploaded_file($_FILES['imageform']['tmp_name'],"$path/$filename");


            //파일이 진짜 옮겨졌을때, 즉 파일이 존재할 때에만 쿼리를 날려라!
            if($move){
                $query = "insert into test_image (bbsNo,path,filename) values ('$bNo', '$path','$filename')";

                $imgresult = $db->query($query);
            }
        }
        //수정모드다. 기존 이미지가 수정됬다면 수정을 가해야한다.
        else
            {

                //기존에 세팅된 이미지가 존재한다면 수정으로 쿼리날리기.
                if(isset($row2)){


                    $path = './image_up';


//$path = "/testBBS";
                    $filename =  date("YmdHis").".jpg";
                    $move = move_uploaded_file($_FILES['imageform']['tmp_name'],"$path/$filename");


                    //파일이 진짜 옮겨졌을때, 기존 이미지를 삭제하고, 업데이트로 쿼리날린다.
                    if($move){
//                        $query = "insert into test_image (bbsNo,path,filename) values ('$bNo', '$path','$filename')";
//

                        unlink($row2['path']."/".$row2['filename']);

                        $query = "UPDATE test_image SET path = '$path', filename = '$filename' WHERE bbsNo = $bNo;";
                        $imgresult = $db->query($query);
                    }


                }
                //기존에 세팅된 게 없다면 그대로 이미지 올리기.
                else
                    {

                        $path = './image_up';


//$path = "/testBBS";
                    $filename =  date("YmdHis").".jpg";
                    $move = move_uploaded_file($_FILES['imageform']['tmp_name'],"$path/$filename");


                    //파일이 진짜 옮겨졌을때, 즉 파일이 존재할 때에만 쿼리를 날려라!
                    if($move){



                        $query = "insert into test_image (bbsNo,path,filename) values ('$bNo', '$path','$filename')";

                        $imgresult = $db->query($query);
                    }

                }
            //// 게시판 아이디를 얻고, 패스를 정하여 업로드한 파일을 옮겨준다.

        }


		$replaceURL = './read.php?bno=' . $bNo;
	} else {
		$msg = '글을 ' . $msgState . '하지 못했습니다.';
?>
		<script>
			alert("<?php echo $msg?>");
			history.back();
		</script>
<?php
		exit;
	}
}

?>
<?php
//
//echo $msg;
// if($imgresult ){
//     echo "insert image success";
// }
// else{
//     echo "upload failed";
//
// }
//
// if($move){
//     echo 'move success';
// }
// else{
//     echo 'move fail';
//
// }



?>


<script>
	alert("<?php echo $msg?>//");
	location.replace("<?php

        echo $replaceURL?>");
</script>