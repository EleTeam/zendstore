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
		$productTable = $this->getProductTable();
		$products = $productTable->getProducts();
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'products' => $products,
		));
		
		return $viewModel;
	}
	
	public function addAction()
	{
		$productTable = $this->getProductTable();
		$product 	  = new Product();
		$form 		  = new ProductForm();
		
		if ($this->request->isPost()) {
			$form->setInputFilter($product->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) {
				$product->populate($form->getData());
				$this->getProductTable()->saveProduct($product);
				return $this->redirect()->toRoute('catalog-admin-product');
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
		$id 	 	  = $this->getEvent()->getRouteMatch()->getParam('id');
		$productTable = $this->getProductTable();
		$product 	  = $productTable->getProduct($id);
		$form	 	  = new ProductForm();		
		$form->bind($product);
		
		if ($this->request->isPost()) {
			$form->setInputFilter($product->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) { 
				$productTable->saveProduct($product);
				return $this->redirect()->toRoute('catalog-admin-product');
			}
		}
		
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'form' => $form,
		));
		
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