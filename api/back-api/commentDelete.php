<?php
function commentDelete(){
    if (empty($_POST['adminID'])){
        exit("<h1>非法操作</h1>");
    }
    $commentID=$_POST['commentID'];
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $query=mysqli_query($connection,"DELETE FROM commentlist WHERE commentlist.commentID = '{$commentID}'");
    if (!$query){
        echo "删除失败";
        return;
    }
    echo "删除成功";
    mysqli_close($connection);
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    commentDelete();
}
