<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
/**
 * Description of FileController
 * @author aqnguyen
 */
class FileController extends AbstractActionController
{
    
    /*
     * @var \Application\Service\FileService $archiveFileService
     */
    protected $archiveFileService;
    
    /*
     * @var \Application\Service\FighterService $fighterService
     */
    protected $fighterService;
     
    
    public function indexAction()
    {
        if ($this->request->isPost()) {
            $postData = $this->getRequest()->getPost();
            $actionParams = array('action' => 'index');
            if (!empty($postData['limit'])) {
                $actionParams['limit'] = (int)$postData['limit'];
            } else {
                $actionParams['limit'] = 20;
            }
            if (!empty($postData['status'])) {
                $actionParams['status'] = htmlentities(strip_tags($postData['status']));
            }
            $actionParams['page'] = 1;
            return $this->redirect()->toRoute('archivefiles', $actionParams);
        }
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $pagedArchiveFiles = $this->archiveFileService->getPagedFiles('archive', $status, $offset, $limit);
        $new = array();
        $ingestInProgress = array();
        $ingestDone = array();
        $cutInProgress = array();
        $cutDone = array();
        $finished = array();
        $notReadyToConvert = array();
        $readyToConvert = array();
        foreach ($pagedArchiveFiles as $file) {
            if (null == ($fileIdex = $file->getFileIndex())) {
                continue;
            }

            if ($file->getFileIndex()->getStatus() == 'New') {
                $new[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'IngestInProgress') {
                $ingestInProgress[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'IngestDone') {
                $ingestDone[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'CutInProgress') {
                $cutInProgress[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'CutDone') {
                $cutDone[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'Finished') {
                $finished[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'NotReadyToConvert') {
                $notReadyToConvert[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'ReadyToConvert') {
                $readyToConvert[] = $file;
            }
        }
        $viewArray = array(
            'pagedArchiveFiles' => $pagedArchiveFiles,
            'page' => $page,
            'limit' => $limit,
            'status' => $status,
            'new' => $new,
            'ingestInProgress' => $ingestInProgress,
            'ingestDone' => $ingestDone,
            'cutInProgress' => $cutInProgress,
            'cutDone' => $cutDone,
            'finished' => $finished,
            'notReadyToConvert' => $notReadyToConvert,
            'readyToConvert' => $readyToConvert,
        );
        
        return new ViewModel(
            $viewArray
        );

    }
    
    
    public function deactivateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->archiveFileService->getDb()->find('Application\Entity\ArchiveFile', $id);
        if ($file) {
            $file->setHidden(1);
            $this->archiveFileService->getDb()->persist($file);
            $this->archiveFileService->getDb()->flush();
        }
        return $this->redirect()->toRoute('archivefile', array('action' => 'index'));
    }
    
    public function activateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->archiveFileService->getDb()->find('Application\Entity\ArchiveFile', $id);
        if ($file) {
            $file->setHidden(0);
            $this->archiveFileService->getDb()->persist($file);
            $this->archiveFileService->getDb()->flush();
        }
        return $this->redirect()->toRoute('archivefile', array('action' => 'deactivatedfiles'));
    }
    
    public function deactivatedfilesAction()
    {
        if ($this->request->isPost()) {
            $postData = $this->getRequest()->getPost();
            $actionParams = array('action' => 'deactivatedfiles');
            if (!empty($postData['limit'])) {
                $actionParams['limit'] = (int)$postData['limit'];
            } else {
                $actionParams['limit'] = 20;
            }
            if (!empty($postData['status'])) {
                $actionParams['status'] = htmlentities(strip_tags($postData['status']));
            }
            $actionParams['page'] = 1;
            return $this->redirect()->toRoute('archivefiles', $actionParams);
        }
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $archiveFiles = $this->archiveFileService->getPagedFiles('archive', $status, $offset, $limit, 1);
        
        $new = array();
        $ingestInProgress = array();
        $ingestDone = array();
        $cutInProgress = array();
        $cutDone = array();
        $finished = array();
        $notReadyToConvert = array();
        $readyToConvert = array();
        foreach ($archiveFiles as $file) {
            if (null == ($fileIdex = $file->getFileIndex())) {
                continue;
            }

            if ($file->getFileIndex()->getStatus() == 'New') {
                $new[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'IngestInProgress') {
                $ingestInProgress[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'IngestDone') {
                $ingestDone[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'CutInProgress') {
                $cutInProgress[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'CutDone') {
                $cutDone[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'Finished') {
                $finished[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'NotReadyToConvert') {
                $notReadyToConvert[] = $file;
            }
            if ($file->getFileIndex()->getStatus() == 'ReadyToConvert') {
                $readyToConvert[] = $file;
            }
        }
        $viewArray = array(
                'archiveFiles' => $archiveFiles,
                'page' => $page,
                'limit' => $limit,
                'status' => $status,
                'new' => $new,
                'ingestInProgress' => $ingestInProgress,
                'ingestDone' => $ingestDone,
                'cutInProgress' => $cutInProgress,
                'cutDone' => $cutDone,
                'finished' => $finished,
                'notReadyToConvert' => $notReadyToConvert,
                'readyToConvert' => $readyToConvert,
            );
        
        return new ViewModel(
            $viewArray
        );
    }
    
    public function removeAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->archiveFileService->getDb()->find('Application\Entity\ArchiveFile', $id);
        $notToDeleteStatus = array('ConvertInProgress');
        if ($file && $file instanceof \Application\Entity\ArchiveFile && !in_array($file->getFileIndex()->getStatus(), $notToDeleteStatus)) {
            $this->flashMessenger()->addMessage('Die Datei ' . $file->getName() . ' wurde gelöscht.');
            /*
            $fileIndex = $file->getFileIndex();
            $momments = $file->getTapes();
            if ($momments->count() > 0) {
                foreach ($momments as $m) {
                    $this->archiveFileService->getDb()->remove($m);
                }
            }
            if ($file->getInterviews()->count() > 0) {
                foreach ($file->getInterviews() as $i) {
                    $this->archiveFileService->getDb()->remove($i);
                }
            }
           // $this->archiveFileService->getDb()->remove($fileIndex);
             * 
             */
            $file->setDeleted(1);
            $this->archiveFileService->getDb()->persist($file);
            $this->archiveFileService->getDb()->flush();
            return $this->redirect()->toRoute('archivefiles', array('action' => 'index'));
        }
        $this->flashMessenger()->addMessage('Löschvorgang ist fehlgeschlagen.');
        return $this->redirect()->toRoute('archivefiles', array('action' => 'index'));
    }
    
    public function newarchivefilestep1Action()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        //$this->flashMessenger()->addMessage('You are now logged in.');
        
        
        
        if ($this->request->isPost()) {
            $data = $this->getRequest()->getPost();
            
            if ((int)$data->fighter_a > 0 &&  (int)$data->fighter_b > 0) {
                $isExist = $this->fighterService->chechFighterExist(array($data->fighter_a, $data->fighter_b));
                if (!$isExist) {
                    
                }
                $result = $this->archiveFileService->createArchiveFile($data);
                if ($result) {
                    return $this->redirect()->toRoute('archivefile', array('action' => 'newarchivefilestep2', 'id' => $result->getId()));
                }
            } else {
                $this->flashMessenger()->addMessage('Bitte nur die Kämpfer aus Autovervollständigung nehmen!');
                return $this->redirect()->toRoute('archivefile', array('action' => 'newarchivefilestep1'));
            }
        }
        $fighters = $this->fighterService->getFighters();
        return new ViewModel(array(
            'fighters' => $fighters
        )); 
    }
    
    public function selectfiletypeAction(){}


    public function newarchivefilestep2Action()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id && !$this->request->isPost()) {
            return $this->redirect()->toRoute('home');
        }
        $archiveFile = $this->archiveFileService->getArchiveFileById($id);
        

        
        if ($this->request->isPost()) {
            $data = $this->getRequest()->getPost();
            $archiveFile = $this->archiveFileService->getArchiveFileById($data->id);
            $archiveFile->setName($data->name);
            $this->archiveFileService->getDb()->persist($archiveFile);
            $this->archiveFileService->getDb()->flush();
            if (!empty($data->name)) {
                return $this->redirect()->toRoute('archivefile', array('action' => 'editarchivefile', 'id' => $archiveFile->getId()));
            }
        }
        return new ViewModel(array(
            'archiveFile' => $archiveFile,
          //  'fighters' => $fighters
        )); 
        
    }
    
    
    public function newarchivefileAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        //$this->flashMessenger()->addMessage('You are now logged in.');
        if ($this->request->isPost()) {
            $data = $this->getRequest()->getPost();
            $result = $this->archiveFileService->createArchiveFile($data);
            if ($result) {
                return $this->redirect()->toRoute('archivefile');
            }
        }
    }
    
    
    public function archivefilelistAction()
    {
        $archiveFiles = $this->archiveFileService->getArchiveFiles();
        return new ViewModel(array('archiveFiles' => $archiveFiles));
    }
    
    public function editarchivefileAction()
    {
        if ($this->request->isPost()) {
            
            $data = $this->getRequest()->getPost();
            $result = $this->archiveFileService->updateArchiveFile($data);
            return $this->redirect()->toRoute('archivefile', array('action' => 'editarchivefile', 'id' => $result->getId()));

        }
        
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $archiveFile = $this->archiveFileService->getArchiveFileById($id);
            $status = $this->params()->fromRoute('status', 0);
            if ($status) {
                $fileIndex = $archiveFile->getFileIndex();
                $fileIndex->setStatus($status);
                $archiveFile->setFileIndex($fileIndex);
                $this->archiveFileService->getDb()->persist($archiveFile);
                $this->archiveFileService->getDb()->flush();
            }
            return new ViewModel(array('archiveFile' => $archiveFile));
        }
    }
    
    
    public function showarchivefileAction()
    {       
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $archiveFile = $this->archiveFileService->getArchiveFileById($id);
            return new ViewModel(array('archiveFile' => $archiveFile));
        }
        
    }
    
    
    public function searchAction()
    {
        if ($this->request->isPost()) {
            
            $data = $this->getRequest()->getPost();
            $data = $data->toArray();
            foreach ($data as $key => $value) {
                if (empty($value)) {
                    unset($data[$key]);
                }
            }
            $session = new Container('FileSearch');        
            $session->getManager()->getStorage()->clear('searchData');
            $session->searchData = $data;
            return $this->redirect()->toRoute('archivefiles',  array('action' => 'searchresult'));
            
        }
    }
    
    public function searchresultAction()
    {
        if ($this->request->isPost()) {
            $postData = $this->getRequest()->getPost();
            $actionParams = array('action' => 'searchresult');
            if (!empty($postData['limit'])) {
                $actionParams['limit'] = (int)$postData['limit'];
            } else {
                $actionParams['limit'] = 20;
            }
            if (!empty($postData['status'])) {
                $actionParams['status'] = htmlentities(strip_tags($postData['status']));
            }
            $actionParams['page'] = 1;
            return $this->redirect()->toRoute('archivefiles', $actionParams);
        }
        
        $session = new Container('FileSearch');
        $dateArray= array('legalaffiars_from', 'legalaffiars_to', 'legal_runtime', 'fight_date');
        
        foreach ($session->searchData as $key => $value) {
            if (in_array($key, $dateArray) && !is_object($value)) {
                $session->searchData[$key] = new \DateTime($value);
            }
        }
        $searchData = $session->searchData;
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $files = $this->archiveFileService->findArchiveFiles($searchData, $offset, $limit);
        return new ViewModel(
            array(
                'files' => $files,
                'page' => $page,
                'limit' => $limit
            )
        );

    }
        
    
    
    function getArchiveFileService()
    {
        return $this->archiveFileService;
    }

    function setArchiveFileService($archiveFileService)
    {
        $this->archiveFileService = $archiveFileService;
    }

    public function updatefilestatusAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if ($id > 0) {
            $fileIndex = $this->archiveFileService->getDb()->find('Application\Entity\FileIndex', $id);
            $status = $this->params()->fromRoute('status', 0);
            $fileIndex->setStatus($status);
            $this->archiveFileService->getDb()->persist($fileIndex);
            $this->archiveFileService->getDb()->flush();

        }
        
    }
    
    public function fighterautocompleAction()
    {
        header('Cache-Control: no-cache, must-revalidate');
        header('Content-type: application/json');
        if (!empty($_REQUEST['term'])) {
            $term = htmlentities(strip_tags($_REQUEST['term']));
            $fighters = $this->fighterService->getFighters($term);
            if (count($fighters) > 0) {
                $fighterArr = array();
                foreach ($fighters as $f) {
                    $fighterArr[] = array(
                        'value' => $f->getFirstname() . ' ' . $f->getLastname() . ' (' . $f->getId() . ')', 
                        'lastname' => $f->getLastname(),
                        'label' => $f->getFirstname() . ' ' . $f->getLastname() . ' (' . $f->getId() . ')',
                        'firstname' => $f->getFirstname(), 
                        'lastname_shortcut' => $f->getLastnameShortcut(),
                        'id' => $f->getId()
                    );
                }
                echo json_encode($fighterArr);
                exit();
            }
        }
        echo json_encode(array('status' => 'ERROR'));
        die;
    }
    
    
    function getFighterService()
    {
        return $this->fighterService;
    }

    function setFighterService($fighterService)
    {
        $this->fighterService = $fighterService;
    }


}
