<?php

namespace Album;

return array(
    'controllers' => array(
        'invokables' => array(
            'Album\Controller\Front\Album' => 'Album\Controller\Front\AlbumController',
        ),
    ),
    
    'router' => array(
        'routes' => array(
            'album-front-album' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/album[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Album\Controller\Front\Album',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),

    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
		
	// Doctrine config
    'doctrine' => array(
    	'driver' => array(
    		__NAMESPACE__ . '_driver' => array(
    			'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',	
    			//'cache' => 'array',
    			'cache' => false,
    			'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity'),
    		),		
    	),
    	'orm_default' => array(
    		'drivers' => array(
    			__NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',	
    		),		
    	),	
    ),
		
);