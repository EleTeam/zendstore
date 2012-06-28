<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'album/front/album' => 'Album\Controller\Front\AlbumController'
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'album-front-album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'album/front/album',
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
