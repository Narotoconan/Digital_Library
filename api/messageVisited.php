<?php
function messageVisited(){
    if (empty($_POST['userID'])){
        exit("<h1>请输入有效参数</h1>");
    }
    $userID=$_POST['userID'];
    $connection=mysqli_connect("127.0.0.1",'root','147199512','digital_library');
    $query=mysqli_query($connection,"UPDATE commentlist SET commentlist.replyView = 2
WHERE 
    commentlist.userID = '{$userID}' 
AND
	commentlist.replyView = 1");
    echo "aaa";
    return;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    messageVisited();
}
