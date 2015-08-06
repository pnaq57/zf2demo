<?php
return array(
    'router' => array(
        'routes' => array(
            'file-api' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/api/files[/:id][/:status]',
                    'constraints' => array(
                        'id' => '[a-zA-Z0-9_-]*',
                        'status' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'AppApi\Controller\File',
                    ),
                ),
            ),
        ),
    ),
    'controllers' => array(
        'invokables' => array(
            'AppApi\Controller\Index' => 'AppApi\Controller\IndexController'            
        ),
        'factories' => array(
            'AppApi\Controller\File' => 'AppApi\Controller\FileControllerFactory'
        )
    ),
    
    'service_manager' => array(
        'factories'  => array(
            'AppApi\Service\L10n'   => 'AppApi\Service\L10nServiceFactory',
        ),
    ),
    'view_manager' => array(
        'strategies' => array(
            'ViewJsonStrategy',
        ),
    ),
);