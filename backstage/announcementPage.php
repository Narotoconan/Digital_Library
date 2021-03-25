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
    <title>announcementPage</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
    <link rel="stylesheet" href="../lib/css/back-css/back-index.css">
</head>
<body>

<div id="announcementPage" style="box-shadow: 0 0 15px 0 rgba(0,0,0,.1)">
    <div>
        <el-button type="primary" class="el-icon-bell mb-3" @click="addAnn=true"> 添加公告</el-button>
        <el-pagination
            class="float-right mb-3"
            background
            layout="prev, pager, next"
            @current-change="announcementCurrentChange"
            :current-page="announcementPage.currentPage"
            :page-size="10"
            :total="announcementPage.total">
        </el-pagination>
        <el-table
            :data="announcements.slice((announcementPage.currentPage-1)*10,announcementPage.currentPage*10)"
            max-height="750"
            ref="multipleTable"
            border
            style="width: 100%">
            <el-table-column
                prop="announcementID"
                align="center"
                label="公告ID"
                sortable
                width="120">
            </el-table-column>
            <el-table-column
                prop="title"
                align="center"
                label="公告标题">
            </el-table-column>
            <el-table-column
                prop="content"
                align="center"
                show-overflow-tooltip
                label="内容">
            </el-table-column>
            <el-table-column
                prop="date"
                align="center"
                sortable
                label="发布时间">
            </el-table-column>
            <el-table-column
                fixed="right"
                align="center"
                label="操作"
                width="180">
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="watch(scope.row);dialogAnnVisible = true">
                        查看
                    </el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="announcementDelete(scope.row)">
                        删除公告
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
        <el-dialog :title="announcementTitle" :visible.sync="dialogAnnVisible" :modal="bg">
            <p>{{ date }}</p>
            <hr/>
            <p>{{ announcementContent }}</p>
        </el-dialog>
        <el-dialog title="添加公告" :visible.sync="addAnn" :modal="addbg">
            <el-form :label-position="labelPosition" label-width="80px" :model="putA">
                <el-form-item label="公告标题">
                    <el-input v-model="putA.putTitle"></el-input>
                </el-form-item>
                <el-form-item label="公告内容">
                    <el-input
                        type="textarea"
                        :rows="2"
                        placeholder="请输入内容"
                        v-model="putA.putContent">
                    </el-input>
                </el-form-item>
            </el-form>
            <div class="clearfix">
                <el-button type="primary" class="float-right" @click="putAnn">提交</el-button>
            </div>
        </el-dialog>
    </div>
</div>


<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>

<script>
    const announcement= new Vue({
        el:"#announcementPage",
        data(){
            return{
                announcements:[],
                announcementPage:{
                    total:0,
                    currentPage:1
                },
                dialogAnnVisible:false,
                bg:false,
                announcementTitle:'',
                announcementContent:'',
                date:'',
                labelPosition: 'right',
                addAnn:false,
                addbg:false,
                putA:{
                    putTitle:'',
                    putContent:''
                }
            }
        },
        mounted:function () {
            this.getAnnouncement();
        },
        methods:{
            getAnnouncement(){
                let vm= this;
                $.post("../api/back-api/getAnnouncement.php",{
                    adminID:<?php echo $adminID?>,
                },function (result) {
                    vm.announcements=result;
                    vm.announcementPage.total=result.length;
                })
            },
            announcementCurrentChange(current){
                this.announcementPage.currentPage=current;
            },
            watch(row){
                this.announcementTitle=row.title;
                this.announcementContent=row.content;
                this.date=row.date;
            },
            announcementDelete(row){
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    modal:false,
                    type: 'warning'
                }).then(() => {
                    let vm= this;
                    $.post("../api/back-api/announcementDelete.php",{
                        adminID:<?php echo $adminID?>,
                        announcementID:row.announcementID
                    },function (result) {
                        if (result==="删除成功"){
                            vm.$message({
                                message: '删除成功',
                                type: 'success'
                            });
                            vm.getAnnouncement();
                        }else {
                            vm.$message.error(result);
                        }
                    });
                }).catch(() => {
                });
            },
            putAnn(){
                let vm=this;
                $.post("../api/back-api/putAnn.php",{
                    adminID:<?php echo $adminID?>,
                    title:vm.putA.putTitle,
                    content:vm.putA.putContent
                },function (result) {
                    if (result==="添加成功"){
                        vm.$message({
                            message: '添加成功',
                            type: 'success'
                        });
                        vm.getAnnouncement();
                        vm.putA.putTitle='';
                        vm.putA.putContent='';
                        vm.addAnn=false;
                    }else {
                        vm.$message.error(result);
                    }
                })
            }
        }
    })
</script>

</body>
</html>
