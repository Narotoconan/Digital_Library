<?php
function putAnn(){
    if (empty($_POST['adminID'])) {
        exit("<h1>请输入有效参数</h1>");
    }
    if (empty($_POST['title'])){
        echo "请输入标题";
        return;
    }
    if (empty($_POST['content'])){
        echo "请输入内容";
        return;
    }
    $title=$_POST['title'];
    $content=$_POST['content'];
    date_default_timezone_set("Asia/Shanghai");
    $addTime=date("Y-m-d H:i:s");

    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }
    $query=mysqli_query($connection,"INSERT INTO announcement (announcement.title,announcement.content,announcement.date) VALUES (
    '{$title}',
    '{$content}',
    '{$addTime}')");
    if (!$query){
        echo "添加失败";
        return;
    }
    mysqli_close($connection);
    echo "添加成功";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    putAnn();
}
