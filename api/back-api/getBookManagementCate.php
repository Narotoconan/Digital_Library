<?php
require_once ("../../components/inquire.php");
function getBookManagement(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $bookCateValue=$_POST['bookCateValue'];
    $bookList=inquire("SELECT
	booklist.*
FROM
	booklist
WHERE 
    booklist.bookCategory = {$bookCateValue}");

    header('Content-Type:application/json');
    echo json_encode($bookList) ;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getBookManagement();
}
