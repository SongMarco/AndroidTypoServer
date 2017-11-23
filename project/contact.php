<!DOCTYPE html>
<html>


<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>findex</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
</head>

<body>
<div style="text-align: right">

    <?php
    include "./include/session.php";




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
                    <li  role="presentation"><a href="index.php">홈 </a></li>
                    <!--                        <li role="presentation"><a href="./guide.php">활용 가이드 </a></li>-->
                    <li role="presentation"><a href="./freeboard2">Typo게시판</a></li>
                    <li class="active" role="presentation"><a href="contact.php">문의하기 </a></li>
                    <!--                        <li role="presentation"><a href="./study">학습 </a></li>-->
                </ul>
                <form action = "./search.php" class="navbar-form navbar-left" target="_self" method="get">
                    <div class="form-group">
                        <label class="control-label" for="search-field">Typo 검색</label>
                        <input class="form-control search-field" type="search" name="searchWord" id="search-field">
                    </div>

                    <button class="btn btn-primary" type="submit" style="background-color:rgb(75,84,75);"> <i class="glyphicon glyphicon-search"></i></button>
                </form>

                <ul class="nav navbar-nav">

                    <li ><a href="./recent">최근검색 </a></li>
                    <!--                        <li role="presentation"><a href="./study">학습 </a></li>-->
                </ul>


                <div>

                    <a id="login" class="btn btn-primary navbar-btn " role="button" href="./LoginMember" style="background-color:rgb(100,138,235);"><strong>로그인</strong> </a>
                    <a id="join" class="btn btn-primary navbar-btn " role="button" href="joinMember" style="background-color:rgb(51,181,40);"><strong>회원가입</strong> </a>
                    <a id="logout" class="btn btn-primary navbar-btn " role="button" href="./LoginMember/logout.php" style="background-color:rgb(100,138,235);"><strong>로그아웃</strong> </a>

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


    <div class="contact-clean">
        <form name="contact" action="<?=$_SERVER['PHP_SELF']?>" method="post" >
            <!--       메일보내기 아직 예외처리가 안되었다. smtp -->
            <input type="hidden" name="action" value="form_submit" />

            <h2 class="text-center">문의사항을 전달해드립니다. </h2>
            <div class="form-group has-success">
                <input class="form-control" type="text" name="name" placeholder="이름">
            </div>
            <div class="form-group has-error">
                <input class="form-control" type="email" name="email" placeholder="Email">
            </div>
            <div class="form-group">
                <textarea class="form-control" rows="14" name="message" placeholder="내용을 입력하세요..."></textarea>
            </div>
            <div class="form-group">
                <button class="btn btn-primary" type="submit" >보내기 </button>
            </div>
        </form>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>



    <?php
    $action = '';
    if(isset($_POST['action']))$action = $_POST['action'];

    //폼이 입력되었을 때 처리부분이다. 스스로 post받아서 디비에 저장시킨다.
    if($action == 'form_submit') {

        include "./include/dbConnect.php";

        $contactName = $_POST['name'];
        $contactEmail = $_POST['email'];
        $contactMessage = $_POST['message'];

        //echo "<script>alert(\"$contactEmail, $contactMessage, $contactName :: 운영자에게 메시지를 보냈습니다.\");</script>";
        $sql = "select * from contact;";

        $query = mysqli_query($dbConnect, $sql) or die("123123");

        $sql = "INSERT INTO contact(name, email, message) 
                VALUES('$contactName','$contactEmail','$contactMessage');";

        $query = mysqli_query($dbConnect, $sql);
        if($query){
            echo "<script>alert(\"운영자에게 메시지를 보냈습니다.\");</script>";
        }


        exit;
    }
    ?>
</body>

</html>