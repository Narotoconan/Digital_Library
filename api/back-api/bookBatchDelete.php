<?php
require_once ("../../components/inquire.php");
function bookBatchDelete()
{
    if (empty($_POST['adminID'])) {
        exit("<h1>请输入有效参数</h1>");
    }
    $bookDeleteList = $_POST['bookDeleteList'];
    $bookDeleteList = join($bookDeleteList,",");
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $bookCover=inquire("SELECT booklist.bookCover FROM booklist WHERE booklist.bookID in ({$bookDeleteList})");
    for ($i=0;$i< count($bookCover);$i++){
        $cover="../../".substr($bookCover[$i]['bookCover'],2);
        unlink($cover);
    }
    $bookResource=inquire("SELECT booklist.bookDownload FROM booklist WHERE booklist.bookID in ({$bookDeleteList})");
    for ($i=0;$i< count($bookResource);$i++){
        $download="../../".substr($bookResource[$i]['bookDownload'],2);
        unlink($download);
    }
    $query=mysqli_query($connection,"DELETE FROM booklist WHERE booklist.bookID in ({$bookDeleteList}) ");
    if (!$query){
        echo "删除失败";
        return;
    }
    mysqli_close($connection);
    echo "删除成功";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    bookBatchDelete();
}
