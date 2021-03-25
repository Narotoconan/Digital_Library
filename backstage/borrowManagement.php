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
    <title>borrow</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
</head>
<div id="borrowManagement">
    <div>
        <el-pagination
            class="float-right mb-3"
            background
            layout="prev, pager, next"
            @current-change="borrowCurrentChange"
            :current-page="borrowPage.currentPage"
            :page-size="10"
            :total="borrowPage.total">
        </el-pagination>
        <el-table
            :data="borrows.slice((borrowPage.currentPage-1)*10,borrowPage.currentPage*10)"
            max-height="750"
            ref="multipleTable"
            border
            style="width: 100%">
            <el-table-column
                prop="borrowID"
                align="center"
                label="借阅ID"
                sortable
                width="120">
            </el-table-column>
            <el-table-column
                prop="userName"
                align="center"
                label="借阅用户"
                width="120">
            </el-table-column>
            <el-table-column
                prop="bookName"
                align="center"
                label="借阅书籍">
            </el-table-column>
            <el-table-column
                prop="borrowBegin"
                align="center"
                sortable
                label="借阅起始时间">
            </el-table-column>
            <el-table-column
                prop="borrowStatus"
                align="center"
                width="100"
                label="借阅状态">
                <template slot-scope="scope">
                    <el-tag v-if="scope.row.borrowStatus == 1" type="success">借阅中</el-tag>
                    <el-tag v-if="scope.row.borrowStatus == 2" type="info">已归还</el-tag>
                </template>
            </el-table-column>
            <el-table-column
                fixed="right"
                align="center"
                label="操作"
                align="center"
                width="200">
                <template slot-scope="scope">
                    <el-button
                        size="mini"
                        type="primary"
                        @click="cancelBorrow(scope.row)">
                        取消借阅
                    </el-button>
                    <el-button
                        size="mini"
                        type="danger"
                        @click="borrowDelete(scope.row)">
                        删除
                    </el-button>
                </template>
        </el-table>
    </div>
</div>




<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>

<script>
    const borrowManagement = new Vue({
        el:"#borrowManagement",
        data(){
            return{
                borrowPage:{
                    total:0,
                    currentPage:1
                },
                borrows:[],

            }
        },
        mounted:function(){
            this.getBorrowList();
        },
        methods:{
            getBorrowList(){
                let vm=this;
                $.post("../api/back-api/getBorrowList.php",{
                    adminID:<?php echo $adminID?>,
                },function (result) {
                    vm.borrows=result;
                    vm.borrowPage.total=result.length;
                })
            },
            borrowCurrentChange(current){
                this.borrowPage.currentPage=current;
            },
            cancelBorrow(row){
                let vm=this;
                $.post("../api/back-api/cancelBorrow.php",{
                    adminID:<?php echo $adminID?>,
                    borrowID:row.borrowID,
                    borrowStatus:row.borrowStatus
                },function (result) {
                    if (result==="取消成功"){
                        vm.$message({
                            message: '取消成功',
                            type: 'success'
                        });
                        vm.getBorrowList();
                    }else {
                        vm.$message.error(result);
                    }
                })
            },
            borrowDelete(row){
                let vm=this;
                $.post("../api/back-api/borrowDelete.php",{
                    adminID:<?php echo $adminID?>,
                    borrowID:row.borrowID
                },function (result) {
                    if (result==="删除成功"){
                        vm.$message({
                            message: '删除成功',
                            type: 'success'
                        });
                        vm.getBorrowList();
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
