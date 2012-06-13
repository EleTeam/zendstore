<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'user/user' => 'User\Controller\UserController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'region' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/user[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'user/user',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);
