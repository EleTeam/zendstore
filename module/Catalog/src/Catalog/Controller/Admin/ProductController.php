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
		$products = $this->getProductTable()->getProducts();
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'products' => $products,
		));
		
		return $viewModel;
	}
	
	public function addAction()
	{
		$product = new Product();
		$form 	 = new ProductForm();
		
		if ($this->request->isPost()) {
			$form->setInputFilter($product->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) {
				$product->exchangeArray($form->getData());
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
		$id 	 = $this->getEvent()->getRouteMatch()->getParam('id');
		$product = $this->getProductTable()->getProduct($id);
		$form	 = new ProductForm();		
		$form->bind($product);
		
		if ($this->request->isPost()) {
			$form->setInputFilter($product->getInputFilter())
				 ->setData($this->request->getPost());
			if ($form->isValid()) { 
				$this->getProductTable()->saveProduct($product);
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