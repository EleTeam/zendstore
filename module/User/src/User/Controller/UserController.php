<?php

namespace User\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel;

class UserController extends ActionController
{
    public function indexAction()
    {
        return new ViewModel(array(
            'v' => 'value',
        ));
    }
    
}
