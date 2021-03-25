<?php
require_once ("../../components/inquire.php");
function getHomeData(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $homeData=[];
    $bookData=inquire("SELECT
	SUM(booklist.bookBorrow), 
	SUM(booklist.bookVisits),  
	COUNT(booklist.bookID)
FROM
	booklist");
    $userData=inquire("SELECT
	COUNT(1)
FROM
	userlist");
    $commentData=inquire("SELECT
	COUNT(1)
FROM
	commentlist");

    $homeData['bookBorrow']=$bookData[0]['SUM(booklist.bookBorrow)'];
    $homeData['bookVisits']=$bookData[0]['SUM(booklist.bookVisits)'];
    $homeData['bookCount']=$bookData[0]['COUNT(booklist.bookID)'];
    $homeData['userCount']=$userData[0]['COUNT(1)'];
    $homeData['commentCount']=$commentData[0]['COUNT(1)'];

    header('Content-Type:application/json');
    echo json_encode($homeData) ;

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getHomeData();
}
