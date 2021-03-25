<?php
function test()
{
    $response = json_decode(file_get_contents('php://input'), true);
    if (!$response['message']){
        echo '没有';
        return;
    }
    echo json_encode($response['message']);
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    test();
}
