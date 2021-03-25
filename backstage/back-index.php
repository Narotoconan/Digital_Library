<?php
session_start();
if (empty($_SESSION['adminID'])) {
    header("Location: ../login.php");
}
$adminID = $_SESSION['adminID'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>数字图书馆后台管理</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
    <link rel="stylesheet" href="../lib/css/back-css/back-index.css">
</head>
<body>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>

<nav class="navbar navbar-light bg-light" style="height: 80px">
    <div class="container">
        <a class="navbar-brand" href="#">
            <img src="../resources/logo.png" height="55px" class="d-inline-block align-middle" alt="">
            <span style="font-size: 24px;color: #7e8188" class="ml-4">后台管理</span>
        </a>
        <div class="justify-content-end">
            <img src="../resources/static/admin.png" alt="admin" class="adminAv" style="vertical-align: middle">
            <span class="ml-3">管理员</span>
        </div>
    </div>
</nav>

<div id="index" class="mt-5">
    <div class="container">
        <div class="row">
            <div class="col-2">
                <el-row class="tac">
                    <el-col>
                        <el-menu
                                default-active="1"
                                class="el-menu-vertical-demo"
                                @open="handleOpen"
                                @close="handleClose">
                            <el-menu-item index="1" @click="getHomePage">
                                <i class="el-icon-s-home" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">后台主页</span>
                            </el-menu-item>
                            <el-menu-item index="2" @click="getUserManagement" class="mt-4">
                                <i class="el-icon-user-solid" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">用户管理</span>
                            </el-menu-item>
                            <el-submenu index="3" class="mt-4">
                                <template slot="title">
                                    <i class="el-icon-s-management" style="font-size: 1.5rem"></i>
                                    <span class="ml-2" style="font-size: 16px">图书管理</span>
                                </template>
                                <el-menu-item-group>
                                    <el-menu-item index="3-1" style="font-size: 16px;" @click="getBookManagement">图书管理
                                    </el-menu-item>
                                    <el-menu-item index="3-2" style="font-size: 16px;" @click="bookAddPage">添加图书
                                    </el-menu-item>
                                </el-menu-item-group>
                            </el-submenu>
                            <el-menu-item index="4" class="mt-4" @click="getCommentManagement">
                                <i class="el-icon-s-comment" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">评论管理</span>
                            </el-menu-item>
                            <el-menu-item index="5" class="mt-4" @click="getBorrowManagement">
                                <i class="el-icon-notebook-2" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">查看借阅</span>
                            </el-menu-item>
                            <el-menu-item index="6" class="mt-4" @click="getAnnouncement">
                                <i class="el-icon-s-promotion" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">公告管理</span>
                            </el-menu-item>
                            <el-menu-item index="7" class="mt-4" @click="getSlidePage">
                                <i class="el-icon-picture" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">轮播管理</span>
                            </el-menu-item>
                            <el-menu-item index="8" class="mt-4" @click="exitLoad">
                                <i class="el-icon-s-help" style="font-size: 1.5rem"></i>
                                <span slot="title" class="ml-2" style="font-size: 16px">退出登录</span>
                            </el-menu-item>
                        </el-menu>
                    </el-col>
                </el-row>
            </div>
            <div class="col-10" id="content" style="height: 800px">
                <!--后台主页-->
                <div v-if="page.homePage">
                    <div id="page">
                        <div class="row">
                            <div class="col">
                                <div class="p-4"
                                     style="height: 15rem;border-radius:15px;background: linear-gradient(159deg, #007bff 0%, rgb(2, 220, 255) 100%)">
                                    <div class="position-relative" style="height: 100%">
                                        <span style="color: #f2f2f2;font-size: 1.5rem">图书总借阅量</span>
                                        <span class="position-absolute"
                                              style="left: 0;bottom: 0;font-size: 5rem;color: #f2f2f2">{{ homeData.bookBorrow }}</span>
                                        <i class="position-absolute el-icon-notebook-2"
                                           style="right: 0;bottom: 0;font-size: 10rem;color: #ffffff;opacity: 0.5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-4"
                                     style="height: 15rem;border-radius:15px;background:linear-gradient(159deg, rgb(25, 206, 130) 0%, rgb(100, 232, 196) 100%)">
                                    <div class="position-relative" style="height: 100%">
                                        <span style="color: #ffffff;font-size: 1.5rem">图书总浏览量</span>
                                        <span class="position-absolute"
                                              style="left: 0;bottom: 0;font-size: 5rem;color: #f2f2f2">{{ homeData.bookVisits }}</span>
                                        <i class="position-absolute el-icon-stopwatch"
                                           style="right: 0;bottom: 0;font-size: 10rem;color: #ffffff;opacity: 0.5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 m-2"></div>
                            <div class="col">
                                <div class="p-4"
                                     style="height: 10rem;border-radius:15px;background:linear-gradient(159deg, rgb(247,181,107) 0%, rgb(242,127,89) 100%)">
                                    <div class="position-relative" style="height: 100%">
                                        <span style="color: #ffffff;font-size: 1.5rem">图书总量</span>
                                        <span class="position-absolute"
                                              style="left: 0;bottom: 0;font-size: 3rem;color: #f2f2f2">{{ homeData.bookCount }}</span>
                                        <i class="position-absolute el-icon-notebook-1"
                                           style="right: 0;bottom: 0;font-size: 7rem;color: #ffffff;opacity: 0.5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col">
                                <div class="p-4"
                                     style="height: 10rem;border-radius:15px;background:linear-gradient(159deg, rgb(199,199,199) 0%, rgb(153,153,153) 100%)">
                                    <div class="position-relative" style="height: 100%">
                                        <span style="color: #ffffff;font-size: 1.5rem">用户数量</span>
                                        <span class="position-absolute"
                                              style="left: 0;bottom: 0;font-size: 3rem;color: #f2f2f2">{{ homeData.userCount }}</span>
                                        <i class="position-absolute el-icon-user"
                                           style="right: 0;bottom: 0;font-size: 7rem;color: #ffffff;opacity: 0.5"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="w-100 m-2"></div>
                            <div class="col">
                                <div class="p-4"
                                     style="height: 10rem;border-radius:15px;background:linear-gradient(159deg, rgb(255,195,173) 0%, rgb(255,175,189) 100%)">
                                    <div class="position-relative" style="height: 100%">
                                        <span style="color: #ffffff;font-size: 1.5rem">评论数量</span>
                                        <span class="position-absolute"
                                              style="left: 0;bottom: 0;font-size: 3rem;color: #f2f2f2">{{ homeData.commentCount }}</span>
                                        <i class="position-absolute el-icon-s-comment"
                                           style="right: 0;bottom: 0;font-size: 7rem;color: #ffffff;opacity: 0.5"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--用户管理-->
                <div v-if="page.userManagement" class="h-100">
                    <iframe src="userManagement.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--图书管理-->
                <div v-if="page.bookManagement" class="h-100">
                    <iframe src="bookManagement.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--图书添加-->
                <div v-if="page.bookAdd" class="h-100">
                    <iframe src="bookAddPage.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--评论管理-->
                <div v-if="page.commentManagement" class="h-100">
                    <iframe src="commentPage.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--借阅管理-->
                <div v-if="page.borrowManagement" class="h-100">
                    <iframe src="borrowManagement.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--轮播管理-->
                <div v-if="page.slidePage" class="h-100">
                    <iframe src="slidePage.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
                <!--公告发布-->
                <div v-if="page.putAnnouncement" class="h-100">
                    <iframe src="announcementPage.php" frameborder="0" style="width: 100%;height: 100%"></iframe>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const index = new Vue({
        el: "#index",
        data() {
            return {
                page: {
                    homePage: 1,
                    userManagement: 0,
                    bookManagement: 0,
                    commentManagement: 0,
                    borrowManagement: 0,
                    bookAdd: 0,
                    slidePage: 0,
                    putAnnouncement: 0,
                },
                homeData: '',
            };
        },
        mounted: function () {
            this.getHomePage();
        },
        methods: {
            handleOpen(key, keyPath) {
            },
            handleClose(key, keyPath) {
            },
            initialization(tarPage){
                for (let argumentsKey in this.page) {
                    if (argumentsKey===tarPage){
                        this.page[argumentsKey] = 1;
                    }else {
                        this.page[argumentsKey] = 0;
                    }
                }
            },
            getHomePage() {
                this.initialization('homePage');
                let vm = this;
                $.post("../api/back-api/getHomeData.php", {
                    adminID:<?php echo $adminID?>
                }, function (result) {
                    vm.homeData = result;
                })
            },
            getUserManagement() {
                this.initialization('userManagement');
            },
            getBookManagement() {
                this.initialization('bookManagement');
            },
            bookAddPage() {
                this.initialization('bookAdd');
            },
            getCommentManagement() {
                this.initialization('commentManagement');
            },
            getBorrowManagement(){
                this.initialization('borrowManagement');
            },
            getSlidePage(){
                this.initialization('slidePage');
            },
            getAnnouncement(){
                this.initialization('putAnnouncement');
            },
            exitLoad(){
                $(window).attr('location','../index.php')
            }
        }
    })
</script>

</body>
</html>
