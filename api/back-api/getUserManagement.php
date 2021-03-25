<?php
require_once ("../../components/inquire.php");
function getUserManagement(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $currentPage=$_POST['currentPage'];
    $offset=($currentPage-1)*15;
    $userList=inquire("SELECT
	userlist.userID, 
	userlist.userName, 
	userlist.gender, 
	userlist.registerDate, 
	userlist.userEmail
FROM
	userlist
LIMIT {$offset}, 15");

    header('Content-Type:application/json');
    echo json_encode($userList) ;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getUserManagement();
}
