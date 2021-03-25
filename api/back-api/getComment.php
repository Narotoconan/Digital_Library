<?php
require_once ("../../components/inquire.php");
function getComment(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $commentList=inquire("SELECT
	commentlist.*, 
	booklist.bookName, 
	userlist.userName
FROM
	commentlist
	INNER JOIN
	userlist
	ON 
		commentlist.userID = userlist.userID
	INNER JOIN
	booklist
	ON 
		commentlist.bookID = booklist.bookID
ORDER BY
	commentlist.commentID DESC");

    header('Content-Type:application/json');
    echo json_encode($commentList);

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getComment();
}
