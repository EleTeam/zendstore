<?php

namespace Catalog;

use Catalog\Model\CategoryTable;
use	Catalog\Model\ProductTable;
use Catalog\Widget\Product\ProductWidget;

class Module
{
    public function getAutoloaderConfig()
    {
    	return array(
    		'Zend\Loader\ClassMapAutoloader' => array(
    			__DIR__ . '/autoload_classmap.php',
    		),
    		'Zend\Loader\StandardAutoloader' => array(
    			'namespaces' => array(
  				__NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
    			),
    		),
    	);
    }

	public function getServiceConfiguration()
    {
    	return array(
    		'factories' => array(    			
    			'Catalog\Model\CategoryTable' => function($sm) {
	    			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	    			return new CategoryTable($dbAdapter);
    			},
    			'Catalog\Model\ProductTable' => function($sm) {
	    			$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
	    			return new ProductTable($dbAdapter);
    			},
    			'Catalog\Model\ProductWidget' => function($sm) {
    				return new ProductWidget();
    			},
    		),
    	);
    }
    
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
}
