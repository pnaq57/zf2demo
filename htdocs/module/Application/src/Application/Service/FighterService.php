<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Application\Service;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
use Zend\ServiceManager\ServiceLocatorAwareInterface;
use Doctrine\ORM\Tools\Pagination\Paginator;
/**
 * Description of FileService
 *
 * @author aqnguyen
 */
class FighterService implements 
    EventManagerAwareInterface,
    ServiceLocatorAwareInterface
{
    
    protected $db;
    
    protected $serviceLocator;
        
    function getDb()
    {
        return $this->db;
    }

    function setDb($db)
    {
        $this->db = $db;
    }
    public function chechFighterExist(array $fighterIds)
    {
        $ids = array();
        if (count($fighterIds) > 0) {
            foreach ($fighterIds as $id) {
                if ((int)$id > 0) {
                    $fighter = $this->getFighter($id);
                    if (!$fighter) {
                        return false;
                    }
                } else {
                    return false;
                }
            }
            return true;
        }
        return false;        
    }
    
    
    public function checkFighterInOtherTable($id)
    {
        $selectSql =
            'SELECT f.id fighter_id, sff.sf_id sende_file_id, af.id archive_file_id FROM fighter f'
            . ' LEFT JOIN sf_fighter sff ON f.id = sff.fighter_id'
            . ' LEFT JOIN archive_files af ON af.fighter_a = f.id OR af.fighter_b = f.id'
            . ' WHERE f.id = ' . (int)$id 
            . ' LIMIT 1';        
        $conn = $this->db->getConnection();
        return $conn->query($selectSql)->fetch();
    }
    
    
    public function getFighters($val = null, $limit = 9999)
    {
        $qb = $this->db->createQueryBuilder();
        $qb->select('f')
            ->from('Application\Entity\Fighter', 'f')
            ->setMaxResults($limit);
        if (!empty($val)) {
            $qb->where('f.firstname LIKE :firstname')
                ->orWhere('f.lastname LIKE :lastname')
                ->orWhere('f.fullname LIKE :fullname')
                ->orWhere('f.lastnameShortcut LIKE :lastnameShortcut')
                ->setParameter('firstname', $val . '%')
                ->setParameter('lastname', $val . '%')
                ->setParameter('fullname', $val . '%')
                ->setParameter('lastnameShortcut', $val . '%');
            
                
        }
     //   echo  $qb->getQuery()->getSql();die;
        $fighters = $qb->getQuery()->getResult();

        return $fighters;
    }
    
    public function getPagedFighters($offset = 0, $limit = 20)
    {
        $query = $this->db->getRepository('Application\Entity\Fighter')
            ->createQueryBuilder('f');
        $query->where('f.deleted = 0');
        $query->orderBy('f.id')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
//echo  $query->getQuery()->getSql(); 
        $query = $query->getQuery();

        $paginator = new Paginator( $query );

        return $paginator;
    }
    
    public function getFighter($id)
    {
        return $this->db->find('Application\Entity\Fighter', $id);
    }
    
    
    public function save($fighter)
    {
        $this->db->persist($fighter);
        $this->db->flush();
    }

    public function getEventManager()
    {
        
    }

    public function setEventManager(EventManagerInterface $eventManager)
    {
        
    }

    public function getServiceLocator()
    {
        return $this->serviceLocator;
    }

    public function setServiceLocator(\Zend\ServiceManager\ServiceLocatorInterface $serviceLocator)
    {
        $this->serviceLocator = $serviceLocator;
    }

//put your code here
}
