<?php
require_once ("../components/inquire.php");
function getPersonMg(){
    if (empty($_GET['userID'])){
        echo "请输入有效参数";
        return;
    }
    $userID=$_GET['userID'];
    $personMg=inquire("SELECT userlist.* FROM userlist WHERE userlist.userID = '{$userID}'");
    header('Content-type: application/json');
    echo json_encode($personMg) ;
    return;
}
if ($_SERVER['REQUEST_METHOD']==='GET'){
    getPersonMg();
}
