<?php
session_start();
if (empty($_SESSION['adminID'])){
    exit("<h1>请输入有效参数</h1>");
}
$adminID=$_SESSION['adminID'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
</head>
<body>

<div id="bookAdd" class="w-50">
    <div class="m-5"></div>
    <el-form :label-position="labelPosition" label-width="80px" :model="bookUpMessage" id="bookUpMg">
        <el-form-item label="上传封面">
            <div class="position-relative" id="bavUp" style="height: 10rem;width: 10rem;background-color:#fafafa;border: 1px solid">
                <img :src="bookUpMessage.bookCover" alt="" id="bavImgUp" style="width: 100%;height: 100%;border-radius: 10px;border: 1px solid #eaeaea;">
                <input type="file" id="bavFileUp" onclick="showImg()" class="position-absolute" style="width: 8rem;height: 8rem;top: 0;left: 0;opacity: 0" accept="image/jpeg">
            </div>
            <small class="text-muted">上传头像图片只能是 JPG 格式!</small><br/>
            <small class="text-muted">上传头像图片大小不能超过 2MB!</small>
        </el-form-item>
        <el-form-item label="图书资源">
            <input type="file" class="custom-file-input" id="bookResourceUp" accept="application/pdf">
            <label class="custom-file-label" for="bookResourceUp">{{bookUpMessage.bookDownload}}</label>
        </el-form-item>
        <el-form-item label="书名">
            <el-input v-model="bookUpMessage.bookName" name="bookNameUp"></el-input>
        </el-form-item>
        <el-form-item label="作者">
            <el-input v-model="bookUpMessage.bookAuthor" name="bookAuthorUp"></el-input>
        </el-form-item>
        <el-form-item label="类别">
            <el-select v-model="bookUpMessage.bookCategory" placeholder="请选择" name="bookCategoryUp">
                <el-option
                    v-for="item in bookCateUp"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value">
                </el-option>
            </el-select>
        </el-form-item>
        <el-form-item label="出版社">
            <el-input v-model="bookUpMessage.bookPress" name="bookPressUp"></el-input>
        </el-form-item>
        <el-form-item label="出版时间">
            <el-date-picker
                v-model="bookUpMessage.bookPublishedDate"
                type="date"
                name="bookPublishedDateUp"
                placeholder="选择日期">
            </el-date-picker>
        </el-form-item>
        <el-form-item  label="图书简介">
            <el-input
                type="textarea"
                autosize
                name="bookIntroductionUp"
                placeholder="请输入内容"
                v-model="bookUpMessage.bookIntroduction">
            </el-input>
        </el-form-item>
        <el-form-item>
            <el-button type="primary" @click="putBookUp">上传图书</el-button>
        </el-form-item>
    </el-form>
</div>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>
<script>
    const bookAdd=new Vue({
        el:"#bookAdd",
        data(){
            return {
                labelPosition: 'right',
                bookUpMessage:{
                    bookName:'',
                    bookAuthor:'',
                    bookCategory:'',
                    bookIntroduction:"",
                    bookCover:'',
                    bookDownload:'',
                    bookPress:'',
                    bookPublishedDate:''
                },
                bookCateUp: [{
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
            putBookUp(){
                var bookCover = $("#bavFileUp")[0].files[0];
                var bookResource = $("#bookResourceUp")[0].files[0];
                var formData = new FormData($("#bookUpMg")[0]);
                formData.append("adminID",<?php echo $adminID?>);
                formData.append("bookCover",bookCover);
                formData.append("bookResource",bookResource);
                let vm=this;
                $.ajax({
                    url: "../api/back-api/addBook.php",
                    type: 'POST',
                    data: formData,
                    async: false,
                    cache: false,
                    contentType: false,
                    processData: false,
                    success: function (result) {
                        if (result!=="上传成功"){
                            vm.$message.error(result);
                        }else {
                            vm.$message({
                                message: '上传成功',
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
    $("#bookResourceUp").bind("change",function () {
        bookAdd.bookUpMessage.bookDownload=$(this)[0].files[0].name;
    });
    function showImg() {
        var fileInput = document.getElementById("bavFileUp"),
            previewImg = document.getElementById("bavImgUp");
        fileInput.addEventListener("change", function () {
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
