<?php
require_once ("../../components/inquire.php");
function getComment(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $slideList=inquire("SELECT
	bannenrlist.*
FROM
	bannenrlist");

    header('Content-Type:application/json');
    echo json_encode($slideList);

}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getComment();
}
