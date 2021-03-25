<?php
function signUp(){
    if (empty($_POST['userName'])){
        echo '请输入用户名';
        return;
    }
    if (empty($_POST['password'])){
        echo '请输入密码';
        return;
    }
    if ($_POST['password']!==$_POST['repassword']){
        echo '两次密码不一致';
        return;
    }
    if (empty($_POST['email'])){
        echo '请输入邮箱';
        return;
    }
    /*用户名正则-4到16位字符（除特殊符）*/
    $judgeUserName="/^[a-zA-Z0-9\x{4e00}-\x{9fa5}]{4,16}$/u";
    if (!preg_match($judgeUserName,$_POST['userName'])){
        echo '用户名，4到16位字符（除特殊符）';
        return;
    }
   /* 密码正则-密码至少包含 数字和英文，长度6-20*/
    $judgePassword="/^(?![0-9]+$)(?![a-zA-Z]+$)[0-9A-Za-z]{6,20}$/";
    if (!preg_match($judgePassword,$_POST['password'])){
        echo '密码至少包含 数字和英文，长度6-20';
        return;
    }
    /*邮箱正则*/
    $judgeEmail="/^[0-9a-zA-Z_.-]+[@][0-9a-zA-Z_.-]+([.][a-zA-Z]+){1,2}$/";
    if (!preg_match($judgeEmail,$_POST['email'])){
        echo '请输入正确的邮箱';
        return;
    }
    $userName=$_POST['userName'];
    $userPassword=$_POST['password'];
    $userSex=$_POST['gender'];
    $email=$_POST['email'];
    $userAvatar="./resources/static/default.png";
    //链接数据库
    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }
    //查询用户名是否重复
    $query=mysqli_query($connection,"SELECT userlist.* FROM userlist WHERE userlist.userName = '{$userName}' ");
    $name=mysqli_fetch_assoc($query);
    if ($name['userName']){
        echo "该用户名已被注册";
        return;
    }
    //查询邮箱是否重复
    $query=mysqli_query($connection,"SELECT userlist.* FROM userlist WHERE userlist.userEmail = '{$email}' ");
    $mail=mysqli_fetch_assoc($query);
    if ($mail['userEmail']){
        echo "此邮箱已被注册";
        return;
    }

    date_default_timezone_set("Asia/Shanghai");
    $signUpTime=date("Y-m-d H:i:s");
    $query=mysqli_query($connection,"INSERT INTO userlist (userName,userPassword,gender,registerDate,userEmail,userAvatar)
                         values('{$userName}','{$userPassword}','{$userSex}','{$signUpTime}','{$email}','{$userAvatar}')");
    if(!$query){
        echo "注册失败,提交数据失败";
        return;
    }
    echo "注册成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    signUp();
}
