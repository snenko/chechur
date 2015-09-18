<?php /*без session_start() не хочуте працювати $_SESSION*/ ?>
<?php session_start(); ?>
<html lang="uk">
<head>
    <meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
    <title></title>
    <link rel="stylesheet" type="text/css" href="css/style.css"/>
</head>
<body>
<?php

include_once "system/system.php";
include_once "system/db.php";

?>
<header>
    <?php include_once '/block/menu.php'; ?>
    <?php include_once '/block/logo.php'; ?>
</header>
<hr>
<div class="content">
    <?php getContent() ?>
</div>
<hr>
<footer>
@Власність корпорації
</footer>
</body>
</html>