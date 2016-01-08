<?php
    /********************** PATHS *************************/
    define('DS'                 , DIRECTORY_SEPARATOR);
    define('ROOT_PATH'          , dirname(__FILE__)); // Dinh nghia duong dan den thu muc goc
    define('LIBRARY_PATH'       , ROOT_PATH . DS .'libs' . DS);
    define('CONTROLLER_PATH'    , ROOT_PATH . DS .'controllers' . DS);
    define('MODEL_PATH'         , ROOT_PATH . DS .'models' . DS);
    define('VIEW_PATH'          , ROOT_PATH . DS .'views' . DS);
    define('PUBLIC_PATH'        , ROOT_PATH . DS .'public' . DS);
    
    define	('ROOT_URL'			, './');
	define	('PUBLIC_URL'		, ROOT_URL . 'public/');
	define	('VIEW_URL'			, ROOT_URL . 'views/');
    
    /********************** DATABASE *********************/
    define('DB_HOST'            , 'localhost');
    define('DB_USER'            , 'root');
    define('DB_PASS'            , '');
    define('DB_NAME'            , 'management');
    define('DB_TABLE'           , 'user');