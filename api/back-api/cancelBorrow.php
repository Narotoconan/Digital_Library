<?php
function cancelBorrow(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $borrowID=$_POST['borrowID'];
    $borrowStatus=$_POST['borrowStatus'];
    date_default_timezone_set("Asia/Shanghai");
    $cancelTime=date("Y-m-d H:i:s");
    if ($borrowStatus==2){
        echo "图书已归还";
        return;
    }
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $query=mysqli_query($connection,"UPDATE borrowlist SET borrowlist.borrowStatus = 2, borrowlist.borrowEnd = '{$cancelTime}' WHERE borrowlist.borrowID = '{$borrowID}'");
    if (!$query){
        echo "取消失败";
        return;
    }
    mysqli_close($connection);
    echo "取消成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cancelBorrow();
}
