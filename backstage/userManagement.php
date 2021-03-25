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
    <title>book</title>
    <link rel="stylesheet" href="../node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="../lib/css/initialization.css">
    <link rel="stylesheet" href="../lib/css/back-css/back-index.css">
</head>
<body>
<script src="../node_modules/jquery/dist/jquery.min.js"></script>
<script src="../node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="../node_modules/vue/dist/vue.min.js"></script>
<script src="../node_modules/element-ui/lib/index.js"></script>

<div id="userManagement">
    <div>
        <el-button type="danger" class="el-icon-delete mb-3" @click="userBatchDelete"> 批量删除</el-button>
        <el-pagination
            class="float-right"
            background
            layout="prev, pager, next"
            @current-change="currentChange"
            :current-page="userPage.currentPage"
            :page-size="15"
            :total="userPage.total">
        </el-pagination>
    </div>
    <el-table
        :data="userListData.userTableData"
        max-height="730"
        border
        :default-sort = "{prop: 'userID'}"
        ref="multipleTable"
        @selection-change="userSelectionChange"
        style="width: 100%">
        <el-table-column
            type="selection"
            align="center"
            @click.=""
            width="55">
        </el-table-column>
        <el-table-column
            prop="userID"
            label="用户ID"
            align="center"
            sortable
            width="180">
        </el-table-column>
        <el-table-column
            prop="userName"
            label="用户名"
            align="center"
            width="180">
        </el-table-column>
        <el-table-column
            prop="gender"
            width="80"
            align="center"
            :formatter="userGender"
            :filters="[{ text: '男', value: '1' }, { text: '女', value: '2' }]"
            :filter-method="filterGender"
            label="性别">
        </el-table-column>
        <el-table-column
            prop="userEmail"
            align="center"
            label="用户邮箱">
        </el-table-column>
        <el-table-column
            prop="registerDate"
            align="center"
            sortable
            label="注册日期">
        </el-table-column>
        <el-table-column
            fixed="right"
            align="center"
            label="操作"
            width="120">
            <template slot-scope="scope">
                <el-button
                    size="mini"
                    type="danger"
                    @click="userDelete(scope.row)">
                    删除用户
                </el-button>
            </template>
        </el-table-column>
    </el-table>
</div>
<script>
    const userManagement=new Vue({
        el:"#userManagement",
        data(){
            return{
                userListData:{
                    userTableData:[],
                    userDeleteList:[]
                },
                userPage:{
                    total:0,
                    size: 15,
                    currentPage:1
                },
                multipleSelection:[]
            }
        },
        mounted:function(){
            this.getUserManagement()
        },
        methods:{
            getUserManagement(){
                this.homePage=0;
                this.userManagement=1;
                this.bookManagement=0;
                let vm=this;
                $.post("../api/back-api/getUserManagement.php",{
                    adminID:<?php echo $adminID?>,
                    currentPage:vm.userPage.currentPage
                },function (result) {
                    vm.userListData.userTableData=result;
                })
            },
            userGender(row){
                if (row.gender==="1"){
                    return "男"
                }else {
                    return "女"
                }
            },
            filterGender(value, row, column){
                const property = column['property'];
                return row[property] === value;
            },
            userDelete(row){
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    modal:false,
                    type: 'warning'
                }).then(() => {
                    let vm=this;
                    $.post("../api/back-api/userDelete.php",{
                        adminID:<?php echo $adminID?>,
                        userDeleteID:row.userID
                    },function (result) {
                        if (result==="删除成功"){
                            vm.$message({
                                message: '删除成功',
                                type: 'success'
                            });
                            vm.getUserManagement();
                        }else {
                            vm.$message.error(result);
                        }
                    });
                }).catch(() => {
                });
            },
            userSelectionChange(val){
                this.multipleSelection = val;
            },
            userBatchDelete(){
                if (this.multipleSelection.length){
                    this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        modal:false,
                        type: 'warning'
                    }).then(() => {
                        const length = this.multipleSelection.length;
                        for (let i = 0; i < length; i++) {
                            this.userListData.userDeleteList.push(this.multipleSelection[i].userID)
                        }
                        this.userListData.userDeleteList = Array.from(new Set(this.userListData.userDeleteList));
                        let vm=this;
                        $.post("../api/back-api/userBatchDelete.php",{
                            adminID:<?php echo $adminID?>,
                            userDeleteList:vm.userListData.userDeleteList
                        },function (result) {
                            if (result==="删除成功"){
                                vm.$message({
                                    message: '删除成功',
                                    type: 'success'
                                });
                                vm.getUserManagement();
                            }else {
                                vm.$message.error(result);
                            }
                        });
                        vm.userListData.userDeleteList=[]
                    }).catch(() => {
                    });
                }else {
                    this.$message({
                        type: 'warning',
                        message: '请选择用户'
                    });
                }
            },
            currentChange(current){
                this.userPage.currentPage=current;
                this.getUserManagement();
            },
        }
    })
</script>
</body>
</html>
