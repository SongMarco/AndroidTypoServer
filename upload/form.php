<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <title>게시물 작성 예제 폼</title>
</head>
<body>


<!--주의사항 :: enctype="multipart/form-data" 이걸 꼭 해야 파일 업로드 가능하다.-->
<form enctype="multipart/form-data" name="form" method="post" action="write.php">
    <table>
        <tr>
            <td>아이디:</td>
            <td><input type="text" name="id" /></td>
        </tr>
        <tr>
            <td>내용:</td>
            <td><textarea name="content"></textarea></td>
        </tr>
        <tr>
            <td>이미지:</td>
            <td><input type="file" name="imageform" /></td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="전송" />
            </td>
        </tr>
    </table>
</form>
</body>
</html>
