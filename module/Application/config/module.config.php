<?php
/**
 * "controller" field below must following by "routes", otherwise
 * it can't find the routed controllers.
 */
return array(
    'router' => array(
        'routes' => array(
            'application-front-index' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/',
                    'defaults' => array(
                        'controller' => 'application/front/index',
                        'action'     => 'index',
                    ),
                ),
            ),            
        	'application-admin-dashboard' => array(
                'type' => 'Zend\Mvc\Router\Http\Literal',
                'options' => array(
                    'route'    => '/admin',
                    'defaults' => array(
                        'controller' => 'application/admin/dashboard',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),
	
    'controller' => array(
        'classes' => array(
            'application/front/index' 	  => 'Application\Controller\Front\IndexController',
        	'application/admin/dashboard' => 'Application\Controller\Admin\DashboardController',
        ),
    ),
		
    'view_manager' => array(
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => array(
//             'layout/layout' 		=> __DIR__ . '/../view/layout/layout.phtml',
//             'layout/front/default' 	=> __DIR__ . '/../view/layout/front/default.phtml',
//             'layout/admin/default' 	=> __DIR__ . '/../view/layout/admin/default.phtml',
            'index/index'   => __DIR__ . '/../view/index/index.phtml',
            'error/404'     => __DIR__ . '/../view/error/404.phtml',
            'error/index'   => __DIR__ . '/../view/error/index.phtml',
        ),
        'template_path_stack' => array(
            'application' => __DIR__ . '/../view',
        ),
    ),
);
