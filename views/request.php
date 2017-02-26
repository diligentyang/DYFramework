<html>
<head>
    <title>viewTest</title>
</head>
<body>
<?php
echo $name;
var_dump(\lib\Url::siteUrl());
?>
<h1>this is view</h1>
<form action="" method="post">
    <input type="text" name="message">
    <input type="submit" value="提交">
</form>
</body>
</html>