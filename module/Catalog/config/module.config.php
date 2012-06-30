<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
        	'catalog/front/category' 	=> 'Catalog\Controller\Front\CategoryController',
        	'catalog/front/product' 	=> 'Catalog\Controller\Front\ProductController',
            'catalog/admin/category' 	=> 'Catalog\Controller\Admin\CategoryController',
        	'catalog/admin/product' 	=> 'Catalog\Controller\Admin\ProductController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
<<<<<<< HEAD
            'catalog-front-category' => array(
=======
        	'catalog-admin-category' => array(
>>>>>>> 5ede1f9dca808e50dcc8265a0f1fb676a041fe07
                'type'    => 'segment',
                'options' => array(
                    'route'    	  => '/catalog/front/category[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/front/category',
                        'action'     => 'index',
                    ),
                ),
            ),
        	'catalog-front-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'       => 'catalog/front/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/front/product',
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
                        'controller' => 'catalog/admin/category',
                    	'action'	 => 'index',
                    ),
                ),
            ),
        	'catalog-admin-product' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'		  => '/catalog/admin/product[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z]+',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'catalog/admin/product',
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
