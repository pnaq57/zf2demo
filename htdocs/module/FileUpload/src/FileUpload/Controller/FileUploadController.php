<?php
namespace FileUpload\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;

class FileUploadController extends AbstractActionController
{
    protected $fileUploadService;
    
    protected $fileService;


    public function indexAction()
    {
        $form = new \FileUpload\Form\SingleUpload('file-form');
        $uploadedFiles = $this->fileUploadService->getUploadFiles();
        return array(
            'form' => $form,
            'uploadedFiles' => $uploadedFiles
        );
    }
    
    public function singleuploadAction()
    {
        $form = new \FileUpload\Form\SingleUpload('file-form');
        if ($this->getRequest()->isPost()) {
            // Postback
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $originalName = $formData['file']['name'];
                $newName = htmlentities(strip_tags(str_replace(array(' '), array('_'), $formData['file']['name'])));
                if (!file_exists($this->fileUploadService->getUploadPath() . $newName)) {
                    if (
                        rename(
                            $this->fileUploadService->getUploadTempPath() . $originalName,
                            $this->fileUploadService->getUploadPath() . $newName)
                    ) {
                       $fileObj = new \FileUpload\Entity\File();
                       $fileObj->setFileName($newName);
                       $fileObj->setFilePath($this->fileUploadService->getUploadPath());
                       $fileObj->setFileType($formData['file_type']);
                       $fileObj->setUpdatedAt(new \DateTime);
                       $this->fileUploadService->getDb()->persist($fileObj);
                       $this->fileUploadService->getDb()->flush();
                    }
                } else {
                    $this->flashMessenger()->addMessage('Die Datei ist vorhanden!!');
                    return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
                }
                $this->flashMessenger()->addMessage('Datei ist erfolgreich hochgeladen!!');
                return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
                return $this->redirectToSuccessPage($form->getData());
            }
        }
        
        $this->flashMessenger()->addMessage('Dateihochladen ist fehlgeschlagen!');
        return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
    }
    
    public function ajaxuploadAction()
    {
        if ($this->getRequest()->isPost()) {
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            if (!isset($data['id'])) {
                
            }
            
            if ($data['id'] > 0) {
                $id = (int)$data['id'];
                $sendeFile = $this->fileService->getDb()->find('Application\Entity\SendeFile', $id);
                if (!file_exists($this->fileUploadService->getUploadPath() . $sendeFile)) {
                    
                }
                
                error_log(print_r($sendeFile, true));
            } else {
                header('Content-type: application/json');
                header('HTTP/ 404');
                echo json_encode(array('status' => 'OK'));
            }
            
            
            error_log(print_r($data, true));
        }
        header('Content-type: application/json');
        echo json_encode(array('status' => 'OK'));
        exit();
    }
    
    
    public function ajaxfileremoveAction()
    {
        
        if ($this->getRequest()->isPost()) {
            $data = $this->getRequest()->getPost()->toArray(); 
            if ((int)$data['uploadFileId'] > 0 && (int)$data['sendeFileId']) {
                $conn = $this->fileService->getDb()->getConnection();
                $conn->delete('sf_artwork', array('upload_file_id' => (int)$data['uploadFileId'], 'sf_id' => (int)$data['sendeFileId']));
                $file = $this->fileUploadService->getDb()->find('FileUpload\Entity\File', $data['uploadFileId']);
                exec('mv "' . $file->getFilePath() . $file->getFileName() . '" "' . $file->getFilePath().  $file->getFileName() . '_DELETED_' . $file->getId() . '"');
                $file->setDeleted(1);
                $this->fileUploadService->getDb()->persist($file);
                $this->fileUploadService->getDb()->flush();
                header('Content-type: application/json');
                echo json_encode(array('status' => 'OK'));
                exit();
            }
            
        }
        header('Content-type: application/json');
        header('HTTP/ 404');
        echo json_encode(array('status' => 'ERROR'));
        exit();
    }
    
    public function editAction()
    {
        $form = new \FileUpload\Form\SingleUpload('file-form');
        if ($this->getRequest()->isPost()) {
            $postData = $this->getRequest()->getPost()->toArray();
            if (!((int)$postData['id'] > 0)) {
                $this->flashMessenger()->addMessage('Die Aktion is ungültig!!');
                return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
            }
            $id = (int)$postData['id'];
            
            $file = $this->fileUploadService->getDb()->find('FileUpload\Entity\File', $id);
            
            if (!$file) {
                $this->flashMessenger()->addMessage('Die Datei ist nicht gefunden!!');
                return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
            }
            
            if (empty($postData['file_type']) || !in_array($postData['file_type'], \Application\Form\OptionsConfig::getFormOption('file_upload_type'))) {
                $this->flashMessenger()->addMessage('Die Dateityp ist nicht definiert!!');
                return $this->redirect()->toRoute('file-upload', array('action' => 'edit', 'id' => $id));
            }

            $file->setFileType($postData['file_type']);
            
            // Postback
            $data = array_merge_recursive(
                $this->getRequest()->getPost()->toArray(),
                $this->getRequest()->getFiles()->toArray()
            );
            $form->setData($data);
            if ($form->isValid()) {
                $formData = $form->getData();
                $originalName = $formData['file']['name'];
                $newName = htmlentities(strip_tags(str_replace(array(' '), array('_'), $formData['file']['name'])));
                if ($newName != $file->getFileName() && !file_exists($this->fileUploadService->getUploadPath() . $newName)) {
                    unlink($this->fileUploadService->getUploadPath() . $file->getFileName());
                    if (
                        rename(
                                $this->fileUploadService->getUploadTempPath() . $originalName,
                                $this->fileUploadService->getUploadPath() . $newName)
                    ) {
                        $file->setFileName($newName);
                    }
                } else {
                    // 
                    $this->flashMessenger()->addMessage('Die hochgeledene Datei ist bereits in System vorhaden unter anderem ID!!');
                    return $this->redirect()->toRoute('file-upload', array('action' => 'edit', 'id' => $id));
                }

            }
            $this->fileUploadService->getDb()->persist($file);
            $this->fileUploadService->getDb()->flush();
        } else {
            $id = (int)$this->params()->fromRoute('id', 0);
            if (!$id) {
                return $this->redirect()->toRoute('file-upload', array('action' => 'index'));
            }
            $file = $this->fileUploadService->getDb()->find('FileUpload\Entity\File', $id);
            $form->get('id')->setValue($file->getId());
            $form->get('file_type')->setValue($file->getFileType());
        }
        return array(
            'form' => $form,
            'file' => $file
        );
        
    }
    
    public function getFileUploadService()
    {
        return $this->fileUploadService;
    }

    public function setFileUploadService($fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
    
    public function getFileService()
    {
        return $this->fileService;
    }

    public function setFileService($fileService)
    {
        $this->fileService = $fileService;
    }




}