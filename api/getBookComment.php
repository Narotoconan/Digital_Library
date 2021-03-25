<?php
require_once ("../components/inquire.php");
function getBookComment(){
    if (empty($_POST['bookID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $bookID=$_POST['bookID'];
    $theBookComment=inquire("SELECT
	userlist.userName, 
	userlist.userAvatar, 
	commentlist.commentID, 
	commentlist.comments, 
	commentlist.commentDate, 
	commentlist.reply, 
	commentlist.replyDate
FROM
	commentlist
	INNER JOIN
	userlist
	ON 
		commentlist.userID = userlist.userID
WHERE
	commentlist.bookID = '{$bookID}'
ORDER BY
	commentlist.commentDate DESC");

    header('Content-Type:application/json');
    echo json_encode($theBookComment) ;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getBookComment();
}
