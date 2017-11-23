<?php


	require_once("../dbconfig.php");

	/* 페이징 시작 */
	//페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}

	/* 검색 시작 */

	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}

	if(isset($searchColumn) && isset($searchText)) {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}

	/* 검색 끝 */

	$sql = 'select count(*) as cnt from board_free' . $searchSql;
	$result = $db->query($sql);
	$row = $result->fetch_assoc();

	$allPost = $row['cnt']; //전체 게시글의 수

	if(empty($allPost)) {
		$emptyData = '<tr><td class="textCenter" colspan="5">글이 존재하지 않습니다.</td></tr>';
	} else {

		$onePage = 10; // 한 페이지에 보여줄 게시글의 수.
		$allPage = ceil($allPost / $onePage); //전체 페이지의 수

		if($page < 1 && $page > $allPage) {
?>
			<script>
				alert("존재하지 않는 페이지입니다.");
				history.back();
			</script>
<?php
			exit;
		}

		$oneSection = 10; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
		$currentSection = ceil($page / $oneSection); //현재 섹션
		$allSection = ceil($allPage / $oneSection); //전체 섹션의 수

		$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지

		if($currentSection == $allSection) {
			$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
		} else {
			$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
		}

		$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
		$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.

		$paging = '<ul>'; // 페이징을 저장할 변수

		//첫 페이지가 아니라면 처음 버튼을 생성
		if($page != 1) {
			$paging .= '<li class="page page_start"><a href="./index.php?page=1' . $subString . '">처음</a></li>';
		}
		//첫 섹션이 아니라면 이전 버튼을 생성
		if($currentSection != 1) {
			$paging .= '<li class="page page_prev"><a href="./index.php?page=' . $prevPage . $subString . '">이전</a></li>';
		}

		for($i = $firstPage; $i <= $lastPage; $i++) {
			if($i == $page) {
				$paging .= '<li class="page current">' . $i . '</li>';
			} else {
				$paging .= '<li class="page"><a href="./index.php?page=' . $i . $subString . '">' . $i . '</a></li>';
			}
		}

		//마지막 섹션이 아니라면 다음 버튼을 생성
		if($currentSection != $allSection) {
			$paging .= '<li class="page page_next"><a href="./index.php?page=' . $nextPage . $subString . '">다음</a></li>';
		}

		//마지막 페이지가 아니라면 끝 버튼을 생성
		if($page != $allPage) {
			$paging .= '<li class="page page_end"><a href="./index.php?page=' . $allPage . $subString . '">끝</a></li>';
		}
		$paging .= '</ul>';

		/* 페이징 끝 */


		$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
		$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문

		$sql = 'select * from board_free' . $searchSql . ' order by b_no desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
		$result = $db->query($sql);
	}


?>
<!DOCTYPE html>
<html>


<head>

    <title>자유게시판</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/css/Contact-Form-Clean.css">

    <script src="http://code.jquery.com/jquery-latest.js"></script>
	<link rel="stylesheet" href="css/board.css" />
</head>

<body>
<div style="text-align: right">

    <?php
    include "../include/session.php";




    if($_SESSION['ses_userName']){

        if($_SESSION['ses_userName'] !== 'jamsya'){
            echo $_SESSION['ses_userName'].'님 환영합니다. ';
        }
        else{
            echo "관리자 계정입니다. ".$_SESSION['ses_userName'].'님 환영합니다. ';
        }


        if( $_COOKIE['auto_login'] == 'on' ){
            echo "자동 로그인".$_COOKIE['auto_login'];
        }
        else{

            $time = $_SESSION['expireTime']/60;

            echo $time."분간 활동이 없을 경우 로그아웃됩니다.";
        }
    }


    ?>



</div>


