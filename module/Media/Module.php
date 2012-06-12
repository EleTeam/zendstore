<?php

namespace Media;

use Media\Model\UploadedFileTable;

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
    			'UploadedFileTable' => function($sm) {
    				return new UploadedFileTable($sm->get('db-adapter'));
    			},	
    		),	
    	);
    }
}
