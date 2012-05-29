<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'base/base' => 'Base\Controller\BaseController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'base' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/base[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'base/base',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'base' => __DIR__ . '/../view',
        ),
    ),
);
