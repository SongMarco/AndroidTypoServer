<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>findex</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Lora">
    <link rel="stylesheet" href="assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="assets/css/user.css">
    <link rel="stylesheet" href="assets/css/Contact-Form-Clean.css">

</head>

<body>
    <nav class="navbar navbar-default">
        <div class="container">
            <div class="navbar-header"><a class="navbar-brand navbar-link" href="index.php" style="font-family:ABeeZee, sans-serif;">TYPOTIONARY </a>
                <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
            </div>
            <div class="collapse navbar-collapse" id="navcol-1">
                <ul class="nav navbar-nav">
                    <li role="presentation"><a href="index.php">홈 </a></li>
                    <li class="active" role="presentation"><a href="#">활용 가이드 </a></li>
                    <li role="presentation"><a href="./freeboard2">자유게시판 </a></li>
                    <li role="presentation"><a href="contact.php">문의하기 </a></li>
                </ul>
                <form class="navbar-form navbar-left" target="_self">
                    <div class="form-group">
                        <label class="control-label" for="search-field">Typo 검색</label>
                        <input class="form-control search-field" type="search" name="search" id="search-field">
                    </div>
                    <button class="btn btn-primary" type="submit" style="background-color:rgb(75,84,75);"> <i class="glyphicon glyphicon-search"></i></button>
                </form><a class="btn btn-primary navbar-btn navbar-right" role="button" href="./member/signUpForm.php" style="background-color:rgb(51,181,40);"><strong>회원가입</strong> </a><a class="btn btn-primary navbar-btn navbar-right" role="button" href="./member"
                style="background-color:rgb(100,138,235);"><strong>로그인</strong> </a></div>
        </div>
    </nav>
    <div class="article-clean">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="text">
                        <div class="btn-group" role="group">

                            <form name="contact" action="<?=$_SERVER['PHP_SELF']?>"method="get" >
                                <input type="hidden" name="action" value="form_submit" />

<!--잘봐! 밑에 버튼에서 name, value를 통해서 값을 넘겨주고 있잖아! name이 키 역할, 밸류가 밸류 역할을 하는군!!!@@!@!@!@-->
<!--                               두 가지 원리가 동일한 결과를 반환하는 것을 주목하라. href & self get-->
                                <a class="btn btn-default" href="guide.php?action=form_submit&num_guide=1" name = "num_guide" >Guide 1</a>
                                <button class="btn btn-default" type="submit" name = "num_guide" value="2" = "2" style="background-color:rgb(179,55,55);">Guide 2</button>
                                <button class="btn btn-default" type="submit" name = "num_guide" value="3">Guide 3</button>
                                <button class="btn btn-default" type="submit" name = "num_guide" value="4"style="background-color:rgb(184,208,33);" >Guide 4</button>
                            </form>


                        </div>

                    </div>
                    <?php
                    $action = '';
                    if(isset($_GET['action']))$action = $_GET['action'];

                    //폼이 입력되었을 때 처리부분이다. 스스로 post받아서 디비에 저장시킨다.
                    if($action == 'form_submit') {

//                    echo print_r($_GET);
//                    echo'\n';
                        $num_guide = $_GET['num_guide'];
                        echo "현재 가이드는 $num_guide 번 가이드입니다.";

                        exit;
                    }
                    ?>
                </div>




                <div class="col-lg-8 col-lg-offset-2 col-md-10 col-md-offset-1">
                    <div class="text">
                        <p>타이포셔너리의 활용 가이드입니다. 하나 하나 살펴볼까요? </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>