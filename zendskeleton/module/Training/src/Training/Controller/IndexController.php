<?php

namespace Training\Controller;

use Zend\View\Model\ViewModel;

use Zend\Mvc\Controller\AbstractActionController;

class IndexController extends AbstractActionController {
	
	public function indexAction() {
		echo __METHOD__;
		
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
		return $this->response;
	}
		
}