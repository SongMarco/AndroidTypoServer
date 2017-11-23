

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>findex</title>
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=News+Cycle:400,700">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=ABeeZee">
    <link rel="stylesheet" href="../assets/fonts/font-awesome.min.css">
    <link rel="stylesheet" href="../assets/css/user.css">
    <link rel="stylesheet" href="../assets/css/Contact-Form-Clean.css">


    <!--    아래 4개 중 하나라도 없으면 캐러셀이 작동하지 않습니다-->
    <link rel="stylesheet" href="../assets/css/user.css">
    <script src="http://code.jquery.com/jquery-latest.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
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
                    <li role="presentation"><a href="../freeboard2">Typo게시판</a></li>
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

                    <li role="presentation" class="active" ><a href="../recent">최근검색 </a></li>
                    <!--                        <li role="presentation"><a href="./study">학습 </a></li>-->
                </ul>


                <div>


                    <?php
                    if( isset($_SESSION['ses_userName']) ){
                        ?>

                        <a id="logout" class="btn btn-primary navbar-btn " role="button" href="../LoginMember/logout.php" style="background-color:rgb(100,138,235);"><strong>로그아웃</strong> </a>


                        <?php


                    }
                    else{

                        ?>
                        <a id="login" class="btn btn-primary navbar-btn " role="button" href="../LoginMember" style="background-color:rgb(100,138,235);"><strong>로그인</strong> </a>

                        <a id="join" class="btn btn-primary navbar-btn " role="button" href="../joinMember" style="background-color:rgb(51,181,40);"><strong>회원가입</strong> </a>


                        <?php

                    }

                    ?>




                </div>
            </div>
        </div>
    </nav>
</div>

<script>
    $(document).ready(function() {
        $('#Carousel').carousel({
            interval: 100000000
        })
    });
</script>


<?php





$recent = explode(",,", $_COOKIE['recent_search']);



//$recent2 = explode( "::", $recent);

//$recent = array_reverse($recent);
//    print_r($recent); //최근 것부터 정렬하기 위해 배열 순서를 반대로 바꿔준다.


$eng_arr=array();
$kor_arr=array();

// 먼저 :: 기준으로 단어와 뜻을 분리한다.
for($i=0; $recent[$i]; $i++) {

    $split = explode("::", $recent[$i]);

    array_push($eng_arr, $split[0] );
    array_push($kor_arr, $split[1]);


}

$cnt = count($eng_arr);
//echo $cnt."<br>";


// serialize 되어있던 단어뜻을 unserialize 한 뒤 단어와 함께 내보낸다.

$kor_str_mean = array();

for($i=0; $eng_arr[$i]; $i++) {

//    echo $eng_arr[$i]. "  ::  ";

    $kor_mean = unserialize($kor_arr[$i]);//문자열 -> 뜻의 배열


    for($j = 0; $kor_mean[$j]; $j++){
        if(isset($kor_str_mean[$i]) ){
            $kor_str_mean[$i] = $kor_str_mean[$i]."; ".$kor_mean[$j];
        }
        else{
            $kor_str_mean[$i] = $kor_mean[$j];
        }
//        echo $kor_mean[$j]."; ";

    }

//    echo "</br>";
}



// 이미지 검색하기. 서버의 지정된 경로를 탐색하고 문서를 반환한다.
$filepath = "/app/apache/htdocs/project/engstudy/assets/img";

$pict_arr2 = array();

for($i=0; $eng_arr[$i]; $i++) {

    $filename = $filepath."/".$eng_arr[$i]."*";



    $pict_arr = array();
    foreach (glob($filename) as $filefound) {


        array_push($pict_arr, $filefound);
//                $arr[] = $filefound;

    }






    $cutPath = 'assets';

    for($j = 0; isset( $pict_arr[$j] ); $j++ ){


        $tmp = strstr($pict_arr[$j] , $cutPath);
//                echo $tmp."</br>";

        $pict_arr[$j] = $tmp;
    }


    for($k = 0; isset( $pict_arr[$k] ); $k++ ){

        array_push($pict_arr2, $pict_arr[$k] );
        ?>

        <!--        <img src= '../--><?php //echo $pict_arr[$k] ?><!--' style="max-width: 400px; height: auto;" />-->


        <?php
    }

}
//print_r($kor_str_mean);
if($cnt > 8){
    for($l = 0; $l < 8; $l++){
        $eng_arr[$l] = $eng_arr[$cnt+$l-8];
        $kor_str_mean[$l] = $kor_str_mean[$cnt+$l-8];
        $pict_arr2[$l] = $pict_arr2[$cnt+$l-8];
    }

    $offset = 8;
    array_splice($eng_arr, $offset);
    array_splice($kor_str_mean, $offset);
    array_splice($pict_arr2, $offset);


}


            ini_set("display_errors", 1);

//todo 8개가 넘어갔을 때 중복이 되면 최근 단어에 남지 않는 문제 발생. 일단 텍스트로 커버함, 쿠키 능동 삭제 필요. 무한히 늘어나버렷
$eng_arr = array_reverse($eng_arr);
$kor_str_mean = array_reverse($kor_str_mean);
$pict_arr2 = array_reverse($pict_arr2);



?>


<div class="container" >
    <div class="row">
        <div class="col-md-12">
            <div id="Carousel" class="carousel slide">

                <ol class="carousel-indicators">
                    <li data-target="#Carousel" data-slide-to="0" class="active"></li>
                    <li data-target="#Carousel" data-slide-to="1"></li>
                    <!--                    <li data-target="#Carousel" data-slide-to="2"></li>-->
                </ol>

                <!-- Carousel items -->
                <div class="carousel-inner" style="margin-top:40px">


                    <!--                    //todo 동적으로 추가하도록 php문을 만들고싶으나, 시간이 부족하다. 8개까지만 만들었다. -->
                    <div class="item active">
                        <div class="row">
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[0])? "../search.php?searchWord=".$eng_arr[0]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[0] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[0] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[1])? "../search.php?searchWord=".$eng_arr[1]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[1] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[1] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[2])? "../search.php?searchWord=".$eng_arr[2]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[2] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[2] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[3])? "../search.php?searchWord=".$eng_arr[3]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[3] ?>' alt="이미지가 없습니다." style="max-width:100%;"><?php echo $kor_str_mean[3] ?></a></div>
                        </div><!--.row-->
                    </div><!--.item-->

                    <div class="item">
                        <div class="row">
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[4])? "../search.php?searchWord=".$eng_arr[4]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[4] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[4] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[5])? "../search.php?searchWord=".$eng_arr[5]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[5] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[5] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[6])? "../search.php?searchWord=".$eng_arr[6]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[6] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[6] ?></a></div>
                            <div class="col-md-3"><a href="<?php echo isset($eng_arr[7])? "../search.php?searchWord=".$eng_arr[7]:'#';  ?>" class="thumbnail"><img src='../<?php echo $pict_arr2[7] ?>' alt="이미지가 없습니다" style="max-width:100%;"><?php echo $kor_str_mean[7] ?></a></div>
                        </div><!--.row-->
                    </div><!--.item-->

                </div><!--.carousel-inner-->
                <a data-slide="prev" href="#Carousel" class="left carousel-control">‹</a>
                <a data-slide="next" href="#Carousel" class="right carousel-control">›</a>
            </div><!--.Carousel-->

        </div>
    </div>
</div><!--.container-->




<div class="container" style="padding:100px;">
    <?php

    ?>


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
<script src="../assets/js/jquery.min.js"></script>
<script src="../assets/bootstrap/js/bootstrap.min.js"></script>


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


