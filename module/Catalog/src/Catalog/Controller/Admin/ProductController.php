<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;
use Catalog\Model\ProductMergedRow;
use	Catalog\Form\ProductForm;

class ProductController extends AbstractAdminActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;

	/**
	 * @var ProductDescriptionTable
	 */
	protected $productDescriptionTable;
	
	/**
	 * @var ProductMergedTable
	 */
	protected $productMergedTable;
	
	public function indexAction()
	{
		$productMergedRows = $this->getProductMergedTable()->getProductMergedRows(); 
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'products' => $productMergedRows,
		));
		
		return $viewModel;
	}
	
	public function addAction()
	{
		$productMergedRow = new ProductMergedRow();
		$form = new ProductForm();
		//$form->bind($mergedProduct);
		
		if ($this->request->isPost()) {
			$data = array_merge($this->request->getPost()->toArray(), array(
				'created_date' => time(),
				'updated_date' => time(), 	
			));
			$productMergedRow->exchangeArray($data);
			$this->getProductMergedTable()->saveProductMerged($productMergedRow);
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
		$id		 	 	  = $this->getEvent()->getRouteMatch()->getParam('id');
		$productMergedRow = $this->getProductMergedTable()->getProductMergedRow($id);
		$form		 	  = new ProductForm();		
		$form->bind($productMergedRow);
		
		if ($this->request->isPost()) {
			$form->setData($this->request->getPost());
			echo '<pre>';
			$form->isValid();
			print_r($form->getData());exit;
			if ($form->isValid()) {
				echo '<pre>';
				print_r($productMergedRow);exit;
				$this->getProductMergedTable()->saveProductMergedRow($productMergedRow);
				//return $this->redirect()->toRoute('catalog-admin-product');
			}
			echo '<pre>';print_r($form->getMessages());exit;
		}
		
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'form' => $form,
		));
		
		return $viewModel;		
	}
	
	/**
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
	 * @return ProductDescriptionTable
	 */
	public function getProductDescriptionTable()
	{
		if (! $this->productDescriptionTable instanceof ProductDescriptionTable) {
			$sm = $this->getServiceLocator();
			$this->productDescriptionTable = $sm->get('Catalog\Model\ProductDescriptionTable');
		}
		return $this->productDescriptionTable;
	}
	
	/**
	 * @return ProductMergedTable
	 */
	public function getProductMergedTable()
	{
		if (! $this->productMergedTable instanceof ProductMergedTable) {
			$sm = $this->getServiceLocator();
			$this->productMergedTable = $sm->get('Catalog\Model\ProductMergedTable');
		}
		return $this->productMergedTable;
	}
}