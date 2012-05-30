<?php
// Error handling
error_reporting(E_ALL | E_STRICT); 						// Development
//error_reporting(E_ALL & ~E_DEPRECATED & ~E_NOTICE); 	// Production

define('ROOT_PATH', dirname(__DIR__));

chdir(ROOT_PATH);

//require_once (getenv('ZF2_PATH') ?: 'vendor/ZendFramework/library') . '/Zend/Loader/AutoloaderFactory.php';
require_once (getenv('ZF2_PATH') ?: __DIR__ . '/../../zf2/library') . '/Zend/Loader/AutoloaderFactory.php';

use Zend\Loader\AutoloaderFactory,
Zend\ServiceManager\ServiceManager,
Zend\Mvc\Service\ServiceManagerConfiguration;

// setup autoloader
AutoloaderFactory::factory();

// get application stack configuration
$configuration = include 'config/application.config.php';

// setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
$serviceManager->setService('ApplicationConfiguration', $configuration);
$serviceManager->get('ModuleManager')->loadModules();

// run application
$serviceManager->get('Application')->bootstrap()->run()->send();
