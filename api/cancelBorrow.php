<?php
function cancelBorrow(){
    $userID=$_POST['userID'];
    $bookID=$_POST['bookID'];
    $cancelDate=date("Y-m-d H:i:s");

    $connection=mysqli_connect("127.0.0.1",'root','147199512','digital_library');
    if (!$connection){
        echo "数据库链接失败";
        return;
    }
    $query=mysqli_query($connection,"UPDATE borrowlist SET borrowlist.borrowStatus = 2 ,borrowEnd = '{$cancelDate}'WHERE 
	borrowlist.userID = '{$userID}' AND
	borrowlist.bookID = '{$bookID}' AND
	borrowlist.borrowStatus = 1");

    if (!$query){
        echo "取消失败";
        return;
    }
    echo "取消成功";
    return;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    cancelBorrow();
}
