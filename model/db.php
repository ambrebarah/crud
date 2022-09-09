<?php

define('HOST', 'localhost'); 
define('USER', 'ambre'); 
define('PASSWORD', 'password'); 
define('DATABASE', 'my_crud'); 

function DB()
{
    try {
        $db = new PDO('mysql:host='.HOST.';dbname='.DATABASE.'', USER, PASSWORD);
        return $db;
    } catch (PDOException $e) {
        return "Error!: " . $e->getMessage();
        die();
    }
}
?>