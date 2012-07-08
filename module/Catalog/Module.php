<?php

namespace Catalog;

use Catalog\Model\CategoryTable;
use	Catalog\Model\ProductTable;
use Catalog\Widget\Product\ProductWidget;

class Module
{
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
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
    			'category-table' => function($sm) {
	    			$dbAdapter = $sm->get('db-adapter');
	    			return new CategoryTable($dbAdapter);
    			},
    			'product-table' => function($sm) {
	    			$dbAdapter = $sm->get('db-adapter');
	    			return new ProductTable($dbAdapter);
    			},
    			'product-widget' => function($sm) {
    				return new ProductWidget();
    			},
    		),
    	);
    }
}
