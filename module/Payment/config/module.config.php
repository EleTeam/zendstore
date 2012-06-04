<?php

return array(

    // Controllers in this module
    'controller' => array(
        'classes' => array(
            'payment/payment' => 'Payment\Controller\PaymentController',
        ),
    ),

    // Routes for this module
    'router' => array(
        'routes' => array(
            'payment' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/payment[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id'     => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'payment/payment',
                        'action'     => 'index',
                    ),
                ),
            ),
        ),
    ),    

    // View setup for this module
    'view_manager' => array(
        'template_path_stack' => array(
            'payment' => __DIR__ . '/../view',
        ),
    ),
);
