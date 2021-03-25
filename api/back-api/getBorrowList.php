<?php
require_once ("../../components/inquire.php");
function getBorrowList(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $borrowList=inquire("SELECT
	borrowlist.*, 
	userlist.userName, 
	booklist.bookName
FROM
	borrowlist
	INNER JOIN
	userlist
	ON 
		borrowlist.userID = userlist.userID
	INNER JOIN
	booklist
	ON 
		borrowlist.bookID = booklist.bookID
ORDER BY
	borrowlist.borrowID DESC");

    header('Content-Type:application/json');
    echo json_encode($borrowList);

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getBorrowList();
}
