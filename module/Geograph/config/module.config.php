<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'geography/geography' => 'Geograph\Controller\GeographController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'geography' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/geography[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'geography/geography',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'geography' => __DIR__ . '/../view',
        ),
    ),
);
