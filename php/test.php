<?php
    include "DBase.php";

    $db = new DBConnect();

    $return = $db->query("SELECT * FROM ","                materials      ", "",[]);
    $res = $db->query("UPDATE ","work_request","SET status=? WHERE id = ?",["MANAGER", 4]);
    
    if($return){
        echo 'successful';
        while($item = $return->fetch()){
            echo $item['name']."<br>";
        }
    }else{
        echo "fail";
    }

?>