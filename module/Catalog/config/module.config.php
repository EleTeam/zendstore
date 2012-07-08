<?php

return array(
    // Controllers in this module
    'controllers' => array(
        'invokables' => array(
        	'catalog\front\category' 	=> 'Catalog\Controller\Front\CategoryController',
        	'catalog\front\product' 	=> 'Catalog\Controller\Front\ProductController',
            'catalog\admin\category' 	=> 'Catalog\Controller\Admin\CategoryController',
        	'catalog\admin\product' 	=> 'Catalog\Controller\Admin\ProductController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
        	'catalog-front-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => 'catalog/front/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog\front\product',
                    ),
                ),
            ),
        	'catalog-admin-category' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'		  => '/admin/catalog/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog\admin\category',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'catalog-admin-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'		  => '/admin/catalog/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog\admin\product',
                    	'action'	 => 'index',
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
