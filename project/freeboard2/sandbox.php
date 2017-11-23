<?php

include "../dbconfig.php";
include "../include/session.php";

//			exit;
//		}


echo "dbtest </br>";

$coNo = 127;

$sql = 'SELECT COUNT(if(co_no='.$coNo.', co_no, null)) as `count` FROM `comment_free`';

//덧글과 동일한 co_no를 가지는 놈들을 찾는다. 카운트가 1이면 일단 댓글이니까 삭제여부를 더 검토해야함. 1 아니면 그대로 삭제
$result = $db->query($sql);

$row = mysqli_fetch_assoc($result);
$count = $row['count'];
echo "count = ".$count."</br>";

//카운트가 1이면 이건 '댓글'이다. 대댓글이 달린 여부를 확인한다.
if($count == 1){
    echo "count = ".$count."</br>";
    echo "댓글입니다. 대댓글 갯수를 확인하십시오. </br>";

//    $sql = 'SELECT COUNT(if(co_order=$coNo, co_order, null)) as `count2` FROM `comment_free`';
    $sql2 = 'SELECT COUNT(if(co_order='.$coNo.', co_order, null)) as `count2` FROM `comment_free`';
    $result2 = $db->query($sql2);
    $row2 = mysqli_fetch_assoc($result2);
    $count2 = $row2['count2'];

    if($count2 > 1){
        echo "대댓글이 달린 댓글입니다. 총 댓글수 = ".$count2;
    }


}


?>