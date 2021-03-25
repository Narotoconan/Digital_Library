<?php
function getAnn()
{
    if (empty($_POST['annID'])) {
        exit("<h1>请输入有效参数</h1>");
    }
    $annID = $_POST['annID'];
    $ann = inquire("SELECT announcement.* FROM announcement WHERE announcement.announcementID = '{$annID}'");

    header('Content-Type:application/json');
    echo json_encode($ann);
}
require_once ("../components/inquire.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getAnn();
}
