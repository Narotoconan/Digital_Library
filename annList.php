<?php
session_start();
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="icon" href="favicon.ico">
    <title>数字图书馆</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
    <style>
        .el-timeline-item__tail{
            display: block !important;
        }
        .el-timeline li:last-child .el-timeline-item__tail{
            display: none !important;
        }
    </style>
</head>
<body>
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>

<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php'?>
</div>

<div id="annList" class="mt-5">
    <div class="container">
        <div class="block">
            <el-timeline>
                    <el-timeline-item v-for="item in list" :timestamp="item.date" placement="top">
                        <a :href="'announcement.php?annID='+item.announcementID">
                            <el-card>
                                <h4>{{ item.title }}</h4>
                                <div class="mt-3">
                                    <small style="color: #bebebe">发布于 {{ item.date }}</small>
                                </div>
                            </el-card>
                        </a>
                    </el-timeline-item>
            </el-timeline>
        </div>
    </div>
</div>

<script>
    const annList= new Vue({
        el:"#annList",
        data(){
            return{
                list:[]
            }
        },
        mounted:function(){
          this.getList();
        },
        methods:{
            getList(){
                let vm=this;
                $.post("api/getList.php",
                    function (result) {
                        vm.list=result;
                })
            }
        }
    })
</script>
</body>
</html>
