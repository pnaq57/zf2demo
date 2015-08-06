<?php

return array(
    'doctrine' => array(
        'driver' => array(
            'fileupload_entities' => array(
                'class' =>'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/FileUpload/Entity')
            ),

            'orm_default' => array(
                'drivers' => array(
                    'FileUpload\Entity' => 'fileupload_entities'
                )
            )
        )
    ),
    
    
    'router' => array(
        'routes' => array(
            // The following is a route to simplify getting started creating
            // new controllers and actions without needing to create a new
            // module. Simply drop new controllers in, and you can access them
            // using the path /application/:controller/:action
            'file-upload' => array(
                'type'    => 'segment',
                'options' => array(
                    'route'    => '/file-upload[/:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'FileUpload\Controller\FileUpload',
                        'action' => 'index'
                    ),
                ),
            ),
        ),
    ),
    'service_manager' => array(
        'factories'  => array(
            'FileUpload\Service\FileUpload'   => 'FileUpload\Service\FileUploadServiceFactory',
        ),
    ),
   

    'controllers' => array(
        'factories' => array(
            'FileUpload\Controller\FileUpload' => 'FileUpload\Controller\FileUploadControllerFactory',
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            __DIR__ . '/../view',
        ),
    ),
    // Placeholder for console routes
    'console' => array(
        'router' => array(
            'routes' => array(
            ),
        ),
    ),
);
