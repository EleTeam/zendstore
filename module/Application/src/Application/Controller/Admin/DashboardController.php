<?php

namespace Application\Controller\Admin;

use ZendStore\Controller\AdminActionController;

class DashboardController extends AdminActionController
{
    public function indexAction()
    {
    	$viewModel = $this->getViewModel();
    	
        return $viewModel;
    }
}
