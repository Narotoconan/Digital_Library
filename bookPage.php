<?php
session_start();
require_once ("components/inquire.php");
require_once ("components/increase.php");
if (empty($_GET['bookID'])||$_GET['bookID']==''){
    exit("<h1>请传入有效参数</h1>");
}
$bookID=$_GET['bookID'];
$theBookMg=inquire("SELECT
	booklist.*, 
	bookcategory.bookCategory
FROM
	booklist
	INNER JOIN bookcategory ON booklist.bookCategory = bookcategory.categoryNum
WHERE
	booklist.bookID = '{$bookID}'");

$addviews=increase("UPDATE booklist SET booklist.bookVisits= booklist.bookVisits+1 WHERE booklist.bookID = '{$bookID}'");

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>bookPage</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
    <link rel="stylesheet" href="lib/css/bookPage.css">
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

<div class="pt-5 pb-5 position-relative bookBc">
    <div class="container">
        <div class="row">
            <div class="col-10">
                <ul class="clearfix">
                    <li class="float-left">
                        <div class="bookCover" style="background:url('<?php echo $theBookMg[0]['bookCover']?>') no-repeat center;background-size: cover"></div>
                    </li>
                    <li class="float-left ml-4 pt-3 pb-3">
                        <ul class="bookMg flex-column">
                            <li><h4 style="font-weight: 700"><?php echo $theBookMg[0]['bookName']?></h4></li>
                            <li class="mt-4">作者：<?php echo $theBookMg[0]['bookAuthor']?></li>
                            <li>出版社：<?php echo $theBookMg[0]['bookPress']?></li>
                            <li>出版日期：<?php echo $theBookMg[0]['bookPublishedDate']?></li>
                            <li>上传日期：<?php echo $theBookMg[0]['bookUpload']?></li>
                            <li>
                                <div class="category mb-1" style="font-size: 12px">
                                    <?php echo $theBookMg[0]['bookCategory']?>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="col-2 pt-3 border-left border-Light pl-5" id="mes">
                <h5>图书评分</h5>
                <div id="rate" class="mt-2" style="height: 2rem">
                    <el-rate
                        v-model="value"
                        disabled
                        show-score
                        text-color="#ff9900"
                        score-template="{value}">
                    </el-rate>
                </div>
                <h5 class="mt-2">借阅量</h5>
                <h5 class="text-success mt-2"><?php echo $theBookMg[0]['bookBorrow']?></h5>
                <h5 class="mt-3">浏览量</h5>
                <h5 class="text-primary mt-2"><?php echo $theBookMg[0]['bookVisits']?></h5>
            </div>
        </div>
    </div>
</div>

<div id="contents">
    <div id="actions">
        <div class="container">
            <div class="row">
                <div class="bookIntroduction col-8 pt-5">
                    <h5>
                        <span style="font-family: icomoon;color: #0076d6;vertical-align: middle;font-size: 2rem"></span>
                        图书简介
                    </h5>
                    <p class="mt-4" style="line-height: 2rem">
                        <?php echo $theBookMg[0]['bookIntroduction']?>
                    </p>
                </div>
                <div class="col-4 pt-5 mt-3">
                    <div class="use-btn">
                        <div class="mt-5">
                            <div v-if="bookStatus==2">
                                <button type="button" class="btn btn-primary" style="width: 200px" @click="borrow">我要借阅</button>
                            </div>
                            <div v-if="bookStatus==1">
                                <button type="button" class="btn btn-danger" style="width: 200px" @click="cancelBorrow">取消借阅</button>
                            </div>

                        </div>
                        <div>
                            <button type="button" class="btn btn-success mt-4" style="width: 200px" @click="pdf">在线浏览</button>
                        </div>
                        <div>
                            <a :href="downloadurl" download="<?php echo $theBookMg[0]['bookName']?>.pdf" class="btn btn-warning mt-4" style="width: 200px;color: #ffffff" @click="download" >下载文档</a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <div id="comments" class="mt-5">
        <div class="container">
            <div class="row">
                <div class="col-9">
                    <h5>
                        <span style="font-family: icomoon;font-size: 1.7rem;color: #d6aa38;vertical-align: middle"></span>
                        评 论
                    </h5>
                    <div id="myComment">
                        <div class="form-group mt-3">
                            <label for="myComments"></label>
                            <textarea class="form-control" id="myComments" rows="3" v-model="textarea"></textarea>
                        </div>
                        <div style="text-align: right">
                            <button type="button" class="btn btn-primary" id="upComment" @click="putComment">提交评论</button>
                        </div>
                    </div>
                    <div id="commentsList">
                            <div class="media mb-5" style="cursor: default" v-for="item in bookComment" :key="item">
                                <img :src="item.userAvatar" class="mr-3 mt-2" alt="" style="height: 2.5rem;width: 2.5rem;border-radius: 50%">
                                <div class="media-body">
                                    <h5 class="mt-0">{{ item.userName }}</h5>
                                    <small class="text-muted">{{ item.commentDate }}</small>
                                    <p class="mt-2">
                                        {{ item.comments }}
                                    </p>
                                        <div v-if="item.reply">
                                            <div class="media mt-5">
                                                <a class="mr-3" href="#">
                                                    <img src="./resources/static/admin.png" class="mr-3 mt-2" alt="admin" style="height: 2.5rem;width: 2.5rem;border-radius: 50%">
                                                </a>
                                                <div class="media-body">
                                                    <h5 class="mt-0">管理员回复</h5>
                                                    <small class="text-muted">{{ item.replyDate }}</small>
                                                    <p class="mt-2">
                                                        {{ item.reply }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                </div>
                            </div>
                    </div>
                </div>
                <div class="col-3"></div>
            </div>
        </div>
    </div>
</div>


<script>
    const rate=new Vue({
        el:"#rate",
        data(){
            return{
                value:<?php echo $theBookMg[0]['bookScore']?>
            }
        }
    });
    const comment=new Vue({
        el:"#contents",
        data() {
            return {
                textarea:'',
                message:'',
                bookStatus:"2",
                downloadurl:"#",
                bookComment:''
            };
        },
        mounted:function(){
          this.borrowStatus();
          this.getBookComment()
        },
        methods:{
            getBookComment(){
              let vm =this;
              $.post("api/getBookComment.php",{
                  bookID:<?php echo $bookID?>
                },function (result) {
                    vm.bookComment=result;
                })
            },
            putComment(){
                <?php if (isset($userId)):?>
                    let vm=this;
                    $.post("api/putComment.php",{
                        putComment : vm.textarea,
                        userID:<?php echo $userId?>,
                        bookID:<?php echo $bookID?>
                    },function (result) {
                        if (result!=="提交成功"){
                            vm.message=result;
                            vm.errorMgs();
                        }else {
                            vm.message=result;
                            vm.successMg();
                            vm.textarea='';
                            vm.getBookComment();
                        }
                    });
                    <?php else:?>
                        this.message="请先注册/登录账户";
                        this.errorMgs(this.message);
                <?php endif;?>
            },
            errorMgs() {
                this.$message.error(this.message);
            },
            successMg() {
                this.$message({
                    message:this.message,
                    type: 'success'
                });
            },
            pdf(){
                <?php if (isset($userId)):?>
                    $(window).attr("location","PDF.js/web/viewer.html?file=<?php echo substr($theBookMg[0]['bookDownload'],1)?>");
                    <?php else:?>
                        this.message="请先注册/登录账户";
                         this.errorMgs(this.message);
                <?php endif;?>
            },
            borrow(){
                <?php if (isset($userId)):?>
                    let vm=this;
                    $.post("api/borrowBook.php",{
                        userID:<?php echo $userId?>,
                        bookID:<?php echo $bookID?>
                    },function (result) {
                        if (result!=="借阅成功"){
                            vm.message=result;
                            vm.errorMgs();
                        }else {
                            vm.message=result;
                            vm.successMg();
                            vm.borrowStatus();
                        }
                    });
                <?php else:?>
                    this.message="请先注册/登录账户";
                    this.errorMgs(this.message);
                <?php endif;?>
            },
            borrowStatus(){
                <?php if (isset($userId)):?>
                    let vm=this;
                    $.post("api/borrowStatus.php",{
                        userID:<?php echo $userId?>,
                        bookID:<?php echo $bookID?>
                    },function (result) {
                        vm.bookStatus=result;
                    });
                <?php endif;?>

            },
            cancelBorrow(){
                <?php if (isset($userId)):?>
                    let vm=this;
                    $.post("api/cancelBorrow.php",{
                        userID:<?php echo $userId?>,
                        bookID:<?php echo $bookID?>
                    },function (result) {
                        if (result!=="取消成功"){
                            vm.message=result;
                            vm.errorMgs();
                        }else {
                            vm.message=result;
                            vm.successMg();
                            vm.borrowStatus();
                        }
                    });
                <?php endif;?>
            },
            download(e){
                <?php if (isset($userId)):?>
                    this.downloadurl="/resources/book/bookDownload/example.pdf";
                    <?php else:?>
                        this.message="请先注册/登录账户";
                        this.errorMgs(this.message);
                        e.preventDefault();
                <?php endif;?>
            }
        }
    });

</script>


</body>
</html>
