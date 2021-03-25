<?php
require_once ("../../components/inquire.php");
function bookDelete() {
    if (empty($_POST['adminID'])) {
        exit("<h1>请输入有效参数</h1>");
    }
    $bookDeleteID=$_POST['bookDeleteID'];
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        echo "数据库了连接失败";
        return;
    }
    $bookCover=inquire("SELECT booklist.bookCover FROM booklist WHERE booklist.bookID = '{$bookDeleteID}'");
    $bookResource=inquire("SELECT booklist.bookDownload FROM booklist WHERE booklist.bookID = '{$bookDeleteID}'");

    //删除书的封面和资源
    $cover="../../".substr($bookCover[0]['bookCover'],2);
    unlink($cover);
    if ($bookResource[0]['bookDownload']!='./resources/book/bookDownload/example.pdf'){
        $resource="../../".substr($bookResource[0]['bookDownload'],2);
        unlink($resource);
    }

    $query=mysqli_query($connection,"DELETE FROM booklist WHERE booklist.bookID = '{$bookDeleteID}' ");
    if (!$query){
        echo "删除失败";
        return;
    }
    mysqli_close($connection);
    echo "删除成功";
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    bookDelete();
}
