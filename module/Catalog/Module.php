<?php

namespace Catalog;

use //Zend\Form\View\HelperLoader as FormHelperLoader,
	Catalog\Model\ProductTable;

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
    			'product-table' => function($sm){
	    			$dbAdapter = $sm->get('db-adapter');
	    			return new ProductTable($dbAdapter);
    			}
    		),
    	);
    }
}
