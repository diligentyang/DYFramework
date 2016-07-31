<html>
<head>
    <title>viewTest</title>
</head>
<body>
    <h1>this is view</h1>
    <?php
        echo $admin;
        foreach($user as $val){
            echo $user['username']."---";
        }
    ?>
</body>
</html>