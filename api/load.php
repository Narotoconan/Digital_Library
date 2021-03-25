<?php
function judge(){
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
       echo "据库连接失败";
       return;
    }
    if (empty($_POST['userName'])){
        echo '请输入用户名';
        return;
    }
    if (empty($_POST['password'])){
        echo  '请输入密码';
        return;
    }
    $userName=$_POST['userName'];
    $password=$_POST['password'];

    $query=mysqli_query($connection,"SELECT userlist.userPassword,userlist.userID FROM userlist WHERE userlist.userName = '{$userName}'");
   if (!($psw=mysqli_fetch_assoc($query))){
        echo '用户不存在！';
        return;
    }
   if ($psw['userPassword']!=$password){
        echo '密码不正确！';
        return;
    }
    $userId=$psw['userID'];
    mysqli_free_result($query);
    mysqli_close($connection);
    if ($_POST['checked']=='true'){
        $liveTime=3*24*3600;
        session_set_cookie_params($liveTime);
    }
    session_start();
    $_SESSION['userId']=$userId;
    echo '登录成功';
}
if ($_SERVER['REQUEST_METHOD']==='POST'){
    judge();
}
