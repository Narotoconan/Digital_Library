<?php
function addBook(){
    if (empty($_POST['adminID'])){
        exit("<h1>非法操作</h1>");
    }
    if (empty($_POST['bookNameUp'])){
        echo "书名不能为空";
        return;
    }
    if (empty($_POST['bookAuthorUp'])){
        echo "作者不能为空";
        return;
    }
    if (empty($_POST['bookCategoryUp'])){
        echo "请先择类别";
        return;
    }
    if (empty($_POST['bookPressUp'])){
        echo "请输入出版社";
        return;
    }
    if (empty($_POST['bookPublishedDateUp'])){
        echo "请先择出版时间";
        return;
    }
    if (empty($_POST['bookIntroductionUp'])){
        echo "简介不能为空";
        return;
    }
    $bookName=$_POST['bookNameUp'];
    $bookAuthor=$_POST['bookAuthorUp'];
    $bookCategory=$_POST['bookCategoryUp'];
    $bookPress=$_POST['bookPressUp'];
    $bookPublishedDate=$_POST['bookPublishedDateUp'];
    $bookIntroduction=$_POST['bookIntroductionUp'];

    if ($bookCategory==="网页开发"){
        $bookCategory=1;
    }
    if ($bookCategory==="语言编程"){
        $bookCategory=2;
    }
    if ($bookCategory==="操作系统"){
        $bookCategory=3;
    }
    if ($bookCategory==="数据库"){
        $bookCategory=4;
    }

    if (empty($_FILES['bookCover'])){
        echo "请先择封面";
        return;
    }
    if (empty($_FILES['bookResource'])){
        echo "请先择文件";
        return;
    }
    $bookCover=$_FILES['bookCover'];
    $bookResource=$_FILES['bookResource'];

    $bookCoverUrl="../../resources/book/bookCover/".$bookCover['name'];
    $bookResourceUrl="../../resources/book/bookDownload/".$bookResource['name'];

    if (!move_uploaded_file($bookCover['tmp_name'], $bookCoverUrl)) {
        echo '上传封面失败';
        return;
    }

    if (!move_uploaded_file($bookResource['tmp_name'], $bookResourceUrl)) {
        echo '上传文件失败';
        return;
    }

    $bookCoverUrl=substr($bookCoverUrl,4);
    $bookResourceUrl=substr($bookResourceUrl,4);
    date_default_timezone_set("Asia/Shanghai");
    $addTime=date("Y-m-d H:i:s");

    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }
    $query=mysqli_query($connection,"INSERT INTO booklist (
        booklist.bookName, 
        booklist.bookAuthor, 
        booklist.bookIntroduction, 
        booklist.bookScore, 
        booklist.bookCategory, 
        booklist.bookCover, 
        booklist.bookUpload, 
        booklist.bookDownload, 
        booklist.bookPress, 
        booklist.bookPublishedDate, 
        booklist.bookVisits, 
        booklist.bookBorrow)
    VALUES (
        '{$bookName}',
        '{$bookAuthor}',
        '{$bookIntroduction}',
        3.5,
        '{$bookCategory}',
        '{$bookCoverUrl}',
        '{$addTime}',
        '{$bookResourceUrl}',
        '{$bookPress}',
        '{$bookPublishedDate}',0,0)");
    if (!$query){
        echo "上传失败";
        return;
    }
    mysqli_close($connection);
    echo "上传成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    addBook();
}
