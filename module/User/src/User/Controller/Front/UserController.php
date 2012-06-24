<?php

namespace User\Controller\Front;

use Base\Controller\BaseActionController,
	Zend\Authentication\AuthenticationService,
	Zend\Authentication\Adapter\DbTable as AuthenticationAdapter,
	Zend\Authentication\Storage\Session as AuthenticationStorage,
	Zend\Form\FormInterface,
	User\Model\UserTable,
	User\Model\User,
	User\Form\UserForm;

class UserController extends BaseActionController
{
	/**
	 * ZendStore front session namespace
	 */
	const NAMESPACE_ZENDSTORE_FRONT = 'ZendStore_Front';
	
	/**
	 * @var UserTable
	 */
	protected $userTable;
	
    public function indexAction()
    {
    	$user = $this->getUserTable()->getUser(21);
        
    	$authStorage = new AuthenticationStorage(self::NAMESPACE_ZENDSTORE_FRONT);
    	$authService = new AuthenticationService($authStorage);
    	echo 'User logined?';
        var_dump($authService->hasIdentity());
        var_dump($authService->getIdentity());

        $viewVars  = array('user' => $user);
        $viewModel = $this->getViewModel(__METHOD__);
        $viewModel->setVariables($viewVars);
        
        return $viewModel;
    }
    
    public function registerAction()
    {
		$authStorage = new AuthenticationStorage(self::NAMESPACE_ZENDSTORE_FRONT);
    	$authService = new AuthenticationService($authStorage);
    	if ($authService->hasIdentity()) {
    		echo 'You have logined';
    		exit;
    	}
    	 
    	$request = $this->getRequest();
    	$form = new UserForm();
    	
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->post());
    		
    		if ($form->isValid()) {
    			$formData = $form->getData();
    			$formData['password_salt'] 	= uniqid();
    			$formData['password'] 		= md5($formData['password'] . $formData['password_salt']);
    			$formData['register_date']	= date('Y-m-d H:i:s');
    			$formData['active']			= 1;
    			
    			$user->populate($formData);
    			$this->getUserTable()->saveUser($user);
    			return $this->redirect()->toRoute('front-user-user', array('action' => 'login'));
    		} else {
    			echo '<pre>';
    			print_r($form->getMessages());
    			exit;
    		}
    	}
    	 
    	$viewVars  = array('form' => $form);
    	$viewModel = $this->getViewModel(__METHOD__);
    	$viewModel->setVariables($viewVars);

    	return $viewModel;
    }
    
    public function loginAction()
    {
    	$authStorage = new AuthenticationStorage(self::NAMESPACE_ZENDSTORE_FRONT);
    	$authService = new AuthenticationService($authStorage);
    	if ($authService->hasIdentity()) {
    		echo 'You have logined';
    		exit;
    	}
    	
    	$form = new UserForm();
    	
    	$request = $this->getRequest();
    	if ($request->isPost()) {
    		$user = new User();
    		$form->setInputFilter($user->getInputFilter());
    		$form->setData($request->post());
    		
    		if ($form->isValid()) {
    			$data = $form->getData();
    			// Authentication
    			$sm 		 = $this->getServiceLocator();
		    	$db			 = $sm->get('db-adapter');
		    	//$authAdapter = new AuthenticationAdapter($db, 'user', 'email', 'password', 'MD5(?)');
		    	$authAdapter = new AuthenticationAdapter($db, 'user', 'email', 'password', 'MD5(CONCAT(?, password_salt))');
		    	$authAdapter->setIdentity($data['email']);
		    	$authAdapter->setCredential($data['password']);
		    	$result 	 = $authService->authenticate($authAdapter);
		    	if ($result->isValid()) {
		    		return $this->redirect()->toRoute('front-user-user');
		    	} else {
		    		var_dump($result->getMessages());
		    		exit;
		    	}
    		} else {
    			echo '<h1>ERROR: Form data is invalid.</h1>';
    			echo '<pre>';
    			print_r($form->getMessages());
    			exit;
    		}
    	}
    	
    	$viewVars  = array('form' => $form);
    	$viewModel = $this->getViewModel(__METHOD__);
    	$viewModel->setVariables($viewVars);

    	return $viewModel;
    }
    
    public function logoutAction()
    {
    	$authStorage = new AuthenticationStorage(self::NAMESPACE_ZENDSTORE_FRONT);
    	$authService = new AuthenticationService($authStorage);
    	$authService->clearIdentity();
    	return $this->redirect()->toRoute('front-user-user');
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
