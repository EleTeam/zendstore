<?php

namespace Demo;

use Catalog\Model\ProductTable,
	Demo\Widget\Demo\DemoWidget;

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
    			'product-table' => function($sm) {
	    			$dbAdapter = $sm->get('db-adapter');
	    			return new ProductTable($dbAdapter);
    			},
    			'demo-widget' => function($sm) {
                    return new DemoWidget();
    			},
    		),
    	);
    }
}
