<?php

namespace Geography\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Geography\Model\RegionTable;

class RegionController extends ActionController
{
	/**
	 * @var \Geography\Model\RegionTable
	 */
	protected $regionTable;
	
	public function indexAction()
	{
		return new ViewModel(array(
			'regions' => $this->getRegionTable()->getChildren(0),	
		));
	}

	/**
	 * List sub-regions
	 * 
	 * @method ajax
	 */
	public function listChildrenAction()
	{
		$id = $this->getEvent()->getRouteMatch()->getParam('id');
		$request = $this->getRequest();
		echo 'id = ' . $id;
		exit;
	}
	
	/**
	 * @return \Geography\Model\RegionTable
	 */
	private function getRegionTable()
	{
		if (!$this->regionTable) {
			$sm = $this->getServiceLocator();
			$this->regionTable = $sm->get('region-table');
		}
		return $this->regionTable;
	}
}