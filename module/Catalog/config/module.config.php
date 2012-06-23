<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'catalog/category' 		=> 'Catalog\Controller\CategoryController',
        	'catalog/product' 		=> 'Catalog\Controller\ProductController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/category',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/product',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'catalog' => __DIR__ . '/../view',
        ),
    ),
);
