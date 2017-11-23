<!doctype html>
<html>
<head>
    <title>join page</title>
</head>
<body>
<h2><br><center>join page</center>
    <form method="post" action="join_result.php">
        <b>ID</b><input type="text" size=10 maxlength=10 name="id"><br />
        <b>이름</b><input type="text" style="ime-mode: active" size=10 maxlength=10 name="yourname"><br />
        <b>비밀번호</b><input type="password" size=10 maxlength=10 name="pwd"><br />
        <b>비밀번호 확인</b><input type="password" size=10 maxlength=10 name="pwd2"><br />
        <b>휴대전화</b>

        <select name="m1">
            <option value=" ">select</option>
            <option value="010">010</option>
            <option value="011">011</option>
            <option value="016">016</option>
            <option value="017">017</option>
            <option value="018">018</option>
            <option value="019">019</option>
        </select>
        -
        <input type="text" size=4 name="m2" maxlength=4>
        -
        <input type="text" size=4 name="m3" maxlength=4><br />

        <b>성별</b>
        <input type="radio" name="sex" value="man" checked>man
        <input type="radio" name="sex" value="woman">woman <br />

        <b>주소</b><input type="text" size=60 name="addr"><br />

        <b>취미</b>
        <input type="checkbox" name="com" value="yes" checked> computer
        <input type="checkbox" name="sports" value="yes"> sports
        <input type="checkbox" name="shop" value="yes"> shopping
        <input type="checkbox" name="mov" value="yes"> movie <br />



        <input type="submit" value="회원가입" value="join">
        <input type="reset" value="다시 작성하기">
    </form>
</html>