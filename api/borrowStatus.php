<?php
function borrowStatus(){
    $userID=$_POST['userID'];
    $bookID=$_POST['bookID'];

    $connection=mysqli_connect("127.0.0.1",'root','147199512','digital_library');
    if (!$connection){
        echo "数据库链接失败";
        return;
    }
    $query=mysqli_query($connection,"SELECT
	borrowlist.borrowStatus
FROM
	borrowlist
WHERE
	borrowlist.userID = '{$userID}' AND
	borrowlist.bookID = '{$bookID}' AND
	borrowlist.borrowStatus = 1");
   $status=mysqli_fetch_assoc($query);
    if ($status['borrowStatus']==1){
        echo "1";
        return;
    }else{
        echo "2";
    }
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    borrowStatus();
}
