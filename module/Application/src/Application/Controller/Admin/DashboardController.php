<?php

namespace Application\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;

class DashboardController extends AbstractAdminActionController
{
    public function indexAction()
    {
    	$viewModel = $this->getViewModel();
    	
        return $viewModel;
    }
}
