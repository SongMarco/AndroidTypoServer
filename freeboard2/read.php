<?php
require_once("../dbconfig.php");
include "../include/session.php";
$bNo = $_GET['bno'];
//ini_set("display_errors", 1);

if(!empty($bNo) && empty($_COOKIE['board_free_' . $bNo])) {
    $sql = 'update board_free set b_hit = b_hit + 1 where b_no = ' . $bNo;
    $result = $db->query($sql);
    if(empty($result)) {
        ?>
        <script>
            alert('오류가 발생했습니다.');
            history.back();
        </script>
        <?php
    } else {
        setcookie('bo   ard_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
    }
}

//게시판 내용 불러오기.
$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_free where b_no = ' . $bNo;
$result = $db->query($sql);
$row = $result->fetch_assoc();

// 게시판 이미지 불러오기.
$result = $db->query("select * from test_image where bbsNo=".$bNo);
$row2 = $result->fetch_assoc();

?>


<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>자유게시판</title>
    <link rel="stylesheet" href="./css/normalize.css" />
    <link rel="stylesheet" href="./css/board.css" />
    <script src="./js/jquery-2.1.3.min.js"></script>
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <link rel="stylesheet" href="ht tps://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">





</head>
<body>


<!--가운데 정렬하는법. 클래스 = 센터드를 추가해주었다. 위에 헤더에 스타일 - 센터드도 있음. 참고! -->
<div class="centered ridge">
<article >
    <h3 style="text-align: center">Typo게시판</h3>


    <div id="boardView">
        <div >
            <?php
            include "../include/session.php";

            // echo $_SESSION['ses_userName'].'님 환영합니다.';?>

        </div>

        <h3 style="text-align: center" id="boardTitle"><?php echo $row['b_title']?></h3>
        <div id="boardInfo">
            <span id="boardID">작성자: <?php echo $row['b_id']?></span>
            <span id="boardDate">작성일: <?php echo $row['b_date']?></span>
            <span id="boardHit">조회: <?php echo $row['b_hit']?></span>
        </div>


        <div>

            <?php
            if(!empty($row2)){
//    echo "<img src='".$row2['path']."/".$row2['filename']."' style=\"max-width: 70%; height: auto;\" />";

                ?>
                <img src='<?php echo $row2['path']."/".$row2['filename']?>' style="max-width: 400px; height: auto;" />

                <?php


            }
            else
//                echo "이미지 없음";

            ?>


        </div>
        <div id="boardContent"><?php echo $row['b_content']?></div>
        <div class="btnSet">
            <form action="./delete_update.php" method="post" >
<!--                onsubmit="return validate(this)"-->
                <input type="hidden" name="bno" value="<?php echo $bNo?>">



                <?php


                //유저이름이 작성자이거나, 운영자의 아이디면 수정삭제 가능.
                if(($_SESSION['ses_userName'] == $row['b_id']) || ($_SESSION['ses_userName'] == 'jamsya') ){
                    ?>
                    <a id = "edit" href="./write.php?bno=<?php echo $bNo?>">수정</a>

                    <a id = "del" href="javascript:onClick=deleteConfirm()">삭제</a>
                    <?php
                }

                ?>




<!--                <script>-->
<!--                    function validate(form) {-->
<!---->
<!--                        // validation code here ...-->
<!---->
<!---->
<!--                        if(!valid) {-->
<!--                            alert('Please correct the errors in the form!');-->
<!--                            return false;-->
<!--                        }-->
<!--                        else {-->
<!--                            return confirm('글을 삭제하시겠습니까?');-->
<!--                        }-->
<!--                    }-->
<!--                </script>-->



                <script>
                function deleteConfirm(){
                    if( confirm("글을 삭제하시겠습니까?" ) ){

                        document.forms[0].submit();

                    }

                }
                 </script>



<!--                //                        location.href="./delete.php?bno=--><?php ////echo $bNo?><!--//";-->
            <a id = "list" href="./">목록</a>

            </form>








        </div>
        <div id="boardComment">

            <?php require_once('./comment.php')?>
        </div>
    </div>
</article>
</div>
</body>
</html>
