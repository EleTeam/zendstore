<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'media/uploader' => 'Media\Controller\UploaderController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'uploader' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/uploader[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'media/uploader',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'media' => __DIR__ . '/../view',
        ),
    ),
);
