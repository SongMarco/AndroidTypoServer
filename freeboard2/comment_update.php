﻿﻿﻿<?php
	require_once('../dbconfig.php');
	include "../include/session.php";

	$w = '';
	$coNo = 'null';
	
	//2Depth & 수정 & 삭제
	if(isset($_POST['w'])) {
		$w = $_POST['w'];
		$coNo = $_POST['co_no'];
	}
	
	//공통 변수
	$bNo = $_POST['bno'];
	$coPassword = $_POST['coPassword'];
	
	if($w !== 'd') {//$w 변수가 d일 경우 $coContent와 $coId가 필요 없음.
		$coContent = $_POST['coContent'];
		if($w !== 'u') {//$w 변수가 u일 경우 $coId가 필요 없음.
			$coId = $_POST['coId'];
		}
	}
	
	if(empty($w) || $w === 'w') { //$w 변수가 비어있거나 w인 경우
		$msg = '작성';
		$sql = 'insert into comment_free values(null, ' .$bNo . ', ' . $coNo . ', "' . $coContent . '", "' . $_SESSION['ses_userName'] . '", password("' . $coPassword . '"))';

		
		if(empty($w)) { //$w 변수가 비어있다면,
			$result = $db->query($sql);
			
			$coNo = $db->insert_id;
			$sql = 'update comment_free set co_order = co_no where co_no = ' . $coNo;
		}
		
	} else if($w === 'u') { //작성
		$msg = '수정';
		
		$sql = 'select count(*) as cnt from comment_free where co_password=password("' . $coPassword . '") and co_no = ' . $coNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
?>
			<script>
				alert('비밀번호가 맞지 않습니다.');
				history.back();
			</script>
<?php 
			exit;	
		}
		
		$sql = 'update comment_free set co_content = "' . $coContent . '" where co_password=password("' . $coPassword . '") and co_no = ' . $coNo;
		
	} else if($w === 'd') { //삭제
		$msg = '삭제';
		$sql = 'select count(*) as cnt from comment_free where co_password=password("' . $coPassword . '") and co_no = ' . $coNo;

		$result = $db->query($sql);
		$row = $result->fetch_assoc();
		
//		if(empty($row['cnt'])) { //맞는 결과가 없을 경우 종료
//?>
<!--			<script>-->
<!--				alert('비밀번호가 맞지 않습니다.');-->
<!--				history.back();-->
<!--			</script>-->
<?php
        $sql = 'SELECT COUNT(if(co_no='.$coNo.', co_no, null)) as `count` FROM `comment_free`';

//덧글과 동일한 co_no를 가지는 놈들을 찾는다. 카운트가 1이면 일단 댓글이니까 삭제여부를 더 검토해야함. 1 아니면 그대로 삭제
        $result = $db->query($sql);

        $row = mysqli_fetch_assoc($result);
        $count = $row['count'];
        echo "count = ".$count."</br>";

//카운트가 1이면 이건 '댓글'이다. 대댓글이 달린 여부를 확인한다.
        if($count == 1){
//            echo "count = ".$count."</br>";
//            echo "댓글입니다. 대댓글 갯수를 확인하십시오. </br>";

//    $sql = 'SELECT COUNT(if(co_order=$coNo, co_order, null)) as `count2` FROM `comment_free`';
            $sql2 = 'SELECT COUNT(if(co_order='.$coNo.', co_order, null)) as `count2` FROM `comment_free`';
            $result2 = $db->query($sql2);
            $row2 = mysqli_fetch_assoc($result2);
            $count2 = $row2['count2'];

            //대댓글이 달린 댓글이다.
            if($count2 > 1){
                $sql = 'UPDATE comment_free SET co_content ="[삭제된 댓글입니다.]"  WHERE co_no = '.$coNo ;

            }
            // 그냥 댓글이다.
            else{
                $sql ='delete from comment_free where co_no = ' . $coNo;
            }


        }
        else{
            $sql ='delete from comment_free where co_no = ' . $coNo;
        }



	} else {
?>
		<script>
			alert('정상적인 경로를 이용해주세요.');
			history.back();
		</script>
<?php 
		exit;
	}
	
	$result = $db->query($sql);
	if($result) {
?>
		<script>
			alert('댓글이 정상적으로 <?php echo $msg?>되었습니다.');
			location.replace("./read.php?bno=<?php echo $bNo?>");
		</script>
<?php
	} else {
?>
		<script>
			alert('댓글 <?php echo $msg?>에 실패했습니다.');
			history.back();
		</script>
<?php
		exit;
	}
	
?>
