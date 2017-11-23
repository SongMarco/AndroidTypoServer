<?php

require_once("../dbconfig.php");

include "../include/session.php";
ini_set("display_errors", 1);






	//$_GET['bno']이 있을 때만 $bno 선언
	if(isset($_GET['bno'])) {
		$bNo = $_GET['bno'];
	}
		 
	if(isset($bNo)) {
		$sql = 'select b_title, b_content, b_id from board_free where b_no = ' . $bNo;
		$result = $db->query($sql);
		$row = $result->fetch_assoc();

        // 게시판 이미지 불러오기. isset(row2)를 통해 기존 이미지 유무 확인 가능.
        $result = $db->query("select * from test_image where bbsNo=".$bNo);
        $row2 = $result->fetch_assoc();

    }


if(isset($bNo)) {

    if(($_SESSION['ses_userName'] !== $row['b_id']) &&($_SESSION['ses_userName'] !== 'jamsya') ){

        echo "<script>
                                        alert(\"작성자만 글 수정이 가능합니다.\");
                                        history.go(-1);
                                        </script>";
    }
}

?>
<!DOCTYPE html>
<html>
<head lang="ko">


	<meta charset="utf-8" />
	<title>Typo게시판</title>
	<link rel="stylesheet" href="./css/normalize.css" />
	<link rel="stylesheet" href="css/board.css" />
</head>
<body>
	<article class="boardArticle">
		<h3 style="text-align: center">Typo게시판 글쓰기</h3>
		<div id="boardWrite">
			<form enctype="multipart/form-data" name="form" action="./write_update.php" method="post">
				<?php
				if(isset($bNo)) {
					echo '<input type="hidden" name="bno" value="' . $bNo . '">';
				}
				?>
				<table id="boardWrite">
					<caption class="readHide"></caption>
					<tbody>
						<tr>
							<th scope="row"><label for="bID">아이디</label></th>
							<td class="id">
								<?php



//
//                                echo $_SESSION['ses_userName'];
								if(isset($bNo)) {





									echo $row['b_id'];
								} else {
                                    echo $_SESSION['ses_userName'];
								 } ?>
							</td>
						</tr>

						<tr>
							<th scope="row"><label for="bTitle">제목</label></th>
							<td class="title"><input type="text" name="bTitle" id="bTitle" value="<?php echo isset($row['b_title'])?$row['b_title']:null?>"></td>
						</tr>
                        <tr>
                            <th scope="row"><label for="bContent">이미지 첨부</label></th>
                            <td><input type="file" name="imageform" id="imageform" /></td>

<!--                            <article>-->
<!--                                <p id="status">File API & FileReader API not supported</p>-->
<!--                                <p><input type=file></p>-->
<!--                                <p>Select an image from your machine to read the contents of the file without using a server</p>-->
<!--                                <div id="holder"></div>-->
<!--                            </article>-->





                        </tr>


                        <tr>


                            <th scope="row"><label for="bContent">이미지 </br> 미리보기</label></th>
                            <!--                                <td>--><?php //echo $row2['path']."/".$row2['filename']?><!--</td>-->
                            <td id="holder">
                                <p id="status"></p>
                                <img id = "img_preview" src='<?php echo $row2['path']."/".$row2['filename']?>' style="max-width: 50px; height: auto;" />
                            </td>

                        </tr>

                        <script>
                            var upload = document.getElementById('imageform'),
                                holder = document.getElementById('holder'),
                                state = document.getElementById('status');

                            if (typeof window.FileReader === 'undefined') {
                                state.className = 'fail';
                            } else {
                                state.className = 'success';
                                state.innerHTML = '';
                            }

                            upload.onchange = function (e) {
                                e.preventDefault();

                                var file = upload.files[0],
                                    reader = new FileReader();
                                reader.onload = function (event) {
                                    var img = document.getElementById('img_preview');
                                    img.src = event.target.result;
                                    // note: no onload required since we've got the dataurl...I think! :)
//            if (img.width > 300) { // holder width
//                img.width = 300;
//            }
                                    img.width =50;
                                    holder.innerHTML = '';
                                    holder.appendChild(img);
                                };
                                reader.readAsDataURL(file);

                                return false;
                            };
                        </script>

                        <?php

                        if(isset($row2)){

                            ?>






                            <?php
                        }




                        ?>


						<tr>
							<th scope="row"><label for="bContent">내용</label></th>
							<td class="content"><textarea name="bContent" id="bContent"><?php echo isset($row['b_content'])?$row['b_content']:null?></textarea></td>
						</tr>


					</tbody>
				</table>
				<div class="btnSet">
					<button type="submit" class="btnSubmit btn">
						<?php echo isset($bNo)?'수정':'작성'?>
					</button>
					<a href="./index.php" class="btnList btn">목록</a>
				</div>
			</form>
		</div>
	</article>
</body>
</html>