<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'user' => 'User\Controller\UserController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'User' => __DIR__ . '/../view',
                    ),
                ),
            ),
        		
        	// Routes
        	'Zend\Mvc\Router\RouteStack' => array(
        		'parameters' => array(
        			'routes' => array(
        				'user' => array(
        					'type' => 'Zend\Mvc\Router\Http\Literal',
        					'options' => array(
        						'route' => '/user',
        						'defaults' => array(
        							'controller' => 'User\Controller\UserController',
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
        						'test' => array(
		        					'type' => 'Zend\Mvc\Router\Http\Literal',
		        					'options' => array(
		        						'route' => '/test',
		        						'defaults' => array(
		        							'action' => 'test',	
		        						),	
		        					),
		        				),
        					)
        				),
        			),	
        		),	
        	),
        	// End of Routes
        		
        ),
    ),
);
