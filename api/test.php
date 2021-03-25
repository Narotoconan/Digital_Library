<?php
function test()
{
    if (empty($_POST['message'])){
        echo "没有";
        return;
    };
    $arr = $_POST['message'];
    echo json_encode($arr);
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    test();
}