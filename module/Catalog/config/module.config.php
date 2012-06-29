<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'admin/catalog/category' 	=> 'Catalog\Controller\Admin\CategoryController',
        	'admin/catalog/product' 	=> 'Catalog\Controller\Admin\ProductController',
        	'front/catalog/category' 	=> 'Catalog\Controller\Front\CategoryController',
        	'front/catalog/product' 	=> 'Catalog\Controller\Front\ProductController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
        	'catalog-admin-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'		  => '/admin/catalog/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'admin/catalog/category',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'admin-catalog-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'		  => '/admin/catalog/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'admin/catalog/product',
                    ),
                ),
            ),
            'front-catalog-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    	  => '/front/catalog/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'front/catalog/category',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'front-catalog-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => 'front/catalog/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'front/catalog/product',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array('template_map' => array(
			'widget/product' => __DIR__ . '/../src/Catalog/Widget/Product/template.phtml',
		),
        'template_path_stack' => array(
            'catalog' => __DIR__ . '/../view',
        ),
    ),
);
