<?php
// Duong dan den thu muc hien thoi
chdir(dirname(__DIR__));

// Hang so luu duong dan den thu muc cua ung dung
define('APPLICATION_PATH', realpath(dirname(__DIR__)));

// Hang so luu duong dan thu muc chua thu vien ZF2
define('LIBRARY_PATH', APPLICATION_PATH . '/vendor/');