<div>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php" style="font-family:ABeeZee, sans-serif;">TYPOTIONARY </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li  role="presentation"><a href="../index.php">홈 </a></li>
                    <!--                        <li role="presentation"><a href="./guide.php">활용 가이드 </a></li>-->
                    <li class="active" role="presentation"><a href="../freeboard2">Typo게시판 </a></li>
                    <li role="presentation"><a href="../contact.php">문의하기 </a></li>
                    <!--                        <li role="presentation"><a href="./study">학습 </a></li>-->
                </ul>
                <form action = "../search.php" class="navbar-form navbar-left" target="_self" method="get">
                    <div class="form-group">
                        <label class="control-label" for="search-field">Typo 검색</label>
                        <input class="form-control search-field" type="search" name="searchWord" id="search-field">
                    </div>

                    <button class="btn btn-primary" type="submit" style="background-color:rgb(75,84,75);"> <i class="glyphicon glyphicon-search"></i></button>
                </form>

                <ul class="nav navbar-nav">

                    <li ><a href="../recent">최근검색 </a></li>
                    <!--                        <li role="presentation"><a href="./study">학습 </a></li>-->
                </ul>


                <div>

                    <a id="login" class="btn btn-primary navbar-btn " role="button" href="../LoginMember" style="background-color:rgb(100,138,235);"><strong>로그인</strong> </a>
                    <a id="join" class="btn btn-primary navbar-btn " role="button" href="../joinMember" style="background-color:rgb(51,181,40);"><strong>회원가입</strong> </a>
                    <a id="logout" class="btn btn-primary navbar-btn " role="button" href="../LoginMember/logout.php" style="background-color:rgb(100,138,235);"><strong>로그아웃</strong> </a>

                    <script>

                        var is_logged_in = "<?php echo $_SESSION['ses_userName'] ?>"; //$_SESSION['log_status']=true..assume

                        if (is_logged_in) {

                            document.getElementById('join').style.display='none';
                            document.getElementById('login').style.display='none';
                            //your code..$(".class or #id").addClass("xyz");//show,hide or any appropriate action
                        } else {

                            document.getElementById('logout').style.display='none';
                        }


                        //                        $("a").click(function ( event ) {
                        //                            event.preventDefault();
                        //                            $(this).hide();
                        //                        });


                    </script>

                </div>
            </div>
        </div>
    </nav>
</div>
<div class="outer">
	<article class="boardArticle; inner">
        <div style="text-align: center"><h3 >당신만의 Typo를 표현해보세요!</h3></div>

        <div id="boardList">

        <div class="outer">
			<table style="margin-left: auto; margin-right: auto;" >

				<caption style="text-align: center" class="readHide"></caption>
				<thead>
					<tr>
						<th scope="col" class="no">번호</th>
						<th scope="col" class="title">제목</th>
						<th scope="col" class="author">작성자</th>
						<th scope="col" class="date">작성일</th>
						<th scope="col" class="hit">조회</th>
					</tr>
				</thead>
				<tbody>
						<?php
						if(isset($emptyData)) {
							echo $emptyData;
						}
						else
                        {
							while($row = $result->fetch_assoc())
							{
								$datetime = explode(' ', $row['b_date']);
								$date = $datetime[0];
								$time = $datetime[1];
								if($date == Date('Y-m-d'))
									$row['b_date'] = $time;
								else
									$row['b_date'] = $date;
						?>
						<tr>
							<td class="no"><?php echo $row['b_no']?></td>
							<td class="title">
								<a href="read.php?bno=<?php echo $row['b_no']?>"><?php echo $row['b_title']?></a>
							</td>
							<td class="author"><?php echo $row['b_id']?></td>
							<td class="date"><?php echo $row['b_date']?></td>
							<td class="hit"><?php echo $row['b_hit']?></td>
						</tr>
						<?php
							}
						}
						?>
				</tbody>
			</table>

            <div style="margin-left: auto">




                <?php

                include "../include/session.php";

                //로그인 되있다면 글쓰기가 가능하다.
                if($_SESSION['ses_userName']){

                    echo "<a href=\"./write.php\" >글쓰기</a>";
                }

                //로그인이 안되었다. 글쓰기 누르면 알림창 띄우고 로그인 창으로.
                else {
                    echo "<a href=\"javascript:onClick=writeConfirm()\" >글쓰기</a>";


                }

                ?>
<!--                writePermission 은 확인 / 취소가 있다. 컨펌임! 반면에 writeAlert는 확인만 있는 alert!-->
                <script>
                    function writeConfirm(){
                        if( confirm("사이트 회원만 글을 쓸 수 있습니다. 로그인 창으로 이동합니다." ) ){
                            location.href="../LoginMember";
                        }
                    }
                </script>

                <script>
                    function writeAlert(){
                        alert("사이트 회원만 글을 쓸 수 있습니다. 로그인 창으로 이동합니다." );
                        location.href="../LoginMember";

                    }
                </script>

            </div>


			<div class="paging">
				<?php echo $paging ?>
			</div>
			<div class="searchBox">
				<form action="./index.php" method="get">
					<select name="searchColumn">
						<option <?php echo $searchColumn=='b_title'?'selected="selected"':null?> value="b_title">제목</option>
						<option <?php echo $searchColumn=='b_content'?'selected="selected"':null?> value="b_content">내용</option>
						<option <?php echo $searchColumn=='b_id'?'selected="selected"':null?> value="b_id">작성자</option>
					</select>
					<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
					<button type="submit">검색</button>
				</form>
			</div>
		</div>

	</article>

</div>
</body>
</html>
