<?php

namespace Catalog\Controller\Admin;

use Base\Controller\Admin\AdminActionController,
	Catalog\Model\ProductTable,
	Catalog\Model\Product,
	Catalog\Form\ProductForm;

class ProductController extends AdminActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	public function viewAction()
	{
		$viewModel = $this->getViewModel(__METHOD__);
		
		return $viewModel;
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
		$viewModel = $this->getViewModel(__METHOD__);
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