<?php
namespace FileUpload\Controller;

use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\DispatchableInterface;

/**
 * Description of FileControllerFactory
 *
 * @author aqnguyen
 */
class FileUploadControllerFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm         = $serviceLocator->getServiceLocator();
        $service    = $sm->get('FileUpload\Service\FileUpload');
        $fileService = $sm->get('Application\Service\File');
        
        $controller = new FileUploadController();
        $controller->setFileUploadService($service);
        $controller->setFileService($fileService);
        return $controller;
    }
}