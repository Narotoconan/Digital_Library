<?php
session_start();
require_once ("components/inquire.php");
require_once ("components/unescape.php");
if (empty($_GET['search'])||$_GET['search']==''){
    exit("<h1>请输入有效参数</h1>");
}

$search = $_GET['search'];
$search = unescape($search);
$searchBooks=inquire("SELECT
	booklist.bookID, 
	booklist.bookName, 
	booklist.bookAuthor, 
	booklist.bookCover, 
	booklist.bookPress, 
	bookcategory.bookCategory
FROM
	booklist
	INNER JOIN
	bookcategory
	ON 
		booklist.bookCategory = bookcategory.categoryNum
HAVING
	booklist.bookName LIKE '%{$search}%'
ORDER BY
	booklist.bookName DESC");
$count=count($searchBooks);
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>searchPage</title>
    <link rel="stylesheet" href="node_modules/bootstrap/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="node_modules/element-ui/lib/theme-chalk/index.css">
    <link rel="stylesheet" href="lib/css/initialization.css">
    <link rel="stylesheet" href="lib/css/index.css">
    <link rel="stylesheet" href="lib/css/recommend.css">
</head>
<body style="background-color: #f2f2f2">
<script src="node_modules/jquery/dist/jquery.min.js"></script>
<script src="node_modules/bootstrap/dist/js/bootstrap.min.js"></script>
<script src="node_modules/vue/dist/vue.min.js"></script>
<script src="node_modules/element-ui/lib/index.js"></script>

<!--头部位置-->
<div id="header" style="height: 80px;background-color: #fafafa;box-shadow: 0 2px 15px 0 rgba(0, 0, 0, 0.1)">
    <?php include 'components/header.php'?>
</div>
<div class="container">
    <div class="row">
        <div class="col mt-4 mb-5">
            <h5>
                搜索结果
                <div>
                    <small class="text-muted">共搜索到条<?php echo $count?>结果</small>
                </div>
            </h5>
            <div class="books mt-3 d-flex flex-wrap">
                <?php foreach ($searchBooks as $item):?>
                <a href="bookPage.php?bookID=<?php echo $item['bookID']?>">
                    <div class="p-2">
                        <div class="card bookItems" style="width: 13.406rem;">
                            <img src="<?php echo $item['bookCover']?>" class="card-img-top" alt="<?php echo $item['bookName']?>">
                            <div class="card-body">
                                <h5 class="card-title overflow-hidden bookName"><?php echo $item['bookName']?></h5>
                                <div class="category mb-1" style="font-size: 12px">
                                    <?php echo $item['bookCategory']?>
                                </div>
                                <p class="card-text small mb-1"><?php echo $item['bookAuthor']?></p>
                                <p class="card-text small text-black-50"><?php echo $item['bookPress']?></p>
                            </div>
                        </div>
                    </div>
                </a>
                <?php endforeach;?>
            </div>
        </div>
    </div>
</div>
</body>
</html>
