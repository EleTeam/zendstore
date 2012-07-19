<?php

namespace Catalog\Controller\Admin;


use Zend\Json\Json;

use Catalog\Model\Category;

use Zend\Form\FormInterface;
use ZendStore\Controller\AbstractAdminActionController;
use Catalog\Model\CategoryTable;
use Catalog\Form\CategoryForm;

class CategoryController extends AbstractAdminActionController
{	
	/**
	 * @var CategoryTable
	 */
	protected $categoryTable;
	
	public function indexAction()
	{
		$viewModel = $this->getViewModel();
		
		return $viewModel;
	}	
	
	public function addAction()
	{
		$category = new Category();
		$form 	  = new CategoryForm();
		$form->bind($category);

		$result = array(
			'succeed' => false,
			'message' => '',
			'data'	  => '',
		);
		
		if ($this->request->isPost()) {
			$data = array_merge($this->request->getPost()->toArray(), array(
				'created_date' => time(),
				'updated_date' => time(),	
			));
			$form->setInputFilter($category->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) {
				$this->getCategoryTable()->saveCategory($category);
				$result['succeed'] = true;
				$result['data']	   = array(
					'category_id' => $this->getCategoryTable()->getLastInsertValue()
				);
			}
		}
		
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Pragma: no-cache");
		
		$this->response->setContent(Json::encode($result));
		return $this->response;
	}
	
	public function editAction()
	{
		$viewModel = $this->getViewModel();
		$viewModel->setTerminal(true);
		
		$id 	  = (int) $this->getEvent()->getRouteMatch()->getParam('id');
		$category = $this->getCategoryTable()->getCategory($id);
		$form 	  = new CategoryForm();
		$form->bind($category);
		
		if ($this->request->isPost()) {
			$form->setInputFilter($category->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) {
				$this->getCategoryTable()->saveCategory($category);
			}
		}
		
		$viewModel->setVariables(array(
			'form' => $form,	
		));
			
		return $viewModel;		
	}
	
	/**
	 * List children and encode it with json
	 */
	public function listAction()
	{
		$id   = (int) $this->getEvent()->getRouteMatch()->getParam('id');
		$data = array();

		try {
			$categories = $this->getCategoryTable()->getCategoryChildren($id);
			foreach ($categories as $category) {
				switch ($category->type) {
					case 1:
						$type = 'folder';
						break;
					default:
						$type = 'folder';
						break;
				}
				$data[] = array(
					'attr' => array('id' => "node_{$category->category_id}", 'rel' => $type),
					'data' => $category->category_name,	
					'state' => 'closed',
				);
			}
		} catch (\Catalog\Model\Exception\UnexpectedValueException $e) {}
		
		header("HTTP/1.0 200 OK");
		header('Content-type: application/json; charset=utf-8');
		header("Cache-Control: no-cache, must-revalidate");
		header("Expires: Mon, 26 Jul 1997 05:00:00 GMT");
		header("Pragma: no-cache");
		
		/*** Due to jstree, can't use this format
		$result = array(
			'succeed' => true,
			'message' => '',
			'data'	  => $data,	
		);
		*/
		$result = $data;
		
		$this->response->setContent(Json::encode($result));
		return $this->response;		
	}	
	
	/**
	 * @return CategoryTable
	 */
	public function getCategoryTable()
	{
		if (!$this->categoryTable) {
			$sm = $this->getServiceLocator();
			$this->categoryTable = $sm->get('Catalog\Model\CategoryTable');
		}
		return $this->categoryTable;
	}

}