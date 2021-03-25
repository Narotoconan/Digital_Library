<?php
function putBookChange(){
    if (empty($_POST['bookName'])){
        echo "书名不能为空";
        return;
    }
    if (empty($_POST['bookAuthor'])){
        echo "作者不能为空";
        return;
    }
    if (empty($_POST['bookCategory'])){
        echo "请先择类别";
        return;
    }
    if (empty($_POST['bookPress'])){
        echo "请输入出版社";
        return;
    }
    if (empty($_POST['bookPublishedDate'])){
        echo "请先择出版时间";
        return;
    }
    if (empty($_POST['bookIntroduction'])){
        echo "简介不能为空";
        return;
    }
    $bookID=$_POST['bookID'];
    $bookName=$_POST['bookName'];
    $bookAuthor=$_POST['bookAuthor'];
    $bookCategory=$_POST['bookCategory'];
    $bookPress=$_POST['bookPress'];
    $bookPublishedDate=$_POST['bookPublishedDate'];
    $bookIntroduction=$_POST['bookIntroduction'];
    $originBookCover=$_POST['originBookCover'];
    $originBookDownload=$_POST['originBookResource'];

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
    //判断是否改了封面
    if (isset($_FILES['bookCover'])){
        $bookCover=$_FILES['bookCover'];
        $bookCoverUrl="../../resources/book/bookCover/".$bookCover['name'];
        if (!move_uploaded_file($bookCover['tmp_name'], $bookCoverUrl)) {
            echo '上传封面失败';
            return;
        }
        $bookCoverUrl=substr($bookCoverUrl,5);
    }else{
        $bookCoverUrl=$originBookCover;
    }

    //判断是否改了文件资源
    if (isset($_FILES['bookResource'])){
        $bookResource=$_FILES['bookResource'];
        $bookResourceUrl="../../resources/book/bookDownload/".$bookResource['name'];
        if (!move_uploaded_file($bookResource['tmp_name'], $bookResourceUrl)) {
            echo '上传文件失败';
            return;
        }
        $bookResourceUrl=substr($bookResourceUrl,5);
    }else{
        $bookResourceUrl=$originBookDownload;
    }
    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }
    $query = mysqli_query($connection, "UPDATE booklist SET booklist.bookName = '{$bookName}',booklist.bookAuthor = '{$bookAuthor}',booklist.bookCategory = '{$bookCategory}',
                booklist.bookPress = '{$bookPress}',booklist.bookPublishedDate = '{$bookPublishedDate}',booklist.bookIntroduction = '{$bookIntroduction}',
                booklist.bookDownload = '{$bookResourceUrl}',booklist.bookCover = '{$bookCoverUrl}'
                WHERE booklist.bookID = '{$bookID}'");
    if (!$query){
        echo "修改失败";
        return;
    }
    mysqli_close($connection);
    echo "修改成功";
    return;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    putBookChange();
}
