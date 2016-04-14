<?php

namespace Training\Controller;

use Zend\Config\Processor\Filter;

use Zend\View\Model\ViewModel;

use Zend\Config\Config as ZCConfig;

use Zend\Config\Processor\Token as ZCPToken;

use Zend\Mvc\Controller\AbstractActionController;

class ConfigController extends AbstractActionController {
	
	public function indexAction() {
		echo __METHOD__;
		
		$configArray 		=	array(
			'website' 		=>	'<h3>www.zend.vn</h3>',
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
		/*define('MYCONST', 'This is a constant');
		$processor	=	new \Zend\Config\Processor\Constant();
		
		$config 	=	new \Zend\Config\Config(array('const' => 'MYCONST'), true);
		
		$processor->process($config);*/
		
		/*echo '<pre>';
		print_r($configArray);
		echo '</pre>';*/
		
		// Zend\Config\Processor\Filter
		
		$config 	=	new \Zend\Config\Config($configArray, true);
		$filter 	=	new \Zend\Filter\StringToUpper();
		$processor 	=	new \Zend\Config\Processor\Filter($filter);
		$processor->process($config);
		
		
		
		echo '<br />' . $config->account->content;
		
		// Zend\Config\Processor\Queue
		// FIFO logic (First In, First Out)
		$config 			=	new \Zend\Config\Config($configArray, true);
		$filterUpper 		=	new \Zend\Filter\StringToUpper();
		$filterStripTags 	=	new \Zend\Filter\StripTags();
		$processorUpper 	=	new \Zend\Config\Processor\Filter($filterUpper);
		$processStripTags 	=	new \Zend\Config\Processor\Filter($filterStripTags);
		
		$queue 				=	new \Zend\Config\Processor\Queue();
		$queue->insert($processorUpper);
		$queue->insert($processStripTags);
		$queue->process($config);
		
		// Zend\Config\Processor\Token
		$config 			=	new ZCConfig(array('token' 	=>	'Token value: TOKEN'), true);
		$processor 			=	new ZCPToken();
		
		$processor->addToken('TOKEN', 'Hello');
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
	
	public function index2Action() {
		
		$reader 	=	new \Zend\Config\Reader\Ini();
		// Cau hinh
		$reader->setNestSeparator('-');
		$data 		=	$reader->fromFile(__DIR__ . '/../../../config/ini/module.config.ini', true);
		
		$config 	=	new \Zend\Config\Config(array(), true);
		$config->production							=		array();
		$config->production->website				=		'www.zend.vn';
		$config->production->account				=		array();
		$config->production->account->email			=		'zend2@zend.vn';
		$config->production->account->port			=		465;
		
		$writer 	=	new \Zend\Config\Writer\Ini();
		$writer->setNestSeparator('-');
		$writer->toFile(__DIR__ . '/../../../config/ini/config.ini', $config);
		
		//return false;	
	}
	
	public function index3Action() {
		
		echo '<h3>'.__METHOD__.'</h3>';
		
		// Doc tap tin XML
		/*$reader 	=	new \Zend\Config\Reader\Xml();
		$data 		=	$reader->fromFile(__DIR__ . '/../../../config/xml/config.xml');
		
		// Ghi tap tin XML
		$config 	=	new \Zend\Config\Config(array(), true);
		$config->production 						=		array();
		$config->production->website				=		'www.zend.vn';
		$config->production->account				=		array();
		$config->production->account->email			=		'zend2@zend.vn';
		$config->production->account->port			=		465;
		
		$writer 	=	new \Zend\Config\Writer\Xml();
		$writer->toFile(__DIR__ . '/../../../config/xml/config2.xml', $config);*/
		
		
		
		
		
		return false;	
	}
		
}