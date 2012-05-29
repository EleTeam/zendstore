<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'product' => 'Product\Controller\ProductController',
            ),
        	'Product\Controller\ProductController' => array(
        		'parameters' => array(
        			'productTable' => 'Product\Model\ProductTable',	
        		),	
        	),
        	'Product\Model\ProductTable' => array(
        		'parameters' => array(
        			'adapter' => 'Zend\Db\Adapter\Adapter',	
        		),	
        	),
        	'Zend\Db\Adapter\Adapter' => array(
        		'parameters' => array(
        			'driver' => array(
        				'driver' => 'Pdo',
        				'dsn' => 'mysql:hostname=127.0.0.1;dbname=zendmall',
        				'username' => 'zendmall',
        				'password' => '123456',	
        			),	
        		),	
        	),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'Product' => __DIR__ . '/../view',
                    ),
                ),
            ),
        		
        	// Routes
        	'Zend\Mvc\Router\RouteStack' => array(
        		'parameters' => array(
        			'routes' => array(
        				'product' => array(
        					'type' => 'Zend\Mvc\Router\Http\Literal',
        					'options' => array(
        						'route' => '/product',
        						'defaults' => array(
        							'controller' => 'Product\Controller\ProductController',
        							'action'	 => 'index',
        						),	
        					),	
        					'child_routes' => array(
        						'index' => array(
		        					'type' => 'Zend\Mvc\Router\Http\Literal',
		        					'options' => array(
		        						'route' => '/',
		        						'defaults' => array(
		        							'action' => 'index',	
		        						),	
		        					),
		        				),
        						'add' => array(
		        					'type' => 'Zend\Mvc\Router\Http\Literal',
		        					'options' => array(
		        						'route' => '/add',
		        						'defaults' => array(
		        							'action' => 'add',	
		        						),	
		        					),
		        				),
        					),
        				),
        			),	
        		),	
        	),
        	// End of Routes
        		
        ),
    ),
);
