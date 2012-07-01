<?php

namespace Application\Controller\Front;

use ZendStore\Controller\AbstractFrontActionController;

class IndexController extends AbstractFrontActionController
{
    public function indexAction()
    {
        $viewModel = $this->getViewModel();

        return $viewModel;
    }
}
