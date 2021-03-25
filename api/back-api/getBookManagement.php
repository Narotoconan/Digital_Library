<?php
require_once ("../../components/inquire.php");
function getBookManagement(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $bookList=inquire("SELECT
	booklist.*
FROM
	booklist
ORDER BY 
    booklist.bookID DESC ");

    header('Content-Type:application/json');
    echo json_encode($bookList) ;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getBookManagement();
}
