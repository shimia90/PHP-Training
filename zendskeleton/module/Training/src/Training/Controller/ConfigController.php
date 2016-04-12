<?php

namespace Training\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class ConfigController extends AbstractActionController {
	
	public function indexAction() {
		echo __METHOD__;
		
		$configArray 		=	array(
			'website' 		=>	'www.zend.vn',
			'account'		=>	array(
				'email'		=>	'zend2@zend.vn',
				'password'	=>	'123456',
				'title'		=>	'Zend Config',
				'content'	=>	'Training Zend Config',
				'port'		=>	'465'
			)
		);
		

		
		// 01 Chuyen 1 mang config thanh 1 doi tuong config cua Zend Framework
		//$config 	=	new \Zend\Config\Config($configArray);
		//echo '<br />'. $config->account->get('port_abc', 500);
		
		// 02 Chuyen file config thanh 1 doi tuong config
		//$config 	=	new \Zend\Config\Config(include __DIR__ . '/../../../config/module.config.php');
		/*echo '<pre>';
		print_r($config);
		echo '</pre>';*/
		
		// 03 Zend\Config\Processor\ thuc hien mot so hanh dong tren doi tuong Zend\Config\Config
		define('MYCONST', 'This is a constant');
		$processor	=	new \Zend\Config\Processor\Constant();
		
		$config 	=	new \Zend\Config\Config(array('const' => 'MYCONST'), true);
		
		$processor->process($config);
		
		echo '<pre>';
		print_r($config);
		echo '</pre>';
		
		// Disable View
		// Method 1: return false;
		// Method 2: return '';
		
		// Disable layout
		// $viewModel 	=	new ViewModel();
		// $viewModel->setTerminal(true);
		// return $viewModel;
		
		// Disable Layout & Disable View
		// Method 1: return $this->getResponse();
		// Method 2: 
		return false;
		
	}
		
}