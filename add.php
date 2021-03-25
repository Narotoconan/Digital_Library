<?php
function add(){
    if (empty($_POST['bookName'])){
        echo '没有bookName';
        return;
    }
    if (empty($_POST['bookAuthor'])){
        echo '没有bookAuthor';
        return;
    }
    if (empty($_POST['category'])){
        echo '没有category';
        return;
    }
    if (empty($_POST['publishedDate'])){
        echo '没有publishedDate';
        return;
    }
    if (empty($_POST['bookIntroduction'])){
        echo '没有简介';
        return;
    }
//$bookCover
    if (empty($_FILES['bookCover'])) {
        echo '请正确提交';
        return;
    }
    $bookCover=$_FILES['bookCover'];
    //校验是否选择的文件
    if ($bookCover['error'] !== UPLOAD_ERR_OK) {
       echo '请添加图片文件';
        return;
    }
    //判断文件大小
    if ($bookCover['size'] > 2 * 1024 * 1024) {
       echo '文件过大，请重新选择文件';
        return;
    }

    $arr =explode('.',$bookCover['name']);
    $targetuserImg = "./resources/book/bookCover/" . $arr[0] . "." . $arr[3];
    if (!move_uploaded_file($bookCover['tmp_name'], $targetuserImg)) {
        echo '上传封面失败';
        return;
    }
    $upDate=date("Y-m-d");
    $bookPDF="./resources/book/bookDownload/example.pdf";
    $bookName = $_POST['bookName'];
    $bookAuthor = $_POST['bookAuthor'];
    $category = $_POST['category'];
    $publishedDate=$_POST['publishedDate'];
    $bookIntroduction=$_POST['bookIntroduction'];

    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
    }
   $query = mysqli_query($connection,
        "INSERT INTO booklist (bookName,bookAuthor,bookIntroduction,bookCategory,bookCover,bookUpload,bookDownload,bookPress,bookPublishedDate,bookVisits,bookBorrow) 
        values ('{$bookName}','{$bookAuthor}','{$bookIntroduction}','{$category}','{$targetuserImg}','{$upDate}','{$bookPDF}','{$arr[2]}','{$publishedDate}',0,0)");
    var_dump($query);
    if ($query){
        echo "上传成功";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    add();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-5 w-50">
    <form action="<?php echo $_SERVER['PHP_SELF']?>" method="post" enctype="multipart/form-data" onsubmit="return false">
        <div class="form-group">
            <label for="bookName">书名</label>
            <input type="text" class="form-control" id="bookName" name="bookName">
        </div>
        <div class="form-group">
            <label for="bookAuthor">作者</label>
            <input type="text" class="form-control" id="bookAuthor" name="bookAuthor">
        </div>
        <div class="form-group">
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="inlineRadio1" value="1">
                <label class="form-check-label" for="inlineRadio1">网页开发</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="inlineRadio2" value="2">
                    <label class="form-check-label" for="inlineRadio2">语言编程</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="inlineRadio3" value="3">
                <label class="form-check-label" for="inlineRadio3">操作系统</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="category" id="inlineRadio4" value="4">
                <label class="form-check-label" for="inlineRadio4">数据库</label>
            </div>
        </div>
        <div class="form-group">
            <div class="custom-file">
                <input type="file" class="custom-file-input" id="bookCover" name="bookCover" accept="image/png,image/jpeg">
                <label class="custom-file-label" for="bookCover" id="bookCover-0">上传书封面</label>
            </div>
        </div>
        <div class="form-group">
            <label for="publishedDate" class="col-sm-2 control-label">出版时间</label>
            <input type="date" class="form-control time" id="publishedDate" name="publishedDate">
        </div>
        <div class="form-group">
            <label for="bookPress">出版社</label>
            <input type="text" class="form-control" id="bookPress" name="bookPress">
        </div>
        <div class="form-group">
            <label for="bookIntroduction">简介</label>
            <textarea class="form-control" id="bookIntroduction" rows="3" name="bookIntroduction"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<img src="" height="200" alt="Image preview area..." title="preview-img">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script>
    $("#bookCover").bind("change",function () {
        $("#bookCover-0").text($(this)[0].files[0].name);
        var name = $(this)[0].files[0].name;
        $("#cover").attr("src",$(this).val());
        var arr=name.split(".");
        console.log(arr);
        $("#bookName").val(arr[0]);
        $("#bookAuthor").val(arr[1]);
        $("#bookPress").val(arr[2]);
    });
</script>
<script>
    var fileInput = document.querySelector('input[type=file]'),
        previewImg = document.querySelector('img');
    fileInput.addEventListener('change', function () {
        var file = this.files[0];
        var reader = new FileReader();
        // 监听reader对象的的onload事件，当图片加载完成时，把base64编码賦值给预览图片
        reader.addEventListener("load", function () {
            previewImg.src = reader.result;
        }, false);
        // 调用reader.readAsDataURL()方法，把图片转成base64
        reader.readAsDataURL(file);
    }, false);
</script>
</body>
</html>
