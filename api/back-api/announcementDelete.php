<?php
function announcementDelete(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $announcementID=$_POST['announcementID'];

    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }
    $query=mysqli_query($connection,"DELETE FROM announcement WHERE announcement.announcementID = '{$announcementID}'");
    if (!$query){
        echo "删除失败";
        return;
    }
    mysqli_close($connection);
    echo "删除成功";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    announcementDelete();
}
