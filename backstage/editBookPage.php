<?php
require_once ("../components/inquire.php");
function bookEditPage(){
    if (empty($_GET['bookID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $bookID=$_GET['bookID'];
    $bookMg=inquire("SELECT
	booklist.*
FROM
	booklist
WHERE 
    booklist.bookID = {$bookID}");
    $bookMg=$bookMg[0];
    return $bookMg;
}
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $bookMg = bookEditPage();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>editBook</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
    <style>
        #bav{
            width: 10rem;
            height: 10rem;
        }
        #bav img{
            width: 100%;
            height: 100%;
            border-radius: 10px;
            border: 1px solid #eaeaea;
        }
    </style>
</head>
<body>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>
    <div id="bookEdit" class="w-50">
        <el-page-header   @back="goBack" content="图书编辑">
        </el-page-header>
        <div class="m-5"></div>
        <el-form :label-position="labelPosition" label-width="80px" :model="bookMessage" id="bookChangMessage">
            <el-form-item label="修改封面">
                <div class="position-relative" id="bav">
                    <img :src="'../'+bookMessage.bookCover" alt="" id="bavImg">
                    <input type="file" id="bavFile" class="position-absolute" style="width: 8rem;height: 8rem;top: 0;left: 0;opacity: 0" accept="image/jpeg">
                </div>
                <small class="text-muted">上传头像图片只能是 JPG 格式!</small><br/>
                <small class="text-muted">上传头像图片大小不能超过 2MB!</small>
            </el-form-item>
            <el-form-item label="图书资源">
                <input type="file" class="custom-file-input" id="bookResource" accept="application/pdf">
                <label class="custom-file-label" for="bookResource">{{bookMessage.bookDownload}}</label>
            </el-form-item>
            <el-form-item label="图书ID">
                <el-input v-model="bookMessage.bookID" disabled></el-input>
            </el-form-item>
            <el-form-item label="书名">
                <el-input v-model="bookMessage.bookName" name="bookName"></el-input>
            </el-form-item>
            <el-form-item label="作者">
                <el-input v-model="bookMessage.bookAuthor" name="bookAuthor"></el-input>
            </el-form-item>
            <el-form-item label="类别">
                <el-select v-model="bookMessage.bookCategory" placeholder="请选择" name="bookCategory">
                    <el-option
                        v-for="item in bookCate"
                        :key="item.value"
                        :label="item.label"
                        :value="item.value">
                    </el-option>
                </el-select>
            </el-form-item>
            <el-form-item label="出版社">
                <el-input v-model="bookMessage.bookPress" name="bookPress"></el-input>
            </el-form-item>
            <el-form-item label="出版时间">
                <el-date-picker
                    v-model="bookMessage.bookPublishedDate"
                    type="date"
                    name="bookPublishedDate"
                    placeholder="选择日期">
                </el-date-picker>
            </el-form-item>
            <el-form-item  label="图书简介">
                <el-input
                    type="textarea"
                    autosize
                    name="bookIntroduction"
                    placeholder="请输入内容"
                    v-model="bookMessage.bookIntroduction">
                </el-input>
            </el-form-item>
            <el-form-item>
                <el-button type="primary" @click="putBookChange">确认修改</el-button>
            </el-form-item>
        </el-form>
    </div>
    <script>
        const bookEdit=new Vue({
            el:"#bookEdit",
            data(){
                return {
                    labelPosition: 'right',
                    bookMessage:{
                        bookID:'<?php echo $bookMg['bookID']?>',
                        bookName:'<?php echo $bookMg['bookName']?>',
                        bookAuthor:'<?php echo $bookMg['bookAuthor']?>',
                        bookCategory:'<?php echo $bookMg['bookCategory']?>',
                        bookIntroduction:"<?php echo $bookMg['bookIntroduction']?>",
                        bookCover:'<?php echo substr($bookMg['bookCover'],2) ?>',
                        bookDownload:'<?php echo strrev(explode("/",strrev($bookMg['bookDownload']))[0])?>',
                        bookPress:'<?php echo $bookMg['bookPress']?>',
                        bookPublishedDate:'<?php echo $bookMg['bookPublishedDate']?>'
                    },
                    bookCate: [{
                        value: '1',
                        label: '网页开发'
                    }, {
                        value: '2',
                        label: '语言编程'
                    }, {
                        value: '3',
                        label: '操作系统'
                    }, {
                        value: '4',
                        label: '数据库'
                    }]
                }
            },
            methods:{
                goBack() {
                    window.history.go(-1)
                },
                putBookChange(){
                    var bookCover = $("#bavFile")[0].files[0];
                    var bookResource = $("#bookResource")[0].files[0];
                    var formData = new FormData($("#bookChangMessage")[0]);
                    formData.append("bookID",<?php echo $bookMg['bookID']?>);
                    formData.append("originBookCover","<?php echo $bookMg['bookCover']?>");
                    formData.append("originBookResource","<?php echo $bookMg['bookDownload']?>");
                    if (bookCover){
                        formData.append("bookCover",bookCover);
                    }
                    if (bookResource){
                        formData.append("bookResource",bookResource);
                    }
                    let vm=this;
                    $.ajax({
                        url: "../api/back-api/putBookChange.php",
                        type: 'POST',
                        data: formData,
                        async: false,
                        cache: false,
                        contentType: false,
                        processData: false,
                        success: function (result) {
                            if (result!=="修改成功"){
                                vm.$message.error(result);
                            }else {
                                vm.$message({
                                    message: '修改成功',
                                    type: 'success'
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error);
                        }
                    });
                }
            }
        })
    </script>
<script>
    function showImg() {
        var fileInput =document.getElementById("bavFile"),
            previewImg = document.getElementById("bavImg");
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
    }
</script>
</body>
</html>
