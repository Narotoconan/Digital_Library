<?php
function adminToReply(){
    if (empty($_POST['adminID'])){
        exit("<h1>非法操作</h1>");
    }
    if (empty($_POST['adminReply'])){
        echo "回复不能为空";
        return;
    }
    $adminReply=$_POST['adminReply'];
    date_default_timezone_set("Asia/Shanghai");
    $replyTime=date("Y-m-d H:i:s");
    $commentID=$_POST['commentID'];
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $query=mysqli_query($connection,"UPDATE commentlist SET 
        commentlist.reply = '{$adminReply}',
        commentlist.replyDate = '{$replyTime}',
        commentlist.replyView = 1
        WHERE commentlist.commentID = '{$commentID}'");
    if (!$query){
        echo "回复失败";
        return;
    }
    echo "回复成功";
    mysqli_close($connection);
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    adminToReply();
}
