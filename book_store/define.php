<?php
    /********************** PATHS *************************/
    define('DS'                 , '/');
    define('ROOT_PATH'          , dirname(__FILE__)); // Dinh nghia duong dan den thu muc goc
    define('LIBRARY_PATH'       , ROOT_PATH . DS .'libs' . DS);
	define('LIBRARY_EXT_PATH'   , LIBRARY_PATH . 'extends' . DS);
    define('PUBLIC_PATH'        , ROOT_PATH . DS .'public' . DS);
	define('UPLOAD_PATH'        , PUBLIC_PATH . 'files' . DS);
	define('SCRIPT_PATH'        , PUBLIC_PATH . DS .'scripts' . DS);
    define('APPLICATION_PATH'   , ROOT_PATH . DS .'application' . DS); // Dinh nghia duong dan den thu muc application
	define('MODULE_PATH'   		, APPLICATION_PATH . 'module' . DS); // Dinh nghia duong dan den thu muc module
	define('BLOCK_PATH'   		, APPLICATION_PATH . 'block' . DS); // Dinh nghia duong dan den thu muc block
    define('TEMPLATE_PATH'      , PUBLIC_PATH . 'template' . DS);
    
    /********************** URL *************************/
    define	('ROOT_URL'			, './');
	define	('PUBLIC_URL'		, ROOT_URL . 'public/');
	define	('VIEW_URL'			, ROOT_URL . 'views/');
	define	('TEMPLATE_URL'		, PUBLIC_URL . 'template/');
	define	('APPLICATION_URL'	, ROOT_URL . 'application/');
	define	('UPLOAD_URL'		, PUBLIC_URL . 'files' . DS);
	
	// ====================== DATABASE ===========================
	define ('DB_HOST'			, 'localhost');
	define ('DB_USER'			, 'root');						
	define ('DB_PASS'			, '');						
	define ('DB_NAME'			, 'bookstore');						
	define ('DB_TABLE'			, 'group');			

	// ====================== DATABASE TABLE===========================
	define ('TBL_GROUP'			, 'group');
	define ('TBL_USER'          , 'user');
	define ('TBL_PRIVILEGE'     , 'privilege');
	define ('TBL_CATEGORY'      , 'category');
	define ('TBL_BOOK'          , 'book');
	define ('TBL_CART'          , 'cart');
	
	// ====================== CONFIG===========================
	define ('TIME_LOGIN'		, 3600);