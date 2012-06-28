<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AdminActionController,
	Catalog\Model\ProductTable,
	Catalog\Model\Product,
	Catalog\Form\ProductForm;

class ProductController extends AdminActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	public function indexAction()
	{
		
	}
	
	public function addAction()
	{
		$form = new ProductForm();
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$product = new Product();
			$form->setInputFilter($product->getInputFilter());
			$form->setData($request->post());
			if ($form->isValid()) {
				$formData = $form->getData();
				$product->populate($formData);
				$this->getProductTable()->saveProduct($product);

				exit('Added OK');
// 				return $this->redirect()->toRoute('admin-catalog-product', array(
// 					'action'	 => 'view',
// 				));
			}
		}

		$viewVars  = array('form' => $form);
		$viewModel = $this->getViewModel();
		$viewModel->setVariables($viewVars);
		
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
		
				exit('Edit OK');
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
			$this->productTable = $sm->get('product-table');
		}
		return $this->productTable;
	}
}