<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Catalog\Model\ProductTable,
	Catalog\Model\Product,
	Catalog\Form\ProductForm;

class ProductController extends ActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	public function viewAction()
	{
		return new ViewModel(array(
			//'products' => $this->productTable->fetchAll()		
		));
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
				$product->populate($$formData);
				$this->getProductTable()->saveProduct($product);

				return $this->redirect()->toRoute('catalog-product', array(
					'action'	 => 'view',
				));
			}
		}
		
		return array('form' => $form);
	}
	
	/**
	 * Get an instance of ProductTable
	 *
	 * @return ProductTable
	 */
	public function getProductTable()
	{
		if (!$this->ProductTable) {
			$sm = $this->getServiceLocator();
			$this->ProductTable = $sm->get('product-table');
		}
		return $this->ProductTable;
	}
}