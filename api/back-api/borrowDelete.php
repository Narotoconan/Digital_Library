<?php
function borrowDelete(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $borrowID=$_POST['borrowID'];

    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $query=mysqli_query($connection,"DELETE FROM borrowlist WHERE borrowlist.borrowID = '{$borrowID}'");
    if (!$query){
        echo "删除失败";
        return;
    }
    mysqli_close($connection);
    echo "删除成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    borrowDelete();
}
