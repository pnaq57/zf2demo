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
class FileService implements 
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

    public function createArchiveFile($data)
    {
        try {
            $archiveFileEntity = new \Application\Entity\ArchiveFile();
            if (!is_array($data)) {
                $data = $data->toArray();
            }
            $fighterA = $this->getFighterService()->getFighter($data['fighter_a']);
            $fighterB = $this->getFighterService()->getFighter($data['fighter_b']);
            unset($data['fighter_b']);
            unset($data['fighter_a']);
            $data['status'] = 'New';
            $archiveFileEntity->setFighterA($fighterA);
            $archiveFileEntity->setFighterB($fighterB);
            $archiveFileEntity->setRawData($data);
            $archiveFileEntity->validateData();
            $fileIndex = new \Application\Entity\FileIndex();
            $fileIndex->setStatus($archiveFileEntity->getStatus());
            $fileIndex->setType('archive');
            $this->db->persist($fileIndex);
            $this->db->flush($fileIndex);
             
            $archiveFileEntity->setFileIndex($fileIndex);
            $archiveFileEntity->setStorage($this->getAvailableStorage());
            $this->db->persist($archiveFileEntity);
            $this->db->flush();
            /*
            $fileName = 'AF' . sprintf('%010d', (int)$archiveFileEntity->getId());
            $archiveFileEntity->setName($fileName);
            $archiveFileEntity->setPath('examplePath/' . $fileName);
            $this->db->persist($archiveFileEntity);
             * 
             */
            $archiveFileId = $archiveFileEntity->getId();
            $fileName = $archiveFileEntity->getId() . '_' . $archiveFileEntity->getSource()
                . '_' . $fighterA->getLastnameShortcut() . '_' . $fighterB->getLastnameShortcut();
            $fileName = strtolower($fileName);
            $archiveFileEntity->setName($fileName);

            if (isset($data['actions'])) {
                foreach ($data['actions'] as $action) {
                    $actionObj = new \Application\Entity\Tape();
                    $actionObj->setFkId($archiveFileId);
                    $actionObj->setAction($action['action']);
                    $actionObj->setActionFrom($action['action_from']);
                    $actionObj->setArchiveFile($archiveFileEntity);
                    $this->db->persist($actionObj);
                    
                }
            }
            if (isset($data['interviews'])) {
                foreach ($data['interviews'] as $interview) {
                    $interviewObj = new \Application\Entity\Interview();
                    $interviewObj->setActionIn($interview['action_in']);
                    $interviewObj->setArchivFile($archiveFileEntity);
                    $interviewObj->setFighter($interview['fighter']);
                    $interviewObj->setLanguage($interview['language']);
                    $this->db->persist($interviewObj);                    
                }
            }
            $this->db->flush();
            return $archiveFileEntity;
        } catch (\Exception $ex) {
            echo $ex->getMessage();
            
            return false;
        }

        return true;
    }
    
    public function updateArchiveFile($data)
    {
        try {
            if (!is_array($data)) {
                $data = $data->toArray();
            }
            
            if ((int)$data['id']) {
                $archiveFileEntity = $this->getArchiveFileById((int)$data['id']);
            }
            
            if (!$archiveFileEntity) {
                return false;
            }
            $archiveFileEntity->setRawData($data);
            if (count($data['fight_title']) > 0) {
                $archiveFileEntity->setFightTitle(implode(',', $data['fight_title']));
            } else {
                $archiveFileEntity->setFightTitle('');
            }
            $archiveFileEntity->validateData();
            $this->db->persist($archiveFileEntity);
            $archiveFileEntity->getFileIndex()->setStatus($archiveFileEntity->getStatus());
            $this->db->persist($archiveFileEntity->getFileIndex());
            if ($data['no_legalaffiars_to']) {
                $archiveFileEntity->setLegalaffiarsTo(new \DateTime('0000-00-00'));
            }
            if ($data['unlimited_runtime'] == 'y') {
                $archiveFileEntity->setLegalRuntime('');
            }
          
            if ($data['result'] != 'KO' && $data['result'] != 'TKO') {
                $archiveFileEntity->setResultRound('');
            }
            
            if ($data['resolution'] != 'other') {
                $archiveFileEntity->setResolutionInput('');
            }
            
            

            if (isset($data['actions'])) {
                $tapeList = array();
                foreach ($data['actions'] as $action) {
                    if (isset($action['id']) && (int)$action['id'] > 0) {
                        $actionObj = $this->getTapeById((int)$action['id']);
                        if (isset($action['toRemove']) && (int)$action['toRemove'] == $actionObj->getId()) {
                            $this->db->remove($actionObj);
                            continue;
                        }
                    } else {
                        $actionObj = new \Application\Entity\Tape();
                    }
                    $actionObj->setArchiveFile($archiveFileEntity);
                    $actionObj->setAction($action['action']);
                    $actionObj->setActionFrom($action['action_from']);
                    $actionObj->setComment($action['comment']);
                    $tapeList[] = $actionObj;
                    $this->db->persist($actionObj);
                    $this->db->flush();
                }                
            }
            if (isset($data['interviews'])) {
                foreach ($data['interviews'] as $interview) {
                    if (isset($interview['id']) && (int)$interview['id'] > 0) {
                        $interviewObj = $this->getInterviewById((int)$interview['id']);
                        if (isset($interview['toRemove']) && (int)$interview['toRemove'] == $interviewObj->getId()) {
                            $this->db->remove($interviewObj);
                            continue;
                        }
                    } else {
                        $interviewObj = new \Application\Entity\Interview();
                    }
                    $interviewObj->setArchivFile($archiveFileEntity);
                    $interviewObj->setActionIn($interview['action_in']);
                    $interviewObj->setActionOut($interview['action_out']);
                    $interviewObj->setFighter($interview['fighter']);
                    $interviewObj->setLanguage($interview['language']);
                    $this->db->persist($interviewObj);
                    $this->db->flush();
                }                
            }
            $this->db->flush();
            return $archiveFileEntity;
        } catch (\Exception $ex) {
            echo $ex->getMessage();

            return false;
        }

        return true;
    }
    
    
    public function getPagedFiles($type = 'archive', $status = null, $offset = 0, $limit = 20, $hidden = 0, $deleted = 0)
    {
        $entity = 'Application\Entity\ArchiveFile';
        if ($type == 'sende') {
            $entity = 'Application\Entity\SendeFile';
        }
        
        $query = $this->db->getRepository($entity)
            ->createQueryBuilder('a')
            ->innerJoin('a.fileIndex', 'i');

        $query->where('a.hidden = ' . $hidden);
        $query->andWhere('a.deleted = ' . $deleted);

        
        $query->andWhere('i.type = :type');
        $query->setParameter('type', $type);
        if (!empty($status)) {
            $query->andWhere('i.status = :status');
            $query->setParameter('status', $status);
        }
        $query->orderBy('a.id')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
//echo  $query->getQuery()->getSql(); 
        $query = $query->getQuery();

        $paginator = new Paginator( $query );

        return $paginator;
    }
    
    public function getPagedSendeFiles($status = null, $offset = 0, $limit = 20)
    {
        $by['fileIndex.status'] = 'Finished';
        $archiveFileRepository = $this->db->getRepository('Application\Entity\ArchiveFile');
        $archiveFiles = $archiveFileRepository->findBy($by, $orderBy);
        return $archiveFiles;
    }
    
    public function getArchiveFiles($by = array('hidden' => 0, 'deleted' => 0), $orderBy = array('id' => 'DESC'))
    {
        $archiveFileRepository = $this->db->getRepository('Application\Entity\ArchiveFile');
        $archiveFiles = $archiveFileRepository->findBy($by, $orderBy);
        return $archiveFiles;
    }
    public function getSendeFiles($by = array('hidden' => 0, 'deleted' => 0), $orderBy = array('id' => 'DESC'))
    {
        $sendeFiles = $this->db->getRepository('Application\Entity\SendeFile')->findBy($by, $orderBy);
        return $sendeFiles;
    }
    
    
    public function findSendeFiles($data, $offset = 0, $limit = 20, $hidden = 0, $deleted = 0)
    {        
        $query = $this->db->getRepository('Application\Entity\SendeFile')
            ->createQueryBuilder('a')
            ->innerJoin('a.fileIndex', 'i');
        
        if (isset($data['fighter']) && (int)$data['fighter'] > 0) {
            $query->leftJoin('a.fighters', 'fa');
            $fighter = $data['fighter'];
            unset($data['fighter']);
        }
        if (isset($data['description'])) {
            $query->leftJoin('a.sfDescriptions', 'de');
            $description = $data['description'];
            unset($data['description']);
        }
        
        if (isset($data['artwork'])) {
            $query->leftJoin('a.artwork', 'art');
            $artwork = $data['artwork'];
            unset($data['artwork']);
        }

        $query->where('a.id > 0');
        $query->andWhere('a.hidden = ' . $hidden);
        $query->andWhere('a.deleted = ' . $deleted);

        foreach ($data as $col => $val) {
            $col = \Application\Service\Utils\StringHandler::dashesToCamelCase($col);
  
            if ($col == 'status') {
                $query->andWhere('i.' . $col . ' = :' . $col);
                $query->setParameter($col, $val);
            } else {
                if ($val instanceof \DateTime) {
                    $query->andWhere('a.' . $col . ' = :' . $col);
                    $query->setParameter($col, $val->format('Y-m-d'));
                } else {
                    $query->andWhere('a.' . $col . ' LIKE :' . $col);
                    $query->setParameter($col, '%' . $val . '%');
                }

            }
            
        }
        if (isset($fighter)) {
            $query->andWhere('fa.id = :fighter');
            $query->setParameter('fighter', $fighter);
        }
        
        if (isset($description)) {
            if (!empty($description['short_description'])) {
                $query->andWhere('de.shortDescription LIKE :shortDescription');
                $query->setParameter('shortDescription', '%' . $description['short_description'] . '%');
            }
            if (!empty($description['long_description'])) {
                $query->andWhere('de.longDescription LIKE :longDescription');
                $query->setParameter('longDescription', '%' . $description['long_description'] . '%');
            }
            if (!empty($description['language'])) {
                $query->andWhere('de.language = :language');
                $query->setParameter('language', $description['language']);
            }
            if (!empty($description['type'])) {
                $query->andWhere('de.type = :type');
                $query->setParameter('type', $description['type']);
            }
        }
        
        if (isset($artwork)) {
            if (!empty($artwork['file_name'])) {
                $query->andWhere('art.fileName LIKE :file_name');
                $query->setParameter('file_name', '%' . $artwork['file_name'] . '%');
            }
            if (!empty($artwork['file_type'])) {
                $query->andWhere('art.fileType = :file_type');
                $query->setParameter('file_type', $artwork['file_type']);
            }
           
        }
        //echo  $query->getQuery()->getSql();die;
        /*
        $sendeFiles = $query->getQuery()->getResult();
        return $sendeFiles;
        
        */
        $query->orderBy('a.id')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        $query = $query->getQuery();
        $paginator = new Paginator( $query );

        return $paginator;
        
    }
    
    
    public function findArchiveFiles($data, $offset = 0, $limit = 20, $hidden = 0, $deleted = 0)
    {
        if (isset($data['no_legalaffiars_to'])) {
            unset($data['no_legalaffiars_to']);
        }
        if (isset($data['unlimited_runtime'])) {
            unset($data['unlimited_runtime']);
        }
        
        $query = $this->db->getRepository('Application\Entity\ArchiveFile')
            ->createQueryBuilder('a')
            ->innerJoin('a.fileIndex', 'i')
            ->leftJoin('a.fighterA', 'fa')
            ->leftJoin('a.interviews', 'int');
        
        if (isset($data['marker'])) {
            $query->leftJoin('a.tapes', 'tape');
            if (!empty($data['marker']['action'])) {
                $markerAction = $data['marker']['action'];
            }
            if (!empty($data['marker']['comment'])) {
                $markerComment = $data['marker']['comment'];
            }
            unset($data['marker']);
        }
        
        if (!empty($data['fighter'])) {
            $fighter = $data['fighter'];
            unset($data['fighter']);
        }
        
        if (!empty($data['fighter_b'])) {
            $fighterB = $data['fighter_b'];
            unset($data['fighter_b']);
        }
        
        if (!empty($data['interviews'])) {
            $interviews = $data['interviews'];
            unset($data['interviews']);
        }

        $query->where('a.id > 0');
        $query->andWhere('a.hidden = 0');
        $query->andWhere('a.deleted = 0');
        
        foreach ($data as $col => $val) {
            $col = \Application\Service\Utils\StringHandler::dashesToCamelCase($col);
            if ($col == 'status') {
                $query->andWhere('i.' . $col . ' = :' . $col);
                $query->setParameter($col, $val);
            } else {
                if ($val instanceof \DateTime) {
                    $query->andWhere('a.' . $col . ' = :' . $col);
                    $query->setParameter($col, $val->format('Y-m-d'));
                } else {
                    $query->andWhere('a.' . $col . ' LIKE :' . $col);
                    $query->setParameter($col, '%' . $val . '%');
                }

            }
        }
        
        if (isset($fighter) && !isset($fighterB)) {
            $query->andWhere('a.fighterA = :fighterA');
            $query->setParameter('fighterA', $fighter);
            $query->orWhere('a.fighterB = :fighterB');
            $query->setParameter('fighterB', $fighter);
        } elseif (!isset($fighter) && isset($fighterB)){
            $query->andWhere('a.fighterB = :fighterB');
            $query->setParameter('fighterB', $fighterB);
        } elseif (isset($fighter) && isset($fighterB)) {
            $query->andWhere('a.fighterA = :fighterA');
            $query->setParameter('fighterA', $fighter);
            $query->andWhere('a.fighterB = :fighterB');
            $query->setParameter('fighterB', $fighterB);           
        }
        
        if (isset($markerAction)) {
            $query->andWhere('tape.action = :action');
            $query->setParameter('action', $markerAction);
        }
        
        if (isset($markerComment)) {
            $query->andWhere('tape.comment LIKE :comment');
            $query->setParameter('comment', '%' . $markerComment . '%');
        }
        
        if (isset($interviews)) {
            $query->andWhere('int.fighter LIKE :interviews');
            $query->setParameter('interviews', '%' . $interviews . '%');
        }
        //echo  $query->getQuery()->getSql();die;
        /*
        $archiveFiles = $query->getQuery()
           ->getResult();
        return $archiveFiles;
         * 
         */
        
        $query->orderBy('a.id')
            ->setMaxResults($limit)
            ->setFirstResult($offset);
        $query = $query->getQuery();
        $paginator = new Paginator($query);

        return $paginator;
    }
    
    public function findArchiveFilesByData(array $data)
    {
        if (empty($data)) {
            return;
        }
        $archiveFileRepository = $this->db->getRepository('Application\Entity\ArchiveFile');
//        $archiveFiles = $archiveFileRepository->findBy($data);
        $query = $this->db->getRepository('Application\Entity\ArchiveFile')->createQueryBuilder('a');
        foreach ($data as $col => $val) {
            $col = \Application\Service\Utils\StringHandler::dashesToCamelCase($col);
            if (!$setFirst) {
                $query->where('a.' . $col . ' LIKE :' . $col);
                $query->setParameter($col, '%' . $val . '%');
                $setFirst = true;
                continue;
            }
            $query->andWhere('a.' . $col . ' LIKE :' . $col);
            $query->setParameter($col, '%' . $val . '%');
        }
 
    }
    
    /*
     * check storage with smallest size
     * @return string $storageName 
     */
    public function getAvailableStorage()
    {
        $globalConfig = $this->getServiceLocator()->get('config');
        $diskSize = null;
        $storageName = '';
        foreach ($globalConfig['storageSettings'] as $dir => $st) {
            if ($diskSize == null) {
                $diskSize = str_replace('M', '', exec('df -h -BM ' . $st['path'] . $dir . ' | awk \'{print $4}\''));
                $storageName = $dir;
                continue;
            }
            if ($diskSize > ($currentSire = str_replace('M', '', exec('df -h -BM ' . $st['path'] . $dir . ' | awk \'{print $4}\'')))) {
                $diskSize = $currentSire;
                $storageName = $dir;
            }
        }
        return $storageName;
    }
        
    public function getXmlStructure($id, $type = 'Application\Entity\SendeFile')
    {
        $file = $this->db->find($type, $id);
        $content = simplexml_load_file(__DIR__ . "/content.xml");
        $content->show->title = $file->getTitle();
        $content->show['id'] = $file->getId();
        $content->show['content_rating_categories'] = $file->getRating();
        $content->show->file['name'] = $file->getName();
        $content->show->file['length'] = $file->getRunTime();
        $content->show->product_year = $file->getProductYear();
        $content->show->genre = $file->getGenre();
        $content->show->sport_type = $file->getSportType();
        $content->show->country = $file->getCountry();
        $content->show->license->licensors = $file->getLicensors();
        $content->show->license->start = $file->getLicenseStart()->setTimezone(new \DateTimeZone('UTC'))->format('Y-d-mTG:i:sz');
        if ($file->getLicenseEnd()->format('Y') != '-0001') {
            $content->show->license->end = $file->getLicenseEnd()->setTimezone(new \DateTimeZone('UTC'))->format('Y-d-mTG:i:sz');
        } else {
            $content->show->license->end = 'no license expires';
        }
        $content->show->license->copyright = $file->getCopyright();
        if ($file->getLegalRuntime() > 0) {
            $content->show->license->runtime = $file->getLegalRuntime();
        } else {
            $content->show->license->runtime = 'unlimited';
        }
        if ($file->getSfDescriptions()->count() > 0) {
            foreach ($file->getSfDescriptions() as $des) {
                $description = $content->show->descriptions->addChild('description');
                $description->description = $des->getLongDescription();
                $description->description_type =  $des->getType();
                $description->language = $des->getLanguage();
                
            }
        }
        if ($file->getFighters()->count() > 0) {
            foreach ($file->getFighters() as $f) {
                $fighter = $content->show->fighters->addChild('fighter', $f->getFullname());
            }
        }
        
        if ($file->getArtwork()->count() > 0) {
            foreach ($file->getArtwork() as $a) {
                $artwork = $content->show->artworks->addChild('artwork');
                $image = $artwork->addChild('image');
                $image['type'] = $a->getFileType();
                $image['url'] = $a->getFilePath() . $a->getFileName();
            }
        }
        
        if ($file->getContentTags()) {
            $keywords = explode(',', $file->getContentTags());
            foreach ($keywords as $kw) {
                $keyword = $content->show->keywords->addChild('keyword', $kw);
            }
        }
        
        return $content;
    }
    
    public function getFilesByStatus($status = 'ReadyToConvert')
    {
        $selectSql =
            'SELECT '
            . ' fi.id fileIndexId, sf.id sendeFileId, af.id archiveFileId, fi.`type`, fi.`status`, af.name archiveFileName, '
            . ' sf.name sendeFileName, af.storage archiveStorage, sf.storage sendeStorage  '
            . ' FROM file_index fi'
            . ' LEFT JOIN archive_files af ON fi.id = af.fk_id AND fi.`type` = "archive"'
            . ' LEFT JOIN sende_files sf ON fi.id = sf.fk_id AND fi.`type` = "sende"'
            . ' WHERE fi.`status` = "' . $status. '"'
            . ' ORDER BY fi.id'
            . ' LIMIT 1';        
        $conn = $this->db->getConnection();
        return $conn->query($selectSql)->fetchAll();
    }
    

    public function getArchiveFileById($id)
    {
        $archiveFile = $this->db->find('Application\Entity\ArchiveFile', $id);
        return $archiveFile;
    }
    
    public function getTapeById($id)
    {
        $tape = $this->db->find('Application\Entity\Tape', $id);
        return $tape;
    }
    
    public function getInterviewById($id)
    {
        return $this->db->find('Application\Entity\Interview', $id);
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
    
    public function getFighterService()
    {
        return $this->getServiceLocator()->get('Application\Service\Fighter');
    }
    
    public function getFileDuration($path)
    {
        if (file_exists($path)) {
            $cmd = "avprobe -show_streams -show_format " . $path . " 2>&1 | grep Duration |  awk '{print $2}' | tr -d ,";
            $duration = exec($cmd);
            $duration = substr($duration, 0, 8);
            return $duration;
        }
        return '';
    }

//put your code here
}
