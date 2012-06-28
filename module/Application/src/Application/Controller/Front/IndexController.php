<?php

namespace Application\Controller\Front;

use ZendStore\Controller\FrontActionController;

class IndexController extends FrontActionController
{
    public function indexAction()
    {
        $viewModel = $this->getViewModel();
        
        return $viewModel;
    }
}
