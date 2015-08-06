<?php
namespace AppApi\Controller;
use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;
/**
 * Description of FileController
 *
 * @author aqnguyen
 */ 
class FileController extends AbstractRestfulJsonController
{
    protected $fileService;
    
    function getFileService()
    {
        return $this->fileService;
    }

    function setFileService($fileService)
    {
        $this->fileService = $fileService;
    }
    
    public function get($id)
    {   
        $id = (int)$this->params('id', 0);
        $status = $this->params('status', 'ReadyToConvert');
        $searchData = array();
        if ($id > 0) {
            $searchData['id'] = $id;
            $files = $this->fileService->getFilesByStatus($status);
            if ($files) {
                $files = array($files);
            }
        } else {
            $searchData['status'] = $status;
            $files = $this->fileService->getFilesByStatus($status);
        }
        
        $jsonFiles = array();
        if (count($files) > 0) {
            foreach ($files as $f) {
                $jsonFiles[$f['fileIndexId']] = array('id' => $f['fileIndexId']);
                if (isset($f['sendeFileId'])) {
                     $jsonFiles[$f['fileIndexId']]['id'] = $f['sendeFileId'];
                     $jsonFiles[$f['fileIndexId']]['name'] = $f['sendeFileName'];
                     $jsonFiles[$f['fileIndexId']]['storage'] = $f['sendeStorage'];
                     $jsonFiles[$f['fileIndexId']]['type'] = $f['type'];
                     $jsonFiles[$f['fileIndexId']]['status'] = $f['status'];
                } else {
                     $jsonFiles[$f['fileIndexId']]['id'] = $f['fileIndexId'];
                     $jsonFiles[$f['fileIndexId']]['name'] = $f['archiveFileName'];
                     $jsonFiles[$f['fileIndexId']]['storage'] = $f['archiveStorage'];
                     $jsonFiles[$f['fileIndexId']]['type'] = $f['type'];
                     $jsonFiles[$f['fileIndexId']]['status'] = $f['status'];
                }
            }
            
        }
        return new JsonModel(
            array(
                'result' => $jsonFiles,
                'status' => 'OK',
                'resultCount' => count($jsonFiles)
            )
        );
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        if ($data['sende']) {
            $this->fileService->getDb('Application\entity\SendeFile', $id);
        } else {
            $file = $this->fileService->getArchiveFileById($id);
        }
        
        $file->setRawData($data);
        $fileIndex = $file->getFileIndex();
        $fileIndex->setStatus($file->getStatus());
        $this->fileService->getDb()->persist($fileIndex);
        $this->fileService->getDb()->persist($file);
        $this->fileService->getDb()->flush();
        //error_log(print_r($data, true));
        return new JsonModel(array('status' => 'OK'));
    }

    public function delete($id)
    {   // Action used for DELETE requests
        return new JsonModel(array('data' => 'album id 3 deleted'));
    }
    
    
    public function getTranslateService()
    {
        return $this->translateService;
    }

    public function setTranslateService($translateService)
    {
        $this->translateService = $translateService;
    }


}
