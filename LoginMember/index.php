<!DOCTYPE html>
<html lang="ko">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>bootstrap template</title>

    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- font awesome -->
    <link rel="stylesheet" href="css/font-awesome.min.css" media="screen" title="no title" charset="utf-8">
    <!-- Custom style -->
    <link rel="stylesheet" href="css/style.css" media="screen" title="no title" charset="utf-8">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>


      <article class="container">
        <div class="page-header">
          <h1 style="text-align: center">로그인 </h1>
        </div>
        <div class="col-md-6 col-md-offset-119 ">
          <form role="form" action="./signIn.php" method="post" onsubmit="return checkSubmit()">
            <div class="form-group ">
              <label for="InputEmail">이메일 주소</label>
              <input type="email" class="form-control" name="InputEmail" id="InputEmail" placeholder="이메일 주소">

            </div>
            <div class="form-group">
              <label for="InputPassword1">비밀번호</label>
              <input type="password" class="form-control" name ="memberPw" id="InputPassword1" placeholder="비밀번호">
            </div>

            <div class="form-group text-center">



                <script>
                    function checkFunc(chkbox)
                    {
                        if ( chkbox.checked == true )
                        {
                            alert("자동 로그인은 개인용 PC에서만 사용하시기 바랍니다.");
                        }
//                        else
//                        {
//                            alert("선택 해제");
//                        }
                    }


                </script>

              <button type="submit" class="btn btn-info btn-block">로그인<i class="fa fa-check spaceLeft"></i></button>



              <!--<button type="submit" class="btn btn-warning">가입취소<i class="fa fa-times spaceLeft"></i></button>-->
            </div>
              <div style="padding-bottom: 10px;border-bottom: 1px solid gainsboro; margin-bottom: 20px; " >
                  <label  class="UICheckbox">
                      <input type="checkbox"  name="auto_login" value="on" onclick="checkFunc(this)">

                      <span class="UICheckbox-label">로그인 상태 유지</span>
                  </label>
              </div>

            <div class="form-group text-center">

              <a class="btn btn-primary btn-block" role="button" href="../joinMember">회원가입</a>
              <!--<button type="submit" class="btn btn-warning">가입취소<i class="fa fa-times spaceLeft"></i></button>-->
            </div>
          </form>
        </div>

      </article>

    <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
