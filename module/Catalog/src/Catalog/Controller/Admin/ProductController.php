<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;
use	Catalog\Model\ProductTable;
use	Catalog\Model\Product;
use Catalog\Model\MergedProduct;
use Catalog\Model\MergedProductTable;
use	Catalog\Form\ProductForm;

class ProductController extends AbstractAdminActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	/**
	 * @var MergedProductTable
	 */
	protected $mergedProductTable;
	
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
		$mergedProduct = new MergedProduct();
		$form 	 = new ProductForm();
		//$form->bind($mergedProduct);
		
		if ($this->request->isPost()) {
			$data = array_merge($this->request->getPost()->toArray(), array(
				'created_date' => time(),
				'updated_date' => time(), 	
			));
			$mergedProduct->exchangeArray($data);
			$this->getMergedProductTable()->saveMergedProduct($mergedProduct);
			return $this->redirect()->toRoute('catalog-admin-product');
// 			$form->setInputFilter($inputFilter)
// 				 ->setData($data);
// 			if ($form->isValid()) {
// 				$this->getProductTable()->saveProduct($product);
// 				return $this->redirect()->toRoute('catalog-admin-product');
// 			}
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
	 * Get ProductTable
	 *
	 * @return ProductTable
	 */
	public function getProductTable()
	{
		if (! $this->productTable instanceof ProductTable) {
			$sm = $this->getServiceLocator();
			$this->productTable = $sm->get('Catalog\Model\ProductTable');
		}
		return $this->productTable;
	}
	
	/**
	 * Get MergedProductTable
	 * 
	 * @return MergedProductTable
	 */
	public function getMergedProductTable()
	{
		if (! $this->mergedProductTable instanceof MergedProductTable) {
			$sm = $this->getServiceLocator();
			$this->mergedProductTable = $sm->get('Catalog\Model\MergedProductTable');
		}
		return $this->mergedProductTable;
	}
}