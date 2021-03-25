<?php
require_once("components/inquire.php");
$data=inquire("SELECT bannenrlist.bannerImg FROM bannenrlist");
$data=json_encode($data);
?>
<link rel="stylesheet" href="../lib/css/slide.css">
    <div class="container">
        <div class="position-relative row">
            <div class="col">
                <div class="slide-nav">
                    <ul class="flex-column" id="nav-list">
                        <li class="nav-item">
                            <span style="color: #ffffff"></span>
                            <span>网页开发</span>
                            <div class="content hide" style="box-shadow: 0 0 15px 0 rgba(0,0,0,.2)">
                                <div class="web">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2" style="color: #606266;">前端基础</h5>
                                        <ul class="flot-left clearfix mt-4">
                                            <li><a href="searchPage.php?search=html"><img src="./resources/static/web-html-0.png" alt="html"></a></li>
                                            <li><a href="searchPage.php?search=css"><img src="./resources/static/web-css-0.png" alt="css"></a></li>
                                            <li><a href="searchPage.php?search=javascript"><img src="./resources/static/web-js-0.png" alt="js"></a></li>
                                        </ul>
                                        <h5 class="card-title mt-5" style="color: #606266;">前端进阶</h5>
                                        <ul class="flot-left clearfix mt-4">
                                            <li><a href="searchPage.php?search=jquery"><img src="./resources/static/web-jq-1.png" alt="jquery"></a></li>
                                            <li><a href="searchPage.php?search=css"><img src="./resources/static/web-less-1.png" alt="less"></a></li>
                                            <li><a href="searchPage.php?search=css"><img src="./resources/static/web-flex-1.png" alt="flexbox"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <span style="color: #ffffff"></span>
                            <span>语言编程</span>
                            <div class="content hide" style="box-shadow: 0 0 15px 0 rgba(0,0,0,.2)">
                                <div class="code">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2" style="color: #606266;">编程语言</h5>
                                        <ul class="flot-left clearfix mt-4">
                                            <li><a href="searchPage.php?search=java"><img src="./resources/static/code-java.png" alt="java"></a></li>
                                            <li><a href="searchPage.php?search=php"><img src="./resources/static/code-php.png" alt="php"></a></li>
                                            <li><a href="searchPage.php?search=python"><img src="./resources/static/code-python.png" alt="python"></a></li>
                                        </ul>
                                        <h5 class="card-title mt-5" style="color: #606266;">C语言</h5>
                                        <ul class="flot-left clearfix mt-4">
                                            <li><a href="searchPage.php?search=c"><img src="./resources/static/code-c.png" alt="c"></a></li>
                                            <li><a href="searchPage.php?search=c%23"><img src="./resources/static/code-c1.png" alt="c#"></a></li>
                                            <li><a href="searchPage.php?search=c%2B%2B"><img src="./resources/static/code-c2.png" alt="c++"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <span style="color: #ffffff"></span>
                            <span>操作系统</span>
                            <div class="content hide" style="box-shadow: 0 0 15px 0 rgba(0,0,0,.2)">
                                <div class="system">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2" style="color: #606266;">操作系统学习</h5>
                                        <ul class="flot-left clearfix mt-5">
                                            <li><a href="searchPage.php?search=windows"><img src="./resources/static/system-windows.png" alt="windows"></a></li>
                                            <li><a href="searchPage.php?search=linux"><img src="./resources/static/system-linux.png" alt="linux"></a></li>
                                        </ul>
                                        <h5 class="card-title mt-5" ></h5>
                                        <ul class="flot-left clearfix mt-4">
                                            <li><a href="searchPage.php?search=android"><img src="./resources/static/system-android.png" alt="android"></a></li>
                                            <li><a href="searchPage.php?search=ios"><img src="./resources/static/system-ios.png" alt="ios"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <span style="color: #ffffff"></span>
                            <span>数据仓库</span>
                            <div class="content hide" style="box-shadow: 0 0 15px 0 rgba(0,0,0,.2)">
                                <div class="database">
                                    <div class="card-body">
                                        <h5 class="card-title mt-2" style="color: #606266;">数据库</h5>
                                        <ul class="flot-left clearfix mt-5">
                                            <li><a href="searchPage.php?search=mysql"><img src="./resources/static/database-mysql.png" alt="mysql"></a></li>
                                            <li><a href="searchPage.php?search=oracle"><img src="./resources/static/database-oracle.png" alt="oracle"></a></li>
                                            <li><a href="searchPage.php?search=sqlserver"><img src="./resources/static/database-sqlserver.png" alt="sqlserver"></a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="slide-img">
                    <el-carousel height="450px" direction="vertical" :autoplay="true" interval="5000">
                        <el-carousel-item v-for="item in slide" :key="item">
                            <img :src="item.bannerImg" alt="" style="width: 100%;height: 100%">
                        </el-carousel-item>
                    </el-carousel>
                </div>
            </div>

        </div>
    </div>


<script>
const slide=new Vue({
    el:"#slide",
    data() {
        return {
            slide:<?php echo $data?>
        };
    }
});
$("#nav-list>li").on("mouseenter",function () {
    var tarObj = $(this).children("div");
    window.temp=setTimeout(function () {
        $(tarObj).stop().fadeIn(250);
    }, 250);
}).on("mouseleave",function () {
    $(this).children("div").stop().fadeOut(250);
    clearTimeout(temp);
});
</script>
