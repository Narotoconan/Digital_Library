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
<div id="commentManagement">
    <div>
        <el-pagination
            class="float-right mb-3"
            background
            layout="prev, pager, next"
            @current-change="commentCurrentChange"
            :current-page="commentPage.currentPage"
            :page-size="10"
            :total="commentPage.total">
        </el-pagination>
    </div>
    <el-table
        :data="comments.slice((commentPage.currentPage-1)*10,commentPage.currentPage*10)"
        max-height="750"
        ref="multipleTable"
        border
        style="width: 100%">
        <el-table-column
            prop="commentID"
            align="center"
            label="评论ID"
            sortable
            width="120">
        </el-table-column>
        <el-table-column
            prop="userName"
            align="center"
            label="评论用户"
            width="120">
        </el-table-column>
        <el-table-column
            prop="bookName"
            align="center"
            label="评论书籍">
        </el-table-column>
        <el-table-column
            prop="comments"
            align="center"
            show-overflow-tooltip
            effect="light"
            label="评论内容">
        </el-table-column>
        <el-table-column
            prop="commentDate"
            align="center"
            sortable
            label="评论时间">
        </el-table-column>
        <el-table-column
            prop="reply"
            align="center"
            width="100"
            label="回复状态">
            <template slot-scope="scope">
                <el-tag v-if="scope.row.reply !== null" type="success">已回复</el-tag>
                <el-tag v-if="scope.row.reply === null" type="warning">待回复</el-tag>
            </template>
        </el-table-column>
        <el-table-column
            fixed="right"
            align="center"
            label="操作"
            align="center"
            width="180">
            <template slot-scope="scope">
                <el-button
                    size="mini"
                    type="primary"
                    @click="dialogReplyVisible = true;toReply(scope.row)">
                    回复
                </el-button>
                <el-button
                    size="mini"
                    type="danger"
                    @click="commentDelete(scope.row)">
                    删除评论
                </el-button>
            </template>
    </el-table>
    <el-dialog title="评论回复" :visible.sync="dialogReplyVisible" :modal="bg">
        <div class="mb-3" style="font-size: 16px">{{ userName }} 的评论：</div>
        <p style="font-size: 16px" class="mb-3">{{ userComment }}</p>
        <hr/>
        <el-input
            type="textarea"
            :rows="2"
            placeholder="回复内容"
            v-model="adminReply">
        </el-input>
        <div class="mt-3" style="text-align: right">
            <el-button type="primary" @click="adminToReply">回复</el-button>
        </div>
    </el-dialog>
</div>


<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>

<script>
    const comment=new Vue({
        el:"#commentManagement",
        data(){
            return{
                comments:[],
                commentPage:{
                    total:0,
                    currentPage:1
                },
                dialogReplyVisible:false,
                bg:false,
                userName:'',
                userComment:'',
                adminReply:'',
                commentID:''
            }
        },
        mounted:function(){
            this.gatComment();
        },
        methods:{
            gatComment(){
                let vm=this;
                $.post("../api/back-api/getComment.php",{
                    adminID:<?php echo $adminID?>,
                },function (result) {
                    vm.comments=result;
                    vm.commentPage.total=result.length;
                })
            },
            commentCurrentChange(current){
                this.commentPage.currentPage=current;
            },
            commentDelete(row){
                let vm=this;
                $.post("../api/back-api/commentDelete.php",{
                    adminID:<?php echo $adminID?>,
                    commentID:row.commentID,
                },function (result) {
                    if (result==="删除成功"){
                        vm.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        vm.gatComment();
                    }else {
                        vm.$message.error(result);
                    }
                })
            },
            toReply(row){
                this.userName=row.userName;
                this.userComment=row.comments;
                this.adminReply=row.reply;
                this.commentID=row.commentID;
            },
            adminToReply(){
                let vm=this;
                $.post("../api/back-api/adminToReply.php",{
                    adminID:<?php echo $adminID?>,
                    commentID:vm.commentID,
                    adminReply:vm.adminReply
                },function (result) {
                    if (result==="回复成功"){
                        vm.$message({
                            message: '回复成功',
                            type: 'success'
                        });
                        vm.gatComment();
                        vm.dialogReplyVisible=false;
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

