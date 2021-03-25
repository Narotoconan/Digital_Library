<?php
require_once ("../components/increase.php");
function borrowBook(){
    $userID=$_POST['userID'];
    $bookID=$_POST['bookID'];
    $borrowStart=date("Y-m-d H:i:s");

    $connection=mysqli_connect("127.0.0.1",'root','147199512','digital_library');
    if (!$connection){
        echo "数据库链接失败";
        return;
    }
    $query=mysqli_query($connection,"INSERT INTO borrowlist (userID,bookID,borrowBegin,borrowStatus)
                         values('{$userID}','{$bookID}','{$borrowStart}',1)");
    if (!$query){
        echo "借阅失败";
        return;
    }
    $Borrow=increase("UPDATE booklist SET booklist.bookBorrow= booklist.bookBorrow+1 WHERE booklist.bookID = '{$bookID}'");
    echo "借阅成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    borrowBook();
}
