<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;

class SendefileController extends AbstractActionController
{
    /*
     * @var \Application\Service\FileService $fileService
     */
    protected $fileService;
    
    /*
     * @var \FileUpload\Service\FileUpload $fileUploadService
     */
    protected $fileUploadService;
        
    /*
     * @var \Application\Service\FighterService $fighterService
     */
    protected $fighterService;
    
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id) {
            $this->flashMessenger()->addMessage('Sende-Datei ist nicht gefunden!');
            return $this->redirect()->toRoute('sendefiles', array('action' => 'index'));
        }
        $file = $this->fileService->getDb()->find('Application\Entity\SendeFile', $id);
        if (!$file->getRunTime()) {
            $globalConfig = $this->getServiceLocator()->get('config');
            $path = 
                $globalConfig['storageSettings'][$file->getStorage()]['path']  // /var/storage/
                . $file->getStorage() . '/'
                . $globalConfig['storageSettings'][$file->getStorage()]['VA_FILES']
                . '/' . $file->getName() . '/'
                . $file->getName() . '.mp4';
            $file->setRunTime($this->fileService->getFileDuration($path));
        }
        return new ViewModel(array(
            'file' => $file
        ));
    }
    
    public function editsendefileAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!((int)$id > 0)) {
            $this->flashMessenger()->addMessage('Sende-Datei ist nicht gefunden!');
            return $this->redirect()->toRoute('sendefile', array('action' => 'index'));
        }
        if ($this->request->isPost()) {
            $id = $this->getRequest()->getPost()->id;
            $postData = $this->getRequest()->getPost()->toArray();

            if (!((int)$id > 0)) {
                $this->flashMessenger()->addMessage('Sende-Datei ist nicht gefunden!');
                return $this->redirect()->toRoute('sendefile', array('action' => 'index'));
            }
            
            
            $file = $this->fighterService->getDb()->find('Application\Entity\SendeFile', (int)$id);
            $file->setRawData($postData);
            if (isset($postData['unlimited_runtime']) && $postData['unlimited_runtime'] == 'y') {
                $file->setLegalRuntime(null);
            }
            
            if (isset($postData['status']) && $postData['status'] != $file->getFileIndex()->getStatus()) {
                $file->getFileIndex()->setStatus($postData['status']);
            }
            
            if (isset($postData['no_legalaffiars_to']) && $postData['no_legalaffiars_to'] == 'on') {
                $file->setLicenseEnd(new \DateTime('0000-00-00'));
            }
            
            if (isset($postData['sfdescription'])) {
                foreach ($postData['sfdescription'] as $sfdescription) {
                    if (isset($sfdescription['id']) && (int)$sfdescription['id'] > 0) {
                        $sfdescriptionObj = $this->fileService->getDb()->find('Application\Entity\SfDescription', ((int)$sfdescription['id']));
                        if (isset($sfdescription['toRemove']) && (int)$sfdescription['toRemove'] == $sfdescriptionObj->getId()) {
                            $this->fileService->getDb()->remove($sfdescriptionObj);
                            continue;
                        }
                    } else {
                        $sfdescriptionObj = new \Application\Entity\SfDescription();
                    }
                    $sfdescriptionObj->setSfFile($file);
                    $sfdescriptionObj->setRawData($sfdescription);
                    $this->fileService->getDb()->persist($sfdescriptionObj);
                    $this->fileService->getDb()->flush();
                }                
            }
            
            if (isset($postData['sffighter'])) {
                foreach ($postData['sffighter'] as $oldId => $fighter) {
                    if (isset($fighter['id']) && (int)$fighter['id'] > 0) {
                        $fighterObj = $this->fileService->getDb()->find('Application\Entity\Fighter', ((int)$fighter['id']));
                         if (isset($fighter['toRemove']) && (int)$fighter['toRemove'] == $fighterObj->getId()) {
                            $file->getFighters()->removeElement($fighterObj);
                            continue;
                        } 
                        if (!$file->getFighters()->contains($fighterObj)) {
                            $file->getFighters()->add($fighterObj);
                        }
                        if ($oldId != $fighterObj->getId()) {
                            $oldFighter = $this->fileService->getDb()->find('Application\Entity\Fighter', ((int)$oldId));
                            $file->getFighters()->removeElement($oldFighter);
                        }
                    }
                }                
            }

            
            $this->createNewFiles($file);
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush($file);
        } else {
            $file = $this->fighterService->getDb()->find('Application\Entity\SendeFile', (int)$id);
        }
        if (!$file->getRunTime()) {
            $globalConfig = $this->getServiceLocator()->get('config');
            $path = 
                $globalConfig['storageSettings'][$file->getStorage()]['path']  // /var/storage/
                . $file->getStorage() . '/'
                . $globalConfig['storageSettings'][$file->getStorage()]['VA_FILES']
                . '/' . $file->getName() . '/'
                . $file->getName() . '.mp4';
            $file->setRunTime($this->fileService->getFileDuration($path));
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush();
        }
        return new ViewModel(array(
            'file' => $file
        ));
    }
    
    public function newsendefilestepAction()
    {
        
    }
        
    public function newsendefilestep1Action()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ((int)$id > 0) {
            $file = $this->fighterService->getDb()->find('Application\Entity\SendeFile', (int)$id);
            if (!$file) {
                $this->flashMessenger()->addMessage('Sende-Datei ist nicht gefunden!');
                return $this->redirect()->toRoute('sendefile', array('action' => 'newarchivefilestep1'));
            } else {
                return new ViewModel(array(
                    'file' => $file
                ));
            }
        }
        if ($this->request->isPost()) {
            $postData = $this->getRequest()->getPost();
            $file = new \Application\Entity\SendeFile();
            $file->setCreatedAt(new \DateTime);
            $fileIndex = new \Application\Entity\FileIndex();
            $fileIndex->setType('sende');
            $fileIndex->setStatus('New');
            $fileIndex->setSendeFile($file);
            $this->fileService->getDb()->persist($fileIndex);
            $this->fileService->getDb()->flush();
            $file->setFileIndex($fileIndex);
            if (!empty($postData->title)) {
                $file->setTitle($postData->title);
            }
            
            if (!empty($postData->product_year)) {
                $file->setProductYear($postData->product_year);
            }
            
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush($file);
            $file = $this->fighterService->getDb()->find('Application\Entity\SendeFile', $file->getId());
            $file->setName($file->getId() . '_' . $file->getCreatedAt()->format('Ymd'));
            $file->setStorage($this->fileService->getAvailableStorage());

            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush();
            return $this->redirect()->toRoute('sendefile', array('action' => 'newsendefilestep1', 'id' => $file->getId()));
        }
        return $this->redirect()->toRoute('sendefile', array('action' => 'newsendefilestep1', 'id' => $file->getId()));
        
            
    }
    
    
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
            return $this->redirect()->toRoute('sendefiles', $actionParams);
        }
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $pagedFiles = $this->fileService->getPagedFiles('sende', $status, $offset, $limit);
 
        $viewArray = array(
            'pagedFiles' => $pagedFiles,
            'page' => $page,
            'limit' => $limit,
            'status' => $status            
        );
        
        return new ViewModel(
            $viewArray
        );
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
            return $this->redirect()->toRoute('sendefiles', $actionParams);
        }
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        $pagedFiles = $this->fileService->getPagedFiles('sende', $status, $offset, $limit, 1);
       
        $viewArray = array(
            'pagedFiles' => $pagedFiles,
            'page' => $page,
            'limit' => $limit,
            'status' => $status           
        );
        
        return new ViewModel(
            $viewArray
        );
    }
    
    
    public function removeAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->fileService->getDb()->find('Application\Entity\SendeFile', $id);
        $notToDeleteStatus = array('ConvertInProgress');
        if ($file && $file instanceof \Application\Entity\SendeFile && !in_array($file->getFileIndex()->getStatus(), $notToDeleteStatus)) {
            $this->flashMessenger()->addMessage('Die Datei ' . $file->getName() . ' wurde gelöscht.');
            /*
            $fileIndex = $file->getFileIndex();
            $descriptions = $file->getSfDescriptions();
            if ($descriptions->count() > 0) {
                foreach ($descriptions as $d) {
                    $this->fileService->getDb()->remove($d);
                }
            }
            $conn = $this->fileService->getDb()->getConnection();
            if ($file->getArtwork()->count() > 0) {
                foreach ($file->getArtwork() as $uploadFile) {    
                    $conn->delete('sf_artwork', array('upload_file_id' => (int)$uploadFile->getId(), 'sf_id' => (int)$file->getId()));
                    exec('rm "' . $uploadFile->getFilePath() . $uploadFile->getFileName() . '"');
                    $this->fileService->getDb()->remove($uploadFile);
                }   
            }
            
            if ($file->getFighters()->count() > 0) {
                $conn->delete('sf_fighter', array('sf_id' => (int)$file->getId()));
            }
            
            $this->fileService->getDb()->remove($fileIndex);
             * 
             */
            $file->setDeleted(1);
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush();
            return $this->redirect()->toRoute('sendefiles', array('action' => 'index'));
        }
        $this->flashMessenger()->addMessage('Löschvorgang ist fehlgeschlagen.');
        return $this->redirect()->toRoute('sendefiles', array('action' => 'index'));
    }
    
    public function deactivateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->fileService->getDb()->find('Application\Entity\SendeFile', $id);
        if ($file) {
            $file->setHidden(1);
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush();
        }
        return $this->redirect()->toRoute('sendefile', array('action' => 'index'));
    }
    
    public function activateAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $file = $this->fileService->getDb()->find('Application\Entity\SendeFile', $id);
        if ($file) {
            $file->setHidden(0);
            $this->fileService->getDb()->persist($file);
            $this->fileService->getDb()->flush();
        }
        return $this->redirect()->toRoute('sendefile', array('action' => 'deactivatedfiles'));
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
            return $this->redirect()->toRoute('sendefiles',  array('action' => 'searchresult'));
            
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
            return $this->redirect()->toRoute('sendefiles', $actionParams);
        }
        $session = new Container('FileSearch');
        $dateArray= array('license_start', 'license_end');
        
        foreach ($session->searchData as $key => $value) {
            if (in_array($key, $dateArray) && !is_object($value)) {
                $session->searchData[$key] = new \DateTime($value);
            }
        }
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $status = $this->params()->fromRoute('status', '');
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        
        $searchData = $session->searchData;
        $files = $this->fileService->findSendeFiles($searchData, $offset, $limit);

       
        $viewArray = array(
            'files' => $files,
            'page' => $page,
            'limit' => $limit,
        );
        return new ViewModel(
            $viewArray
        );

    }
    
    public function xmlAction()
    {
        header('Content-type: text/xml');
        header('Content-Disposition: attachment; filename="content.xml"');
        $id = (int) $this->params()->fromRoute('id', 0);
        $contentXml = $this->fileService->getXmlStructure($id);
        echo $contentXml->asXML();
        die;
    }
    
        
    function getFileService()
    {
        return $this->fileService;
    }

    function setFileService($fileService)
    {
        $this->fileService = $fileService;
    }
    
    function getFighterService()
    {
        return $this->fighterService;
    }

    function setFighterService($fighterService)
    {
        $this->fighterService = $fighterService;
    }

    public function getFileUploadService()
    {
        return $this->fileUploadService;
    }

    public function setFileUploadService($fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }


    protected function createNewFiles($file)
    {
        $uploadFiles =  $this->getRequest()->getFiles()->toArray();
        $postData = $this->getRequest()->getPost()->toArray();
        if (isset($uploadFiles['sfartwork']) && count($uploadFiles['sfartwork'])) {
            if (!file_exists($this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName())) {
                mkdir($this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName() . '/');
            }
            foreach ($uploadFiles['sfartwork'] as $key => $uf) {
                $uFileType = array_shift($postData['sfartwork']);
                $uFile = new \FileUpload\Entity\File();
                $uFile->setFilePath($this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName() . '/');
                $uFile->setFileName($uf['file']['name']);
                $uFile->setFileType($uFileType['file_type']);
                $uFile->setRelPath($this->fileUploadService->getUploadPath() . $file->getStorage() . '/' . $file->getName() . '/');
                if (file_exists($this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName() . '/' . $uFile->getFileName())) {
                    $this->flashMessenger()->addMessage('Fehler: Die Datei '
                        . $uFile->getFileName()
                        . ' konnte nicht geschrieben werden da sie bereits existiert. Bitte löschen Sie vor dem Upload die alte Datei und versuchen Sie es nochmal.'
                    );
                    return $this->redirect()->toRoute('sendefile',  array('action' => 'editsendefile', 'id' => $file->getId()));
                    continue;
                }
                $relsult = rename(
                    $uf['file']['tmp_name'],
                    $this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName() . '/' . $uFile->getFileName()
                );
                exec('chmod 666 "' . $this->fileUploadService->getUploadPath() . $file->getStorage() . '/VA_FILES/' . $file->getName() . '/' . $uFile->getFileName() . '"');
                $this->fileService->getDb()->persist($uFile);
                $this->fileService->getDb()->flush($uFile);
                $file->getArtwork()->add($uFile);
            }
        }
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

}
