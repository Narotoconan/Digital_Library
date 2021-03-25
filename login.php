<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/login.css">
</head>
<body id="bg">
<div class="container">
    <div id="login" class="m-5">
        <div class="login_logo mb-5">
            <img src="resources/logo.png" alt="logo" style="height: 60px">
        </div>
        <el-tabs v-model="activeName" @tab-click="handleClick">
            <el-tab-pane label="用户登录" name="user">
                    <el-form v-model="form">
                        <el-form-item label="用户名称" >
                            <el-input v-model="form.userName" placeholder="请输入用户名"></el-input>
                        </el-form-item>
                        <el-form-item label="用户密码">
                            <el-input v-model="form.password" placeholder="请输入密码" show-password></el-input>
                        </el-form-item>
                        <el-form-item>
                            <el-checkbox v-model="form.checked">三天免登陆</el-checkbox>
                            <a href="signUp.php" style="margin-left: 7.5rem">注册账户</a>
                        </el-form-item>
                        <el-form-item>
                            <el-button type="primary" @click="onSubmit">登录</el-button>
                        </el-form-item>
                    </el-form>
            </el-tab-pane>
            <el-tab-pane label="管理员登录" name="administrator">
                <el-form>
                    <el-form-item label="管理员名称" v-model="adminForm">
                        <el-input v-model="adminForm.administrator" placeholder="请输入用户名"></el-input>
                    </el-form-item>
                    <el-form-item label="管理员密码">
                        <el-input v-model="adminForm.password" placeholder="请输入密码" show-password></el-input>
                    </el-form-item>
                    <el-form-item>
                        <el-button type="primary" @click="onSubmitAdmin">登录</el-button>
                    </el-form-item>
                </el-form>
            </el-tab-pane>
        </el-tabs>
    </div>
</div>



<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>

<script>
    const login=new Vue({
        el:'#login',
        data(){
            return{
                form:{
                    userName:'',
                    password:'',
                    checked:false
                },
                errorMg:"",
                activeName: 'user',
                adminForm:{
                    administrator:'',
                    password:''
                }
            }
        },
        methods:{
            onSubmit(){
                let vm=this;
                $.post("api/load.php",{
                    userName:vm.form.userName,
                    password:vm.form.password,
                    checked:vm.form.checked
                },function (res) {
                    if (res!=='登录成功'){
                        vm.errorMg=res;
                        vm.open4();
                    }else {
                        $(window).attr('location','index.php')
                    }
                })
            },
            onSubmitAdmin(){
                let vm=this;
                $.post("api/adminLoad.php",{
                    adminName:vm.adminForm.administrator,
                    password:vm.adminForm.password
                },function (res) {
                    if (res!=='登录成功'){
                        vm.errorMg=res;
                        vm.open4();
                    }else {
                        $(window).attr('location','backstage/back-index.php')
                    }
                })
            },
            open4() {
                this.$notify.error({
                    title: '错误',
                    message: this.errorMg
                });
            },
            handleClick(tab, event) {
            }
        }
    });
    $("#bg").css({"height":$(window).height()});
</script>
</body>
</html>
