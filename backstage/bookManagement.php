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

<div id="bookManagement">
    <div>
        <el-button type="danger" class="el-icon-delete mb-3" @click="bookBatchDelete"> 批量删除</el-button>
        <span class="ml-5"></span>
        <el-pagination
            class="float-right"
            background
            layout="prev, pager, next"
            @current-change="bookCurrentChange"
            :current-page="bookPage.currentPage"
            :page-size="10"
            :total="bookPage.total">
        </el-pagination>
    </div>
    <el-table
        :data="bookListData.bookTableData.slice((bookPage.currentPage-1)*10,bookPage.currentPage*10)"
        max-height="750"
        border
        :default-sort = "{prop: 'bookID',order: 'descending'}"
        ref="multipleTable"
        @selection-change="bookSelectionChange"
        @filter-change="filterChange"
        style="width: 100%">
        <el-table-column
            type="selection"
            align="center"
            fixed
            @click.=""
            width="55">
        </el-table-column>
        <el-table-column
            prop="bookID"
            label="书籍ID"
            fixed
            align="center"
            sortable
            width="120">
        </el-table-column>
        <el-table-column
            prop="bookName"
            label="书名"
            align="center"
            width="180">
        </el-table-column>
        <el-table-column
            prop="bookAuthor"
            label="作者"
            align="center"
            width="80">
        </el-table-column>
        <el-table-column
            prop="bookCategory"
            width="80"
            align="center"
            :formatter="booksCategory"
            :filters="[{ text: '网页开发', value: '1' }, { text: '语言编程', value: '2' }, { text: '操作系统', value: '3' }, { text: '数据库', value: '4' }]"
            label="类别">
        </el-table-column>
        <el-table-column
            prop="bookPublishedDate"
            align="center"
            sortable
            width="120"
            label="出版日期">
        </el-table-column>
        <el-table-column
            prop="bookPress"
            align="center"
            width="180"
            label="出版社">
        </el-table-column>
        <el-table-column
            prop="bookVisits"
            align="center"
            sortable
            label="浏览量">
        </el-table-column>
        <el-table-column
            prop="bookBorrow"
            align="center"
            sortable
            label="借阅量">
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
                @click="editBook(scope.row.bookID)">
                编辑
                </el-button>
                <el-button
                        size="mini"
                        type="danger"
                        @click="bookDelete(scope.row)">
                    删除图书
                </el-button>
            </template>
        </el-table-column>
    </el-table>
</div>
<script>
    const bookManagement=new Vue({
        el: "#bookManagement",
        data(){
            return{
                bookListData:{
                    bookTableData:[],
                    bookDeleteList:[]
                },
                bookPage:{
                    total:0,
                    currentPage:1
                },
            }
        },
        mounted:function(){
            this.getBookManagement();
        },
        methods: {
            getBookManagement(){
                let vm=this;
                $.post("../api/back-api/getBookManagement.php",{
                    adminID:<?php echo $adminID?>,
                },function (result) {
                    vm.bookListData.bookTableData=result;
                    vm.bookPage.total=result.length;
                    console.log("aa")
                })
            },
            booksCategory(row){
                if (row.bookCategory=="1"){
                    return "网页开发"
                }else if(row.bookCategory=="2"){
                    return "语言编程"
                }else if(row.bookCategory=="3"){
                    return "操作系统"
                }else {
                    return "数据库"
                }
            },
            filterChange(filterObj){
                let bookCate = filterObj["el-table_1_column_5"][0];
                if (bookCate){
                    let vm = this;
                    $.post("../api/back-api/getBookManagementCate.php",{
                        adminID:<?php echo $adminID?>,
                        bookCateValue:bookCate
                    },function (result) {
                        vm.bookListData.bookTableData=result;
                        vm.bookPage.total=result.length;
                    })
                }else{
                    this.getBookManagement();
                }
            },
            bookDelete(row){
                this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                    confirmButtonText: '确定',
                    cancelButtonText: '取消',
                    modal:false,
                    type: 'warning'
                }).then(() => {
                    let vm=this;
                    $.post("../api/back-api/bookDelete.php",{
                        adminID:<?php echo $adminID?>,
                        bookDeleteID:row.bookID
                    },function (result) {
                        if (result==="删除成功"){
                            vm.$message({
                                message: '删除成功',
                                type: 'success'
                            });
                            vm.getBookManagement();
                        }else {
                            vm.$message.error(result);
                        }
                    });
                }).catch(() => {
                });
            },
            bookSelectionChange(val){
                this.multipleSelection = val;
            },
            bookBatchDelete(){
                if (this.multipleSelection.length){
                    this.$confirm('此操作将永久删除, 是否继续?', '提示', {
                        confirmButtonText: '确定',
                        cancelButtonText: '取消',
                        modal:false,
                        type: 'warning'
                    }).then(() => {
                        const length = this.multipleSelection.length;
                        for (let i = 0; i < length; i++) {
                            this.bookListData.bookDeleteList.push(this.multipleSelection[i].bookID)
                        }
                        this.bookListData.bookDeleteList = Array.from(new Set(this.bookListData.bookDeleteList));
                        let vm=this;
                        $.post("../api/back-api/bookBatchDelete.php",{
                            adminID:<?php echo $adminID?>,
                            bookDeleteList:vm.bookListData.bookDeleteList
                        },function (result) {
                            if (result==="删除成功"){
                                vm.$message({
                                    message: '删除成功',
                                    type: 'success'
                                });
                                vm.getBookManagement();
                            }else {
                                vm.$message.error(result);
                            }
                        });
                        vm.bookListData.bookDeleteList=[]
                    }).catch(() => {
                    });
                }else {
                    this.$message({
                        type: 'warning',
                        message: '请选择书籍'
                    });
                }
            },
            editBook(bookID){
                $(window).attr('location','editBookPage.php?bookID='+bookID);
            },
            bookCurrentChange(current){
                this.bookPage.currentPage=current;
            },
        }
    })
</script>
</body>
</html>
