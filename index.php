<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="favicon.ico">
    <title>数字图书馆</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
</head>
<body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>

<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php'?>
</div>

<!--轮播图-->
<div id="slide" class="mt-3">
    <?php include 'components/slide.php'?>
</div>

<!--推荐-->
<div id="bookRecommend" class="mt-3" style="background-color: #f5f5f5;">
    <?php include 'components/recommend.php'?>
</div>

<!--Top榜单-->
<div id="rankTop">
    <?php include 'components/rankTop.php'?>
</div>

<!--底部加载-->
<div id="footer">
    <?php include 'components/footer.php'?>
</div>

</body>
</html>
