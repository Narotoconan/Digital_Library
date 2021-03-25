<?php
function increase($sql){
    $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
    if (!$connection){
        return "数据库了连接失败";
    }
    $query=mysqli_query($connection,$sql);
    if (!$query){
        return "添加失败";
    }
    return "添加成功";
}
