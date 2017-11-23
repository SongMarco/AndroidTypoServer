<!DOCTYPE html>
<html>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=9">
<head>
    <!-- 레이어팝업시작 -->
    <script language='javascript'>
        function setCookie(name, value, expiredays){
            var todayDate = new Date();
            // 만료날짜를 오늘날짜로 설정함.
            todayDate.setDate (todayDate.getDate() + expiredays);

            document.cookie = name + "=" + escape(value) + "; path=/; expires=" + todayDate.toGMTString() + ";";
        }

        function closePop(){
            if (document.frm.pop.checked){
                setCookie("popState", "noSee", 1);
            }
            self.close();
        }
    </script>
</head>
<body>
<form name="frm">
    <div class="PopupWindow">
        <div class="PopupButton">
            <a onClick="opener.location.href='http://google.com'; self.close();" target="_blank"><img src="../assets/img/autumn.jpg" style="width:80%; height:80%;"></a>
        </div>
        <div class="PopupBottom">
            <div style="text-align: right" class="PopupText">오늘 하루만 보기
                <input class="PopupCheck" type='checkbox' name='pop' onClick='closePop()'>
            </div>

        </div>
    </div>
</form>
</body>
</html>