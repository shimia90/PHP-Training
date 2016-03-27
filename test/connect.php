<?php 
require_once 'class/Database.class.php';
$params		= array(
    'server' 	=> 'localhost',
    'username'	=> 'root',
    'password'	=> '',
    'database'	=> 'test',
    'table'		=> 'client',
);
$database = new Database($params);
?>