<?php
function getList()
{
    $list = inquire("SELECT announcement.* FROM announcement ORDER BY announcement.date DESC ");

    header('Content-Type:application/json');
    echo json_encode($list);
}
require_once ("../components/inquire.php");
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    getList();
}
