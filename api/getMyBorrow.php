<?php
require_once ("../components/inquire.php");
function getMyBorrow(){
    if (empty($_POST['userID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $userID=$_POST['userID'];
    $myBorrow=inquire("SELECT
	booklist.bookName, 
	booklist.bookAuthor, 
	booklist.bookCover, 
	booklist.bookPress, 
	bookcategory.bookCategory, 
	booklist.bookID, 
	borrowlist.borrowBegin
FROM
	booklist
	INNER JOIN
	bookcategory
	ON 
		booklist.bookCategory = bookcategory.categoryNum
	INNER JOIN
	borrowlist
	ON 
		booklist.bookID = borrowlist.bookID
WHERE
	borrowlist.userID = '{$userID}' AND
	borrowlist.borrowStatus = 1
ORDER BY
	borrowlist.borrowBegin DESC");

    header('Content-Type:application/json');
    echo json_encode($myBorrow) ;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getMyBorrow();
}
