<?php

namespace Application\Controller;

use Zend\Mvc\Controller\ActionController,
    Zend\View\Model\ViewModel;

class AdminIndexController extends ActionController
{
    public function indexAction()
    {
        return new ViewModel();
    }
}
