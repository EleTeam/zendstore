<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'admin/demo/demo'	=> 'Demo\Controller\Admin\DemoController',
        	'admin/demo/test'	=> 'Demo\Controller\Admin\TestController',
        	'front/demo/demo' 	=> 'Demo\Controller\Front\DemoController',
        	'front/demo/test' 	=> 'Demo\Controller\Front\TestController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
        	'admin-demo-demo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/demo/demo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'admin/demo/demo',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'admin-demo-test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/admin/demo/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'admin/demo/test',
                    	'action'	 => 'index',
                    ),
                ),
            ),
            'front-demo-demo' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/front/demo/demo[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'front/demo/demo',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'front-demo-test' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/front/demo/test[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => '/front/demo/test',
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
