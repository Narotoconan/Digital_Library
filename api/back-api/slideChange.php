<?php
function putSlide(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    if (empty($_FILES['slideImg'])){
        echo "没有文件";
        return;
    }
    $index=$_POST['sIndex'];
    $slideImg=$_FILES['slideImg'];

    switch ($index)
    {
        case 1:
            $bannerID = 1001001 ;
            break;
        case 2:
            $bannerID = 1001002 ;
            break;
        default:
            $bannerID = 1001003;
    }
    $slideUrl="../../resources/".$slideImg['name'];

    if (!move_uploaded_file($slideImg['tmp_name'], $slideUrl)) {
        echo '上传失败';
        return;
    }
    $slideUrl=substr($slideUrl,4);

    $connection = mysqli_connect('127.0.0.1', 'root', '147199512', 'digital_library');
    if (!$connection) {
        echo "数据库链接错误";
        return;
    }

    $query=mysqli_query($connection,"UPDATE bannenrlist SET bannenrlist.bannerImg = '{$slideUrl}' WHERE bannenrlist.bannerID = '{$bannerID}'");
    if (!$query){
        echo "上传失败";
        return;
    }
    mysqli_close($connection);
    echo "修改成功";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    putSlide();
}
