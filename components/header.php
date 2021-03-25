<?php
    require_once("inquire.php");
    if (isset($_SESSION['userId'])){
        $userId = $_SESSION['userId'];
        $data=inquire("SELECT userlist.userName, userlist.userAvatar FROM userlist WHERE userlist.userID = '{$userId}'");
        $messageCount=inquire("SELECT COUNt(1) FROM commentlist WHERE commentlist.userID = '{$userId}' AND commentlist.replyView = 1");
        $borrowCount=inquire("SELECT COUNt(1) FROM borrowlist WHERE borrowlist.userID = '{$userId}' AND borrowlist.borrowStatus = 1");
        $borrowCount=(int)$borrowCount[0]["COUNt(1)"];
        $messageCount=(int)$messageCount[0]["COUNt(1)"];
    } else{
        setcookie(session_name(), '', time()-42000, '/');
    }
?>
<link rel="stylesheet" href="lib/css/header.css">
<div class="container">
    <div class="row">
        <h1 class="col pr-0 header-height" style="line-height: 70px">
            <a href="index.php">
                <img src="resources/logo.png" alt="" style="height: 55px">
            </a>
        </h1>
        <div class="search col pl-0 pr-0  header-height" style="line-height: 70px" @keydown.enter="toSearch">
            <el-input
                    placeholder="请输入内容"
                    prefix-icon="el-icon-search"
                    v-model="search">
            </el-input>
        </div>
        <ul class="col header-height" id="headerNav">
            <div class="row list">
                <li class="col" style="text-align: center;line-height: 80px;cursor: default">
                    <a href="index.php">首 页</a>
                </li>
                <li class="col pr-0" style="text-align: left;line-height: 80px;cursor: default">
                    <el-dropdown >
                  <span class="el-dropdown-link" style="font-size: 16px">
                    热 门<i class="el-icon-arrow-down el-icon--right"></i>
                  </span>
                        <el-dropdown-menu slot="dropdown">
                            <div id="drowdowmList">
                                <ul class="row ml-5 mr-5" style="width: 40rem;text-align: center;font-size: 24px">
                                    <li class="col">
                                        <a href="searchPage.php?search=vue">
                                            <span style="font-family:icomoon;color: #5cd69b"></span>
                                            <span>Vue.js</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a href="searchPage.php?search=angular">
                                            <span style="font-family:icomoon;color: #d63825"></span>
                                            <span>Angular</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a href="searchPage.php?search=react">
                                            <span style="font-family:icomoon;color: #00c1ff"></span>
                                            <span>React</span>
                                        </a>
                                    </li>
                                </ul>
                                <ul class="row ml-5 mr-5" style="width: 40rem;text-align: center;font-size: 24px">
                                    <li class="col">
                                        <a href="searchPage.php?search=html5">
                                            <span style="font-family:icomoon;color: #e34f26"></span>
                                            <span>HTML5</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a href="searchPage.php?search=javascript">
                                            <span style="font-family:icomoon;color: #f7df1e"></span>
                                            <span>Javascript</span>
                                        </a>
                                    </li>
                                    <li class="col">
                                        <a href="searchPage.php?search=css">
                                            <span style="font-family:icomoon;color: #1572b6"></span>
                                            <span>CSS3</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </el-dropdown-menu>
                    </el-dropdown>
                </li>
                <li class="col pl-0" style="text-align: center;line-height: 80px;cursor: default">
                    <?php if (isset($userId)):?>
                        <el-dropdown>
                        <span class="el-dropdown-link" style="text-align: left">
                            <img src="<?php echo $data[0]['userAvatar']?>" alt="<?php echo $data[0]['userName']?>" id="userAvatar" style="margin-right: 5px">
                            <span style="display: inline-block;max-width: 52px;overflow: hidden;vertical-align: middle;white-space: nowrap;text-overflow: ellipsis;"><?php echo $data[0]['userName']?></span>
                        </span>
                            <el-dropdown-menu slot="dropdown">
                                <ul class="nav flex-column" style="text-align: center;width: 9.5rem">
                                    <li class="nav-item ml-0">
                                        <a href="personPage.php">
                                            <span style="font-family:icomoon;font-size: 1.5rem;vertical-align: middle" class="mr-2"></span>
                                            <span style="vertical-align: middle">个人中心</span>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-0 position-relative">
                                        <a href="personPage.php#myBorrow">
                                            <span style="font-family:icomoon;font-size: 1.5rem;vertical-align: middle" class="mr-2"></span>
                                            <span style="vertical-align: middle">我的借阅</span>
                                            <?php if ($borrowCount):?>
                                                <div class="position-absolute" style="right: 1px;top: 0">
                                                    <el-badge :value="<?php echo $borrowCount?>" />
                                                </div>
                                            <?php endif?>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-0 position-relative">
                                        <a href="personPage.php#myMessage">
                                            <span style="font-family:icomoon;font-size: 1.5rem;vertical-align: middle" class="mr-2"></span>
                                            <span style="vertical-align: middle">我的消息</span>
                                            <?php if ($messageCount):?>
                                                <div class="position-absolute" style="right: 1px;top: 0">
                                                    <el-badge :value="<?php echo $messageCount?>" />
                                                </div>
                                            <?php endif?>
                                        </a>
                                    </li>
                                    <li class="nav-item ml-0">
                                        <a href="#" id="exit">
                                            <span style="font-family:icomoon;font-size: 1.5rem;vertical-align: middle" class="mr-2"></span>
                                            <span style="vertical-align: middle">退出登录</span>
                                        </a>
                                    </li>
                                </ul>
                            </el-dropdown-menu>
                        </el-dropdown>
                    <?php else:?>
                        <a href="login.php" id="login">
                            <span class="icomoon mr-3"></span>
                            <span>登录</span>
                        </a>
                    <?php endif;?>
                </li>
            </div>

        </ul>
    </div>

</div>

<script>
    const header=new Vue({
        el:"#header",
        data() {
            return {
                search:"",
            };
        },
        mounted: function () {
            <?php if (isset($userId)):?>
                <?php if (empty($_SESSION['login'])):?>
                    this.open1();
                <?php endif;?>
            <?php endif;?>
        },
        methods: {
            handleSelect(key, keyPath) {
            },
            open1(){
                this.$notify({
                    title: '成功',
                    message: '登录成功',
                    type: 'success'
                });
            },
            toSearch(){
                if (this.search.length!==0){
                    if (this.search==='c++'){
                        $(window).attr("location","searchPage.php?search=c%2B%2B");
                    }else {
                        $(window).attr("location","searchPage.php?search="+ escape(this.search));
                    }
                }
            }
        }
    });
    $("#exit").bind("click",function () {
        $(this).attr("href","exitLoad.php");
    });
</script>
<?php
$_SESSION['login']='1';
