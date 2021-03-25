<?php
require_once ("../../components/inquire.php");
function userDelete(){
    if (empty($_POST['adminID'])) {
        exit("<h1>请输入有效参数</h1>");
    }
    $userDeleteID=$_POST['userDeleteID'];
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $userAv=inquire("SELECT userlist.userAvatar FROM userlist WHERE userlist.userID = '{$userDeleteID}'");
    $defaultAv="./resources/static/default.png";
    if ($userAv[0]['userAvatar']!==$defaultAv){
        $avatar="../../".substr($userAv[0]['userAvatar'],2);
        unlink($avatar);
    }
    $query=mysqli_query($connection,"DELETE FROM userlist WHERE userlist.userID = '{$userDeleteID}' ");
    if (!$query){
        echo "删除失败";
        return;
    }
    mysqli_close($connection);
    echo "删除成功";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    userDelete();
}
