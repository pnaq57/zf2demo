<?php
namespace AppApi\Service;
use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;

class L10nService implements EventManagerAwareInterface
{
    protected $doctrineEntityManager;
    

    public function getCurrentVersionByTable($table)
    {
        $selectSql = ' SELECT * FROM l10n_index WHERE locate = "' . $table . '"' ;
        
        $conn = $this->doctrineEntityManager->getConnection();
        $result = $conn->query($selectSql)->fetchAll();
        return $result;

    }
    
    public function getAllTranslationFromTable($table, $version = null)
    {
        $selectSql = 'SELECT * FROM l10n_'. $table;
        if ($version) {
            $selectSql .= ' WHERE version > ' . $version;
        }
        $conn = $this->doctrineEntityManager->getConnection();
        $result = $conn->query($selectSql)->fetchAll();
        return $result;

    }
    
    public function getDoctrineEntityManager()
    {
        return $this->doctrineEntityManager;
    }

    public function setDoctrineEntityManager($doctrineEntityManager)
    {
        $this->doctrineEntityManager = $doctrineEntityManager;
    }

    /**
     * Constructor
     * 
     */
    public function __construct($doctrineManager)
    {
        $this->setDoctrineEntityManager($doctrineManager);
    }
    
    
    public function getEventManager()
    {
        
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        
    }
    
}
