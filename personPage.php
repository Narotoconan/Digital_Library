<?php
session_start();
require_once ("components/inquire.php");
if (empty($_SESSION['userId'])){
    exit("<h1>请输入有效参数</h1>");
}
$userID=$_SESSION['userId'];

?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>personPage</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
    <link rel="stylesheet" href="lib/css/personPage.css">
    <link rel="stylesheet" href="lib/css/recommend.css">
</head>
<body style="background-color: #f3f5fb">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>



<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php'?>
</div>

<div id="person">
    <div class="container">
        <div class="row mt-5">
            <div class="col-3">
                <div class="personMessage">
                    <div class="userAv pt-5">
                        <img :src="personMg.userAvatar" :alt="personMg.userName">
                        <h3 style="text-align: center;font-weight: 700" class="mt-3">{{ personMg.userName }}</h3>
                    </div>
                    <ul class="userList mt-5 pt-4 pl-4">
                        <li>
                            <span style="color:#ff9b7f"></span>
                            <span>用户名：</span>
                            <span>{{ personMg.userName }}</span>
                        </li>
                        <li>
                            <span style="color:#8b7cad"></span>
                            <span>用户ID：</span>
                            <span>{{ personMg.userID }}</span>
                        </li>
                        <li>
                            <span style="color:#64ad58"></span>
                            <span>性别：</span>
                            <span v-if="personMg.gender==1">男</span>
                            <span v-if="personMg.gender==2">女</span>
                        </li>
                        <li>
                            <span style="color:#4d5ca4"></span>
                            <span>注册日期：</span>
                            <span>{{ personMg.registerDate }}</span>
                        </li>
                        <li>
                            <span style="color:#00a1d0"></span>
                            <span>邮箱：</span>
                            <span>{{ personMg.userEmail }}</span>
                        </li>
                        <li></li>
                    </ul>
                </div>
            </div>
            <div class="col-9">
                <!--修改信息-->
                <div class="changeMg" data-toggle="collapse" href="#changeMgContent" aria-expanded="false" aria-controls="changeMgContent" onclick="showImg()"><h5>信息修改</h5></div>
                <div class="collapse mt-2" id="changeMgContent">
                    <div class="card card-body">
                        <div class="w-50">
                                <el-form :label-position="labelPosition" label-width="80px" :model="personChangeMg" enctype="multipart/form-data" id="changeForm">
                                    <el-form-item label="修改头像" >
                                        <div class="position-relative" id="bav">
                                            <img :src="imageUrl" alt="" id="uavImg" style="width: 8rem;height: 8rem">
                                            <input type="file" id="uavFile" class="position-absolute" style="width: 8rem;height: 8rem;top: 0;left: 0;opacity: 0" accept="image/jpeg">
                                        </div>
                                        <small class="text-muted">上传头像图片只能是 JPG 格式!</small><br/>
                                        <small class="text-muted">上传头像图片大小不能超过 2MB!</small>
                                    </el-form-item>
                                    <el-form-item label="用户名">
                                        <el-input v-model="personChangeMg.userName" name="userName"></el-input>
                                    </el-form-item>
                                    <el-form-item label="邮箱">
                                        <el-input v-model="personChangeMg.userEmail" name="userEamil"></el-input>
                                    </el-form-item>
                                    <el-form-item label="性别">
                                        <el-radio v-model="personChangeMg.gender" label="1" name="gender">男</el-radio>
                                        <el-radio v-model="personChangeMg.gender" label="2" name="gender">女</el-radio>
                                    </el-form-item>
                                    <el-form-item>
                                        <el-button type="primary" @click="putChangeMg">提交修改</el-button>
                                    </el-form-item>
                                </el-form>
                        </div>
                    </div>
                </div>
                <!--我的借阅-->
                <div class="myBorrow mt-3 pb-4" id="myBorrow">
                    <h5 class="pt-3 mb-4">我的借阅</h5>
                    <div class="d-flex flex-wrap">
                        <div v-if="myBorrow.length">
                            <div v-for="item in myBorrow" :key="item" class="d-inline-block">
                                <a :href="'bookPage.php?bookID='+item.bookID">
                                    <div class="p-2 mr-5">
                                        <small class="text-muted">借阅: {{ item.borrowBegin }}</small>
                                        <div class="card bookItems" style="width: 13.406rem">
                                            <img :src="item.bookCover" class="card-img-top" :alt="item.bookName">
                                            <div class="card-body">
                                                <h5 class="card-title overflow-hidden bookName">{{ item.bookName }}</h5>
                                                <div class="category mb-1" style="font-size: 12px">
                                                    {{ item.bookCategory }}
                                                </div>
                                                <p class="card-text small mb-1">{{ item.bookAuthor }}</p>
                                                <p class="card-text small text-black-50">{{ item.bookPress }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div v-else style="height: 30rem;width: 100%" class="position-relative">
                            <div style="width: 20rem;height: 10rem;position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);font-size: 5rem;color: #f3f3f3">暂无借阅</div>
                        </div>
                    </div>
                </div>

                <!--我的消息-->
                <div class="myMessage mt-3 mb-5" style="height: 40rem" id="myMessage">
                    <h5 class="pt-3 mb-4">我的消息</h5>
                    <div v-if="myMessages.length">
                        <div @mouseenter="messageVisited">
                            <div class="media replyCard mb-4" v-for="item in myMessages" style="cursor: default">
                                <img src="resources/static/admin.png" class="mr-3" alt="..." style="height: 2.5rem;width: 2.5rem;border-radius: 50%;box-shadow: 0 0 15px 0 rgba(53,53,53,0.24);">
                                <div class="media-body">
                                    <h5 class="mt-0 mb-3">管理员回复： </h5>
                                    {{ item.reply }}
                                    <div class="mt-2 pl-3" style="color: #bbbbbb">我的评论: {{item.comments}}</div>
                                    <div class="mt-2">
                                        <a :href="'bookPage.php?bookID=' + item.bookID">
                                            <small class="bookLink" style="color: #8c8c8c">{{ item.bookName }}</small>
                                        </a>
                                    </div>
                                </div>
                                <small class="text-muted">{{ item.replyDate }}</small>
                            </div>
                        </div>
                    </div>
                    <div v-else style="height: 30rem;width: 100%" class="position-relative">
                        <div style="width: 20rem;height: 10rem;position: absolute;top: 50%;left: 50%;transform: translate(-50%,-50%);font-size: 5rem;color: #f3f3f3">暂无消息</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    const person = new Vue({
        el:"#person",
        data(){
            return{
                personChangeMg:{
                    userName:'',
                    userEmail:'',
                    gender:''
                },
                imageUrl: '',
                personMg:'',
                labelPosition: 'right',
                message:'',
                myBorrow:'',
                myMessages:''
            }
        },
        mounted:function(){
          this.getPersonMg();
          this.getMyBorrow();
          this.getMyMessage();
        },
        methods:{
            getPersonMg(){
                let vm = this;
                $.get("api/getPerson.php",{
                    userID: <?php echo $userID?>
                },function (result) {
                    vm.personMg=result[0];
                    vm.personChangeMg.userName=result[0].userName;
                    vm.personChangeMg.userEmail=result[0].userEmail;
                    vm.personChangeMg.gender=result[0].gender;
                    vm.imageUrl=result[0].userAvatar
                })
            },
            getMyBorrow(){
                let vm = this;
                $.post("api/getMyBorrow.php",{
                    userID:<?php echo $userID?>
                },function (result) {
                    vm.myBorrow=result;
                })
            },
            getMyMessage(){
              let vm=this;
              $.post("api/getMyMessage.php",{
                  userID:<?php echo $userID?>
              },function (result) {
                vm.myMessages=result;
              })
            },
            putChangeMg(){
                var fileObj = $("#uavFile")[0].files[0];
                var formData = new FormData($("#changeForm")[0]);
                formData.append("userID",<?php echo $userID?>);
                formData.append("orginImg",this.imageUrl);
                if (fileObj){
                    formData.append("fileImg",fileObj);
                }
                let vm=this;
                $.ajax({
                    url: "api/putChangeMg.php" ,
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result!=="修改成功"){
                            vm.message=result;
                            vm.errorMgs();
                        }else {
                            vm.message=result;
                            vm.successMg();
                            vm.getPersonMg();
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
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
            messageVisited(){
                $.post("api/messageVisited.php",{
                    userID:<?php echo $userID?>
                },function (result) {
                });
            }
        }
    });
</script>
<script>
        function showImg() {
            var fileInput =document.getElementById("uavFile"),
                previewImg = document.getElementById("uavImg");
            fileInput.addEventListener('change', function () {
                var file = this.files[0];
                var reader = new FileReader();
                // 监听reader对象的的onload事件，当图片加载完成时，把base64编码賦值给预览图片
                reader.addEventListener("load", function () {
                    previewImg.src = reader.result;
                }, false);
                // 调用reader.readAsDataURL()方法，把图片转成base64
                reader.readAsDataURL(file);
            }, false);
        }
</script>
</body>
</html>
