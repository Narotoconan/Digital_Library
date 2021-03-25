<?php
function judge(){
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        exit("<h1>数据库连接失败</h1>");
    }
    if (empty($_POST['adminName'])){
        echo '请输入管理员名';
        return;
    }
    if (empty($_POST['password'])){
        echo  '请输入管理员密码';
        return;
    }
    $adminName=$_POST['adminName'];
    $password=$_POST['password'];
    $query=mysqli_query($connection,"SELECT administrator.adminID, administrator.password FROM administrator WHERE administrator.adminName = '{$adminName}'");
    if (!($psw=mysqli_fetch_assoc($query))){
        echo '管理员名错误！';
        return;
    }
    if ($psw['password']!=$password){
        echo '密码不正确！';
        return;
    }
    $adminId=$psw['adminID'];
    echo '登录成功';
    mysqli_free_result($query);
    mysqli_close($connection);
    $liveTime=1*24*3600;
    session_set_cookie_params($liveTime);
    session_start();
    $_SESSION['adminID']=$adminId;
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
    judge();
}
