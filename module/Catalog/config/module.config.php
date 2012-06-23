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
            'catalog-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/catalog/category[/:action][/:id]',
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
        	'catalog-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/catalog/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/product',
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
