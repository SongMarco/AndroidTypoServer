
<?php
include "../dbconfig.php";
include "../include/session.php";
ini_set("display_errors", 1);
$date = date('Y-m-d H:i:s');


for ($i = 30; $i <50; $i++){

    $bTitle = 'test'.$i;
    $bContent = '버그를 찾았습니다 '.$i;

    $sql = 'insert into board_free (b_no, b_title, b_content, b_date, b_hit, b_id) 
values(null, "' . $bTitle . '", "' . $bContent . '", "' . $date . '", 0 ,"' . $_SESSION['ses_userName'] . '" )';

    $db->query($sql);

}


?>