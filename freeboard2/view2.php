<?php
require_once("../dbconfig.php");
include "../include/session.php";
$bNo = $_GET['bno'];

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
        setcookie('board_free_' . $bNo, TRUE, time() + (60 * 60 * 24), '/');
    }
}

$sql = 'select b_title, b_content, b_date, b_hit, b_id from board_free where b_no = ' . $bNo;
$result = $db->query($sql);
$row = $result->fetch_assoc();
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>자유게시판</title>
    <link rel="stylesheet" href="./css/normalize.css" />
    <link rel="stylesheet" href="./css/board.css" />
    <script src="./js/jquery-2.1.3.min.js"></script>\
    <script src="http://code.jquery.com/jquery-latest.js"></script>

</head>
<body>
<article class="boardArticle">
    <h3 style="text-align: center">자유게시판</h3>


    <div id="boardView">
        <div><?php
            include "../include/session.php";

            echo $_SESSION['ses_userName'];
            echo $_SESSION['ses_userName'].'님 환영합니다.';?>

        </div>

        <h3 style="text-align: center" id="boardTitle"><?php echo $row['b_title']?></h3>
        <div id="boardInfo">
            <span id="boardID">작성자: <?php echo $row['b_id']?></span>
            <span id="boardDate">작성일: <?php echo $row['b_date']?></span>
            <span id="boardHit">조회: <?php echo $row['b_hit']?></span>
        </div>
        <div id="boardContent"><?php echo $row['b_content']?></div>
        <div class="btnSet">
            <a id = "edit" href="./write.php?bno=<?php echo $bNo?>">수정</a>
            <a id = "del" href="./delete.php?bno=<?php echo $bNo?>">삭제</a>
            <a id = "list" href="./">목록</a>


            <script>

                var is_logged_in = "<?php echo $_SESSION['ses_userName'] ?>"; //$_SESSION['log_status']=true..assume

                // 세션의 닉네임과 글쓴이가 동일하다면 -> 수정, 삭제를 보이게 해라.
                if (is_logged_in) {


                } else {

                    document.getElementById('edit').style.display='none';
                    document.getElementById('del').style.display='none';
                }


            </script>
        </div>
        <div id="boardComment">
            <?php require_once('./comment.php')?>
        </div>
    </div>
</article>
</body>
</html>