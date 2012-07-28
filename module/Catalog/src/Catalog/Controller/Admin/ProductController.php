<?php

namespace Catalog\Controller\Admin;

use ZendStore\Controller\AbstractAdminActionController;
use Catalog\Model\ProductJoinedRow;
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
	 * @var ProductJoinedTable
	 */
	protected $productJoinedTable;
	
	public function indexAction()
	{
		$productJoinedRows = $this->getProductJoinedTable()->getProductJoinedRows(); 
		$viewModel = $this->getViewModel();
		$viewModel->setVariables(array(
			'products' => $productJoinedRows,
		));
		
		return $viewModel;
	}
	
	public function addAction()
	{
		$productJoinedRow = new ProductJoinedRow();
		$form = new ProductForm();
		//$form->bind($joinedProduct);
		
		if ($this->request->isPost()) {
			$data = array_merge($this->request->getPost()->toArray(), array(
				'created_date' => time(),
				'updated_date' => time(), 	
			));
			$productJoinedRow->exchangeArray($data);
			$this->getProductJoinedTable()->saveProductJoined($productJoinedRow);
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
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		if ($id) { 	// Add
			$productJoinedRow = new ProductJoinedRow();
		} else {	// Edit
			$productJoinedRow = $this->getProductJoinedTable()->getProductJoinedRow($id);			
		}
		
		$form = new ProductForm();
		$form->bind($productJoinedRow);
		
		if ($this->request->isPost()) {
			$form->setData($this->request->getPost());
			if ($form->isValid()) {
				$this->getProductJoinedTable()->saveProductJoinedRow($productJoinedRow);
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
	 * @return ProductJoinedTable
	 */
	public function getProductJoinedTable()
	{
		if (! $this->productJoinedTable instanceof ProductJoinedTable) {
			$sm = $this->getServiceLocator();
			$this->productJoinedTable = $sm->get('Catalog\Model\ProductJoinedTable');
		}
		return $this->productJoinedTable;
	}
}