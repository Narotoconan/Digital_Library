<?php
session_start();
    if (empty($_GET['annID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $annID=$_GET['annID'];
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>announcement</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
</head>
<body style="background-color: #f2f2f2">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>
<script src="node_modules/qs/dist/qs.js"></script>

<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php' ?>
</div>

<div id="ann">
    <div class="container">
        <div style="text-align: center" class="mt-5">
            <h2>{{ announcement.title }}</h2><br>
            <span class="mt-3">{{ announcement.date }}</span>
        </div>
        <hr style="color: #cfcfcf"/>
        <p style="text-indent: 2em; font-size: 18px;line-height: 32px">{{ announcement.content }}</p>
    </div>
</div>

<script>

    const ann = new Vue({
        el:"#ann",
        data(){
            return{
                announcement:[]
            }
        },
        mounted:function () {
            this.getAnn();
        },
        methods:{
            getAnn(){
                let vm= this;
                $.post("api/getAnn.php",{
                    annID:<?php echo $annID?>,
                },function (result) {
                    vm.announcement=result[0];
                })
            }
        }
    })
</script>
</body>
</html>
