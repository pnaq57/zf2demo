<?php
namespace Application\Controller;


use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
use Zend\Stdlib\DispatchableInterface;

/**
 * Description of FileControllerFactory
 * @author aqnguyen
 */
class FileControllerFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $sm         = $serviceLocator->getServiceLocator();
        $service    = $sm->get('Application\Service\File');
        $controller = new FileController();
        $controller->setArchiveFileService($service);
        
        $fighterService    = $sm->get('Application\Service\Fighter');
        $controller->setFighterService($fighterService);
        return $controller;
    }
}