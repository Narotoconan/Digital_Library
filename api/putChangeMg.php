<?php
function putChangeMg(){
    if (empty($_POST['userName'])){
        echo "用户名不能为空";
        return;
    }
    if (empty($_POST['userEamil'])){
        echo "邮箱不能为空";
        return;
    }
    if (empty($_POST['gender'])){
        echo "请先择性别";
    }
    $userID=$_POST['userID'];
    $userName=$_POST['userName'];
    $userEamil=$_POST['userEamil'];
    $gender=$_POST['gender'];
    $orginImg=$_POST['orginImg'];

    if (isset($_FILES['fileImg'])){
        $Avatar=$_FILES['fileImg'];
        $userAvatar = "../lib/userAv/" . $Avatar['name'];
        if (!move_uploaded_file($Avatar['tmp_name'], $userAvatar)) {
            echo '上传头像失败';
            return;
        }
        $userAvatar=substr($userAvatar,1);
    }else{
        $userAvatar= $orginImg;
    }
    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
    }
    //查询用户名是否重复
    $query=mysqli_query($connection,"SELECT userlist.* FROM userlist WHERE userlist.userName = '{$userName}' ");
    $name=mysqli_fetch_assoc($query);
    if ($name['userName']){
        if ($name['userID']!=$userID){
            echo "该用户名已被注册";
            return;
        }
    }
    //查询邮箱是否重复
    $query=mysqli_query($connection,"SELECT userlist.* FROM userlist WHERE userlist.userName = '{$userEamil}' ");
    $mail=mysqli_fetch_assoc($query);
    if ($mail['userEmail']){
        if ($mail['userID']!=$userID){
            echo "此邮箱已被注册";
            return;
        }
    }
    $query = mysqli_query($connection,
        "UPDATE userlist SET userlist.userName = '{$userName}',userlist.userEmail = '{$userEamil}',userlist.userAvatar = '{$userAvatar}',userlist.gender = '{$gender}'
                WHERE userlist.userID = '{$userID}'");
    if (!$query){
        echo "修改失败";
        return;
    }
    echo "修改成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    putChangeMg();
}
