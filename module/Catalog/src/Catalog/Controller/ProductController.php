<?php

namespace Catalog\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Product\Model\ProductTable,
	Product\Form\ProductForm;

class ProductController extends ActionController
{
	/**
	 * @var ProductTable
	 */
	protected $productTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
			//'products' => $this->productTable->fetchAll()		
		));
	}	
	
	public function addAction()
	{
		$form = new ProductForm();
		//$form->submit->setLabel('Add');
		
		$request = $this->getRequest();
		if ($request->isPost()) {
			$formData = $request->post()->toArray();
			if ($form->isValid($formData)) {
				$artist = $form->getValue('artist');
				$title = $form->getValue('title');
				$this->productTable->addProduct($artist, $title);

				return $this->redirect()->toRoute('default', array(
					'controller' => 'product',
					'action'	 => 'index',
				));
			}
		}
		
		return array('form' => $form);
	}
	
	public function editAction()
	{
		$request = $this->getRequest();
		$id = $request->query()->get('id', 0);
		$form = new ProductForm();
		
		if (!$request->isPost()) {
			$product = $this->productTable->getProduct($id);
			$form->populate($product->getArrayCopy());
			return array('form' => $form);
		} else {
			$formData = $request->post()->toArray();
			if ($form->isValid($formData)) {
				$id		= $form->getValue('id');
				$artist = $form->getValue('artist');
				$title  = $form->getValue('title');
				$this->productTable->updateProduct($id, $artist, $title);
				return $this->redirect()->toRoute('default', array(
					'controller' => 'product',
					'action'	 => 'index',	
				));
			}
		}
	}
	
	public function deleteAction()
	{
		$request = $this->getRequest();
		
		if (!$request->isPost()) {
			$id = $request->query()->get('id', 0);
			$product = $this->productTable->getProduct($id);
			return array('product' => $product);
		} else {
			$id = $request->post()->get('id');
			$this->productTable->deleteProduct($id);
			
			return $this->redirect()->toRoute('default', array(
				'controller' => 'product',
				'action'	 => 'index',	
			));
		}
	}
	
	public function setProductTable(ProductTable $productTable)
	{
		$this->productTable = $productTable;
		return $this;
	}
}