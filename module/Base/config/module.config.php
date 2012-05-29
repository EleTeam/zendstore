<?php
return array(
    'di' => array(
        'instance' => array(
            'alias' => array(
                'base' => 'Base\Controller\BaseController',
            ),
            'Zend\View\Resolver\TemplatePathStack' => array(
                'parameters' => array(
                    'paths'  => array(
                        'base' => __DIR__ . '/../view',
                    ),
                ),
            ),
        		
        	// Routes
        	'Zend\Mvc\Router\RouteStack' => array(
        		'parameters' => array(
        			'routes' => array(
        				'base' => array(
        					'type' => 'Zend\Mvc\Router\Http\Literal',
        					'options' => array(
        						'route' => '/base',
        						'defaults' => array(
        							'controller' => 'Base\Controller\BaseController',
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
        					),
        				),
        			),	
        		),	
        	),
        	// End of Routes
        		
        ),
    ),
);
