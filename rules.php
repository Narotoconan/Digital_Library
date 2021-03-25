<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>announcement</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
</head>
<body style="background-color: #f2f2f2">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>

<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php'?>
</div>

<div id="ann">
    <div class="container">
        <div style="text-align: center" class="mt-5">
            <h2>图书馆规章制度</h2><br>
            <span class="mt-3"></span>
        </div>
        <hr style="color: #cfcfcf"/>
        <div>
            <h5 class="mt-3">管理员工作职责</h5>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px" class="mt-2">
                一、严格执行图书馆、阅览室的规章制度，保持馆内的清洁卫生和良好秩序。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                二、掌握新书出版信息，添购书籍，充实书库。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                三、及时做好书报刊订阅工作，月底、年底做好收、装、订保管工作。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                四、经常做好书籍、资料，及时送各相关教研组。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                五、进行爱护书籍的宣传教育，做好图书的防潮、防蛀的工作和图书修补工作。
            </p>
        </div>
        <div>
            <h5 class="mt-3">图书借阅制度</h5>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px" class="mt-2">
                一、根据实际情况和读者需求，图书馆分设社科图书阅览室、自科图书阅览室、期刊阅览室、教师阅览室、电子阅览室等各类阅览室。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                二、读者凭借阅证换取代书板（阅览证），并在读者签到簿上签到，方可入室阅览。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                三、读者选取书刊时请正确使用代书板，每次限取一册，书刊阅毕后请放回原处。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                四、读者应爱护所有文献，保持书架的整洁，凡发现有撕毁、偷窃、圈划、污损书刊者，一律按学院有关规定处理。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                五、读者须自觉遵守国家有关法律法规，不得制作、查阅、复制和传播妨碍社会治安的信息和淫秽色情等信息。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                六、爱护室内设备，遵守有关注意事项。保持室内安静，做文明读者。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                七、读者要爱护图书，不得污损、撕毁、批注和丢失，如有上述情况应按制度赔偿。对于违章的读者，在未办妥有关赔偿手续前，暂停其借阅权利。
            </p>
            <p style="text-indent: 2em; font-size: 16px;line-height: 32px">
                八、各室书刊实行开架借阅，其中社科阅览室和自科阅览室图书供外借，其他各阅览室图书仅限于室内阅览，概不外借，亦不得带出室外。
            </p>
        </div>
    </div>
</div>
