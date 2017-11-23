

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
                        <li class="active" role="presentation"><a href="index.php">홈 </a></li>
<!--                        <li role="presentation"><a href="./guide.php">활용 가이드 </a></li>-->
                        <li role="presentation"><a href="./freeboard2">Typo게시판 </a></li>
                        <li role="presentation"><a href="contact.php">문의하기 </a></li>
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


    <div class="container" style="padding:134px;">
        <div class="row product" style="width:910px;">
            <div class="col-md-5 col-md-offset-0"><img src="assets/img/tree.jpg" style="height:210px;width:268px;"><img src="assets/img/nurse.jpg" style="height:210px;width:268px;"><img src="assets/img/artist.jpg" style="height:210px;width:268px;"></div>
            <div class="col-md-7" style="width:520;">
                <h2>Typotionary??</h2>
                <p>타이포셔너리(typotionary)는 타이포그래피(typography)로 이루어진 영어 사전(dictionary)이에요.</p>
                <p>영어 단어가 그림처럼 표현되기 때문에 더 쉽게 단어를 공부할 수 있어요.</p>
                <p>우리모두 타이포셔너리로 즐겁게 영단어를 공부해볼까요? </p>
            </div>
            <div class="col-md-12"></div>
        </div>
    </div>
    <footer class="site-footer">
        <div class="container">
            <hr>
            <div class="row">
                <div class="col-sm-6">
                    <h5>Typotianary © 2017</h5></div>
                <div class="col-sm-6 social-icons"><a href="#"><i class="fa fa-facebook"></i></a><a href="#"><i class="fa fa-twitter"></i></a><a href="#"><i class="fa fa-instagram"></i></a></div>
            </div>
        </div>
    </footer>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>


</body>
<script>
    jQuery(document).ready(function($) {
        pevent();
    });

    function pevent(){
        function getCookie(name){
            var nameOfCookie = name + "=";
            var x = 0;
            while (x <= document.cookie.length){
                var y = (x + nameOfCookie.length);
                if (document.cookie.substring(x, y) != nameOfCookie) {
                } else {
                    if ((endOfCookie = document.cookie.indexOf(";", y)) == -1) {
                        endOfCookie = document.cookie.length;
                    }
                    return unescape(document.cookie.substring(y, endOfCookie));
                }
                x = document.cookie.indexOf (" ", x) + 1;
                if (x == 0) break;
            }
            return "";
        }
        if (getCookie("popState") != "noSee"){
            var popUrl = "./popup/ad1.php"; //팝업창에 출력될 페이지 URL
            var popOption = "width=370, height=360, resizable=no, scrollbars=no, status=no;";    //팝업창 옵션
            window.open(popUrl,"",popOption);
        }
    }

</script>
</html>


