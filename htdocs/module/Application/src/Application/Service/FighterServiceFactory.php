<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Service;
use Zend\ServiceManager\FactoryInterface;
use Zend\ServiceManager\ServiceLocatorInterface;
/**
 * Description of FileServiceFactory
 *
 * @author aqnguyen
 */
class FighterServiceFactory implements FactoryInterface
{
    /**
     * Create Service Factory
     * 
     * @param ServiceLocatorInterface $serviceLocator
     */
    public function createService(ServiceLocatorInterface $serviceLocator)
    {
        $db   = $serviceLocator->get('doctrine.entitymanager.orm_default');
        $service = new FighterService();
        $service->setDb($db);
        return $service;
    }
}