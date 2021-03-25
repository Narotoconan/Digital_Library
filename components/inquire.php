<?php
    function inquire($sql){
        $connection=mysqli_connect('127.0.0.1','root','147199512','digital_library');
        if (!$connection){
            return "数据库了连接失败";
        }
        $query=mysqli_query($connection,$sql);
        if (!$query){
            return "查询失败";
        }
        $data=[];
        while ($row=mysqli_fetch_assoc($query)){
            $data[]=$row;
        }
        mysqli_free_result($query);
        mysqli_close($connection);
        return  $data;
    }
