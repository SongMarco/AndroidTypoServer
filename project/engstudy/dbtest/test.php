<!DOCTYPE html>
<meta charset="utf-8" />
<?php
$action = '';
if(isset($_POST['action']))$action = $_POST['action'];

//폼이 입력되었을 때 처리부
if($action == 'form_submit') {
    echo '<xmp>';
    print_r($_POST);
    echo '</xmp>';

    exit;
}
?>
<form method="post" action="<?=$_SERVER['PHP_SELF']?>">
    <input type="hidden" name="action" value="form_submit" />
    <textarea name="textarea1"></textarea>
    <input type="submit" value="제출하기" />
</form>