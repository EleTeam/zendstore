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