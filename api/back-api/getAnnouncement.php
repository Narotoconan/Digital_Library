<?php
require_once ("../../components/inquire.php");
function getAnnouncement(){
    if (empty($_POST['adminID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $announcement=inquire("SELECT
	announcement.*
FROM
	announcement
ORDER BY
	announcement.date DESC");

    header('Content-Type:application/json');
    echo json_encode($announcement) ;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getAnnouncement();
}
