<?php

namespace Training;

class Module {
	
	/*
	public function onBoostrap() {
		
	} */
	
	public function getConfig() {
		return include __DIR__ . '/config/module.config.php';
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