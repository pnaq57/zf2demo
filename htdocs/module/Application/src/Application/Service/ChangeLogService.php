<?php
namespace Application\Service;

use Zend\EventManager\EventManagerAwareInterface;
use Zend\EventManager\EventManagerInterface;
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of ChangeLogService
 *
 * @author aqnguyen
 */
class ChangeLogService implements EventManagerAwareInterface
{
    protected $doctrineEntityManager;
    
    public function getChangeLogs()
    {
        $selectSql = ' SELECT * FROM changelog';
        
        $conn = $this->doctrineEntityManager->getConnection();
        $result = $conn->query($selectSql)->fetchAll();
        return $result;
        $logs = array();
        foreach ($result as $row) {

        }
        return $groups;
    }
    
    public function getProjects()
    {
        $selectSql = 'SELECT * FROM projects';
        
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->query($selectSql)->fetchAll();
    }
    
    public function getChangeLogsByProjectId($id)
    {
        $selectSql = 'SELECT *, c.id changeLogId FROM projects p LEFT JOIN changelog c ON p.id = c.projectId WHERE p.id = ' . $id . ' ORDER BY c.id DESC LIMIT 100';
        
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->query($selectSql)->fetchAll();
    }
    
    public function getChangeLogsWithProjectById($id)
    {
        $selectSql = 'SELECT *, c.id changeLogId FROM changelog c INNER JOIN projects p ON p.id = c.projectId WHERE c.id = ' . $id . ' LIMIT 1';        
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->query($selectSql)->fetchAll();
    }
    
    public function updateChangelog($id, $data)
    {
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->update('changelog', $data, array('id' => $id));
    }
    
    public function removeChangelog($id)
    {
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->delete('changelog', array('id' => $id));
    }
    public function createChangelog($data)
    {
        $conn = $this->doctrineEntityManager->getConnection();
        return $conn->insert('changelog', $data);
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
    
    public function getAllUserGroup()
    {
        $selectSql = '
            SELECT * 
            FROM fe_groups
            WHERE 
                deleted = 0
                AND hidden = 0
                AND (title <> "Deleted" AND title <> "Developer" AND title <> "Team")';
        
        $conn = $this->doctrineEntityManager->getConnection();
        $result= $conn->query($selectSql)->fetchAll();
        $groups = array();
        foreach ($result as $row) {
            $groups[$row['uid']] = $row['title'];
        }
        return $groups;
    }
    
    public function getUsersByRole($role = null)
    {
        $selectSql = '
            SELECT username, email, last_name, first_name
            FROM fe_users
            WHERE 
                deleted = 0';
        if ((int)$role > 0) {
            $selectSql .= ' AND (usergroup LIKE "' . $role . ',%" OR usergroup LIKE "%,' . $role . ',%" OR usergroup LIKE "%,' . $role . '")';
        }
                
        
        $conn = $this->doctrineEntityManager->getConnection();
        $result= $conn->query($selectSql)->fetchAll();
        return $result;
    }
    
    public function getUsersByLaunchEvent()
    {
        $selectSql = '
            SELECT username, email
            FROM ipm_event_emails';                
        
        $conn = $this->doctrineEntityManager->getConnection();
        $result= $conn->query($selectSql)->fetchAll();
        return $result;
    }

}
