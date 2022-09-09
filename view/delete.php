<?php

include("../model/db.php");

$db = Db();


if(isset($_REQUEST['delete_id'])){
    $id = $_REQUEST['delete_id'];
    $sql = "DELETE FROM `users` WHERE `user_id` = :user_id";
    $query = $db->prepare($sql);
    $query->execute(array(":user_id" => $id));
}


//redirecting to the display page (index.php in our case)
header("Location:../index.php");
?>