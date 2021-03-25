<?php
session_start();
if (empty($_SESSION['adminID'])){
    exit("<h1>请输入有效参数</h1>");
}
$adminID=$_SESSION['adminID'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>slide</title>
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

<div id="slidePage" class="pl-5">
    <div class="mb-3" v-for="(item,index) in slide">
        <h5 class="mb-3">轮播图 {{ index+1 }} </h5>
        <img :src="'../'+item.bannerImg" alt="" style="width: 500px;height: 182px;">
        <el-button type="primary" icon="el-icon-edit" class="ml-5"  @click="dialogFormVisible = true;slideChange(index)"> 修改</el-button>
    </div>
    <el-dialog :title="'轮播图'+slideIndex" :visible.sync="dialogFormVisible" :modal="slideBg">
        <el-form id="slideChange">
            <el-form-item>
                <input type="hidden" name="sIndex" v-model="slideIndex">
            </el-form-item>
            <el-form-item>
                <input type="file" class="custom-file-input" id="slideImg" accept="image/png,image/jpeg">
                <label class="custom-file-label" for="slideImg">{{slideName}}</label>
            </el-form-item>
            <div class="mt-3 clearfix">
                <el-button type="primary" class="float-right" @click="putSlide">提交</el-button>
            </div>
        </el-form>
    </el-dialog>
</div>

<script>
    const slidePages = new Vue({
        el:"#slidePage",
        data(){
            return{
                slide:[],
                dialogFormVisible:false,
                slideBg:false,
                slideIndex:'',
                slideName:''
            }
        },
        mounted:function(){
          this.getSlide();
        },
        methods:{
            getSlide(){
                let vm=this;
                $.post("../api/back-api/getSlide.php",{
                    adminID:<?php echo $adminID?>,
                },function (result) {
                    vm.slide=result;
                })
            },
            slideChange(index){
                this.slideIndex=index+1;

            },
            putSlide(){
                let vm = this;
                var slideImg = $("#slideImg")[0].files[0];
                var formData = new FormData($("#slideChange")[0]);
                formData.append("adminID",<?php echo $adminID?>);
                formData.append("slideImg",slideImg);
                $.ajax({
                    url: "../api/back-api/slideChange.php",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result!=="修改成功"){
                            vm.$message.error(result);
                        }else {
                            vm.$message({
                                message: '修改成功',
                                type: 'success'
                            });
                            vm.getSlide();
                            vm.dialogFormVisible=false;
                        }
                    },
                    error: function (error) {
                        console.log(error);
                    }
                });
            }
        }
    });
</script>
<script>
    $(document).on("change",'#slideImg',function () {
        slidePages.slideName=$(this)[0].files[0].name;
    });
</script>
</body>
</html>
