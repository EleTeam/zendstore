<?php

namespace Geography;

use Geography\Model\RegionTable;

class Module
{
	/**
	 * @return array
	 */
    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
    
    /**
     * @return array
     */
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
    
    /**
     * @return array
     */
    public function getServiceConfiguration()
    {
		return array(
			'factories' => array(
				'region-table' => function($sm) {
					$dbAdapter = $sm->get('db-adapter');
					$table = new RegionTable($dbAdapter);
					return $table;
				},	
			),	
		);    	
    }
}
