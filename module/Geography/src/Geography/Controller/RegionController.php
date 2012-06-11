<?php

namespace Geography\Controller;

use Zend\Mvc\Controller\ActionController,
	Zend\View\Model\ViewModel,
	Zend\Json\Json,
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
		$regionTable = $this->getRegionTable();
		$regions = $regionTable->getChildren($id);
		
		$result = new \stdClass();
		$result->done = true;
		$result->msg  = "";
		$result->retval = $regions->toArray();
		//var_dump($regions);exit;
		
		echo Json::encode($result);
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