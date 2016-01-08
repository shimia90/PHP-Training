<?php
    require_once 'define.php';
    function __autoload($className) {
        require_once LIBRARY_PATH . "{$className}.php";
    }
    $bootstrap  =   new Bootstrap();
?>