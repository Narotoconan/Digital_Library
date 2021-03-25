<?php
function putComment(){
    if ($_POST['putComment']==''){
        echo "请输入提交内容";
        return;
    }
    $putComment=$_POST['putComment'];
    $userID=$_POST['userID'];
    $bookID=$_POST['bookID'];
    date_default_timezone_set("Asia/Shanghai");
    $putCommentTime=date("Y-m-d H:i:s");

    $connection=mysqli_connect("127.0.0.1",'root','147199512','digital_library');
    if (!$connection){
        echo "数据库链接失败";
        return;
    }
    $query=mysqli_query($connection,"INSERT INTO commentlist (userID,bookID,comments,commentDate)
                         values('{$userID}','{$bookID}','{$putComment}','{$putCommentTime}')");
    if (!$query){
        echo "提交数据失败";
        return;
    }
    echo "提交成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    putComment();
}
