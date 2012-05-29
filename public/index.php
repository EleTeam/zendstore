<?php
use Zend\Loader\AutoloaderFactory,
    Zend\ServiceManager\ServiceManager,
    Zend\Mvc\Service\ServiceManagerConfiguration;

chdir(dirname(__DIR__));
require_once (getenv('ZF2_PATH') ?: __DIR__ . '/../../zf2/library') . '/Zend/Loader/AutoloaderFactory.php';

// Setup autoloader
AutoloaderFactory::factory();

// Get application stack configuration
$configuration = include 'config/application.config.php';

// Setup service manager
$serviceManager = new ServiceManager(new ServiceManagerConfiguration($configuration['service_manager']));
$serviceManager->setService('ApplicationConfiguration', $configuration);
$serviceManager->get('ModuleManager')->loadModules();

// Run application
$serviceManager->get('Application')->bootstrap()->run()->send();
