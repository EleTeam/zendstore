<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'admin/user/user' 	=> 'User\Controller\Admin\UserController',
        	'front/user/user' 	=> 'User\Controller\Front\UserController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'admin-user-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/admin/user/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'admin/user/user',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'front-user-user' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => '/front/user/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'front/user/user',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'user' => __DIR__ . '/../view',
        ),
    ),
);
