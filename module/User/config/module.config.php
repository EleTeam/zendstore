<?php

return array(

    // Controllers in this module
//     'controllers' => array(
//         'invokables' => array(
//             'user/admin/user' 	=> 'User\Controller\Admin\UserController',
//         	'user/front/user' 	=> 'User\Controller\Front\UserController',
//         ),
//     ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'user-admin-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/admin/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'user\admin\user',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'user-front-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'user/front/user',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

		'controllers' => array(
				'invokables' => array(
						'user\admin\user' 		=> 'User\Controller\Admin\UserController',
						'application\admin\dashboard' 	=> 'Application\Controller\Admin\DashboardController',
				),
		),
		
    // View setup for this module
    'view_manager' => array(        
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),
);
