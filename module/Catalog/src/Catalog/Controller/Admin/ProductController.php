<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;
use	Catalog\Model\ProductTable;
use	Catalog\Model\Product;
use	Catalog\Form\ProductForm;

class ProductController extends AbstractAdminActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	public function indexAction()
	{
		

		
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
				
		));
		
		return $viewModel;
	}
	
	public function addAction()
	{
		$form = new ProductForm();
		
		if ($this->request->isPost()) {
			$product = new Product();
			$form->setInputFilter($product->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
				//$product->populate($form->getData());
				$this->getProductTable()->saveProduct($product);

				exit('Added OK');
// 				return $this->redirect()->toRoute('admin-catalog-product', array(
// 					'action'	 => 'view',
// 				));
			}
		}

		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'form' => $form
		));
		
		return $viewModel;
	}
	
	public function editAction()
	{
		$id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
		if (!$id) {
			exit('Product not exist');
		}
		
		$form 	 = new ProductForm();		
		$product = $this->getProductTable()->getProduct($id);
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$product = new Product();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->post());
			if ($form->isValid()) {
				$formData = $form->getData();
				$product->populate($formData);
				$this->getProductTable()->saveProduct($product);
		
				// 				return $this->redirect()->toRoute('admin-catalog-product', array(
				// 					'action'	 => 'view',
				// 				));
			}
		}
		
		$viewVars = array(
			'form' 	  => $form,
			'product' => $product,
		);
		$viewModel = $this->getViewModel();
		$viewModel->setVariables($viewVars);
		
		return $viewModel;		
	}
	
	/**
	 * Get an instance of ProductTable
	 *
	 * @return ProductTable
	 */
	public function getProductTable()
	{
		if (!$this->productTable) {
			$sm = $this->getServiceLocator();
			$this->productTable = $sm->get('Catalog\Model\ProductTable');
		}
		return $this->productTable;
	}
}