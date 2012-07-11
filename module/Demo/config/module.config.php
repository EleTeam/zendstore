<?php

return array(
    // Controllers in this module
    'controllers' => array(
        'invokables' => array(
        	'demo\front\demo' 	=> 'Demo\Controller\Front\DemoController',
        	'demo\front\test' 	=> 'Demo\Controller\Front\TestController',
            'demo\admin\demo'	=> 'Demo\Controller\Admin\DemoController',
        	'demo\admin\test'	=> 'Demo\Controller\Admin\TestController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'demo-front-demo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/demo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'demo\front\demo',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'demo-front-test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/demo/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => '/demo\front\test',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'demo-admin-demo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/demo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'demo\admin\demo',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'demo-admin-test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/demo/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'demo\admin\test',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'demo' => __DIR__ . '/../view',
        ),
    ),
);
