<?php
namespace FileUpload\Service;


use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
/**
 * Description of FileUploadService
 *
 * @author aqnguyen
 */
class FileUploadService implements 
    EventManagerAwareInterface,
    ServiceLocatorAwareInterface
{
    
    protected $db;
    
    public function getUploadPath()
    {
        return '/var/storage/';
    }
    
    public function getRelPath()
    {
        return '/data/file-upload/';
    }
    
    public function getUploadTempPath()
    {
        return ROOT_PATH . '/data/file-upload-temp/';
    }
    
    public function getUploadFiles($by = array(), $orderBy = array('id' => 'DESC'))
    {
        $fileRepository = $this->db->getRepository('FileUpload\Entity\File');
        $files = $fileRepository->findBy($by, $orderBy);
        return $files;
    }
    
    
    
    
    
    public function getDb()
    {
        return $this->db;
    }

    public function setDb($db)
    {
        $this->db = $db;
    }

        
    public function getEventManager()
    {
        
    }

    public function getServiceLocator()
    {
        
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        
    }

//put your code here
}
