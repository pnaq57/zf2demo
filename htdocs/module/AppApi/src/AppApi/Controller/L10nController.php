<?php
namespace AppApi\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use Zend\View\Model\JsonModel;

class L10nController extends AbstractRestfulJsonController
{
    protected $translateService;


    public function getList()
    {
        return new JsonModel(array('data' => "Welcome to the Zend Framework Album API example"));
    }
    
    public function get($id)
    {   
        $table = $this->params('table', 0);
        $id = $this->params('id', 0);
        $version = $this->params('version', 0);

        if ($id && $id != 'all') {
            $result = $this->translateService->getCurrentVersionByTable($id);
            return new JsonModel(array("data" => array('id'=> $id, 'table' => $table, 'result' => $result[0])));
        } elseif ($id == 'all') {
            $result = $this->translateService->getAllTranslationFromTable($table);
            return new JsonModel(array("data" => array('id'=> $id, 'table' => $table, 'result' => $result)));
        } elseif ($version) {
            $result = $this->translateService->getAllTranslationFromTable($table, $version);
            return new JsonModel(array("data" => array('id'=> $id, 'table' => $table, 'result' => $result)));
        }         

        return new JsonModel(array("data" => array('id'=> $id, 'table' => $table, 'result' => $result[0])));
    }

    public function create($data)
    {   // Action used for POST requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'New Album', 'band' => 'New Band')));
    }

    public function update($id, $data)
    {   // Action used for PUT requests
        return new JsonModel(array('data' => array('id'=> 3, 'name' => 'Updated Album', 'band' => 'Updated Band')));
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