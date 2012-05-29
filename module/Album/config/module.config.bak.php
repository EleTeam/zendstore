<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'album' => 'Album\Controller\AlbumController',
            ),
        	'Album\Controller\AlbumController' => array(
        		'parameters' => array(
        			'albumTable' => 'Album\Model\AlbumTable',	
        		),	
        	),
        	'Album\Model\AlbumTable' => array(
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
                        'Album' => __DIR__ . '/../view',
                    ),
                ),
            ),
        		
        	// Routes
        	'Zend\Mvc\Router\RouteStack' => array(
        		'parameters' => array(
        			'routes' => array(
        				'album' => array(
        					'type' => 'Zend\Mvc\Router\Http\Literal',
        					'options' => array(
        						'route' => '/album',
        						'defaults' => array(
        							'controller' => 'Album\Controller\AlbumController',
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