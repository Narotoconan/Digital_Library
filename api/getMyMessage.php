<?php
require_once ("../components/inquire.php");
function getMyMessage(){
    if (empty($_POST['userID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $userID=$_POST['userID'];
    $myMessage=inquire("SELECT
	commentlist.bookID, 
	commentlist.reply, 
	commentlist.replyDate, 
	commentlist.replyView, 
	booklist.bookName,
	commentlist.comments
FROM
	commentlist
	INNER JOIN
	booklist
	ON 
		commentlist.bookID = booklist.bookID
WHERE
	commentlist.userID = '{$userID}' AND
	(commentlist.replyView = 1 OR
	commentlist.replyView = 2)
ORDER BY
	commentlist.replyDate DESC");

    header('Content-Type:application/json');
    echo json_encode($myMessage) ;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getMyMessage();
}
