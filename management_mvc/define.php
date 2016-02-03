<?php
    /********************** PATHS *************************/
    define('DS'                 , '/');
    define('ROOT_PATH'          , dirname(__FILE__)); // Dinh nghia duong dan den thu muc goc
    define('LIBRARY_PATH'       , ROOT_PATH . DS .'libs' . DS);
    define('PUBLIC_PATH'        , ROOT_PATH . DS .'public' . DS);
    define('APPLICATION_PATH'   , ROOT_PATH . DS .'application' . DS); // Dinh nghia duong dan den thu muc application
	define('MODULE_PATH'   		, APPLICATION_PATH . 'module' . DS); // Dinh nghia duong dan den thu muc module
    define('TEMPLATE_PATH'      , PUBLIC_PATH . 'template' . DS);
    
    /********************** URL *************************/
    define	('ROOT_URL'			, './');
	define	('PUBLIC_URL'		, ROOT_URL . 'public/');
	define	('VIEW_URL'			, ROOT_URL . 'views/');
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template/');
	define	('APPLICATION_URL'	, ROOT_URL . 'application/');
	
	// ====================== DATABASE ===========================
	define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'bookstore');						
	define ('DB_TABLE'			, 'group');			

	// ====================== DATABASE TABLE===========================
	define ('TBL_GROUP'			, 'group');
	define ('TBL_USER'          , 'user');