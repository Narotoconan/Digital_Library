<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/signUp.css">
</head>
<body id="bg">

<div class="container">
    <div id="signUp" class="m-5">
        <div class="signUp_logo mb-5">
            <img src="resources/logo.png" alt="logo" style="height: 60px">
        </div>
        <el-form :label-position="labelPosition" v-model="signForm" label-width="100px">
            <el-form-item label="用户名称">
                <el-input v-model="signForm.userName" placeholder="4 到16位字符（除特殊符）"></el-input>
            </el-form-item>
            <el-form-item label="设置密码">
                <el-input v-model="signForm.userPassword" placeholder="密码至少包含 数字和英文，长度6-20" show-password></el-input>
            </el-form-item>
            <el-form-item label="确认密码">
                <el-input v-model="signForm.repassword" placeholder="请确认密码" show-password></el-input>
            </el-form-item>
            <el-form-item prop="email" label="邮箱">
                <el-input v-model="signForm.email" placeholder="请确认邮箱"></el-input>
            </el-form-item>
            <el-form-item label="性别">
                <el-radio v-model="signForm.radio" label="1">男</el-radio>
                <el-radio v-model="signForm.radio" label="2">女</el-radio>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="signUp">注 册</el-button>
            </el-form-item>
        </el-form>
    </div>
</div>


<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>
<script>
    const signUp=new Vue({
        el:"#signUp",
        data(){
            return{
                labelPosition:"right",
                signForm:{
                    userName:'',
                    userPassword:'',
                    repassword:'',
                    email:'',
                    radio:'1'
                },
                message:''
            }
        },
        methods:{
            signUp(){
                let vm=this;
                $.post("api/signUp.php",{
                    userName:vm.signForm.userName,
                    password:vm.signForm.userPassword,
                    repassword:vm.signForm.repassword,
                    email: vm.signForm.email,
                    gender:vm.signForm.radio
                },function (res) {
                    if (res!=='注册成功'){
                        vm.errorMg=res;
                        vm.open4();
                    }else {
                        vm.open2();
                        setTimeout(function(){
                            $(window).attr('location','login.php');
                        },2000)
                    }
                })
            },
            open4() {
                this.$message.error(this.errorMg);
            },
            open2() {
                this.$message({
                    message: '注册成功',
                    type: 'success'
                });
            }
        }
    });
    $("#bg").css({"height":$(window).height()});
</script>

</body>
</html>
