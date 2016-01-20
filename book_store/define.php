<?php
    /********************** PATHS *************************/
    define('DS'                 , DIRECTORY_SEPARATOR);
    define('ROOT_PATH'          , dirname(__FILE__)); // Dinh nghia duong dan den thu muc goc
    define('LIBRARY_PATH'       , ROOT_PATH . DS .'libs' . DS);
    define('PUBLIC_PATH'        , ROOT_PATH . DS .'public' . DS);
    define('APPLICATION_PATH'   , ROOT_PATH . DS .'application' . DS);
    define('TEMPLATE_PATH'      , PUBLIC_PATH . 'template' . DS);
    
    /********************** URL *************************/
    define	('ROOT_URL'			, './');
	define	('PUBLIC_URL'		, ROOT_URL . 'public/');
	define	('VIEW_URL'			, ROOT_URL . 'views/');
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template/');
	define	('APPLICATION_URL'	, ROOT_URL . 'application/');
	
	/********************** VARIABLES *************************/
	define	('DEFAULT_MODULE'	      , 'default');
	define	('DEFAULT_CONTROLLER'     , 'index');
	define	('DEFAULT_ACTION'		  , 'index');
    
    /********************** DATABASE *********************/
    define('DB_HOST'            , 'localhost');
    define('DB_USER'            , 'root');
    define('DB_PASS'            , '');
    define('DB_NAME'            , 'bookstore');
    define('DB_TABLE'           , 'group');
    
    /********************** DATABASE TABLE *********************/
    define('TBL_GROUP'          , 'group');