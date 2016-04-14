<?php

namespace Training;

class Module {
	
	/*
	public function onBoostrap() {
		
	} */
	
	public function getConfig() {
		/*$reader 		=		new \Zend\Config\Reader\Ini();
		$reader->setNestSeparator('.');
		$configArray	=		$reader->fromFile(__DIR__ . '/config/module.config.ini');
		
		$configArray['view_manager']['template_path_stack'][] 	=	__DIR__ . '/view';*/
		
		/*// Get Router Config From router.ini
		
		$reader 		=		new \Zend\Config\Reader\Ini();
		$reader->setNestSeparator('.');
		$configRouter 	=		$reader->fromFile(__DIR__ . '/config/ini/router.ini');
		
		// 
		$configCV 		=		include __DIR__ . '/config/ini/controller-view.php';
		
		$configArray 	=		array_merge($configRouter, $configCV);*/
		
		$reader 			=		new \Zend\Config\Reader\XML();
		$configArray 		=		$reader->fromFile(__DIR__ . '/config/module.config.xml');
		$configArray['view_manager']['template_path_stack'][] 	=	__DIR__ . '/view';
		
		foreach($configArray['controllers']['invokables'] as $key 	=>		$value) {
			$newKey 		=		preg_replace('#Controller$#', '', $value);
			$configArray['controllers']['invokables'][$newKey] 	=	$value;
			unset($configArray['controllers']['invokables'][$key]);
		}
		
		
		
		return $configArray;
	}
	
	// Tu dong load cac controller va model cua Module thong qua ModuleManager
	public function getAutoloaderConfig() {
		return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
	}
	
	
}