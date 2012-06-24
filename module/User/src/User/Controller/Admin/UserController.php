<?php

namespace User\Controller\Admin;

use Base\Controller\Admin\AdminActionController,
	Zend\Authentication\AuthenticationService,
	Zend\Authentication\Adapter\DbTable as AuthenticationAdapter,
	Zend\Authentication\Storage\Session as AuthenticationStorage,
	Zend\Form\FormInterface,
	User\Model\UserTable,
	User\Model\User,
	User\Form\UserForm;

class UserController extends AdminActionController
{
	/**
	 * ZendStore admin session namespace
	 */
	const NAMESPACE_ZENDSTORE_ADMIN = 'ZendStore_Admin';
	
	/**
	 * @var UserTable
	 */
	protected $userTable;
	
    public function indexAction()
    {
    	$this->layout()->setTemplate('layout/admin');
    	
    	$user = $this->getUserTable()->getUser(21);
        
    	$authStorage = new AuthenticationStorage(self::NAMESPACE_ZENDSTORE_ADMIN);
    	$authService = new AuthenticationService($authStorage);
    	echo 'User logined?';
        var_dump($authService->hasIdentity());
        var_dump($authService->getIdentity());

        $viewVars  = array('user' => $user);
        $viewModel = $this->getViewModel(__METHOD__);
        $viewModel->setVariables($viewVars);
        
        return $viewModel;
    }

    /**
     * Get UserTable
     *
     * @return UserTable
     */
    public function getUserTable()
    {
    	if (!$this->userTable) {
    		$sm = $this->getServiceLocator();
    		$this->userTable = $sm->get('user-table');
    	}
    	return $this->userTable;
    }
}
