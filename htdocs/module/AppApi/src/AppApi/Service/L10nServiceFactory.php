<?php
namespace AppApi\Service;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;

class L10nServiceFactory  implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db   = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $service = new L10nService($db);
        return $service;
    }
}
{
    //put your code here
}
