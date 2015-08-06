<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Zend\Session\Container;
/**
 * Description of FileController
 *
 * @author aqnguyen
 */
class FighterController extends AbstractActionController
{
    
    /*
     * @var \Application\Service\FileService $archiveFileService
     */
    protected $archiveFileService;
    
    /*
     * @var \Application\Service\FighterService $fighterService
     */
    protected $fighterService;
    
    
    public function removeAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        
        if (!$id) {
            $this->flashMessenger()->addMessage('Ungültge Id vom Kämpfer!');
            return $this->redirect()->toRoute('fighter', array('action' => 'index')); 
        }
        $result = $this->fighterService->checkFighterInOtherTable($id);
        if (!$result) {
            $this->flashMessenger()->addMessage('Ungültge Id vom Kämpfer!');
            return $this->redirect()->toRoute('fighter', array('action' => 'index')); 
        } else {
            if (!$result['archive_file_id'] && !$result['sende_file_id']) {
                $fighter = $this->fighterService->getDb()->find('Application\Entity\Fighter', (int)$id);
                if ($fighter) {
                    $fighter->setDeleted(1);
                    $this->fighterService->getDb()->persist($fighter);
                    $this->fighterService->getDb()->flush();
                    $this->flashMessenger()->addMessage('Kämpfer ' . $fighter->getfullname() . ' wurde gelöscht.');
                    return $this->redirect()->toRoute('fighter', array('action' => 'index')); 
                }
            }            
            $msg = '';
            if ($result['sende_file_id']) {
                $msg .= 'Kämpfer ist in der Benutzung von Sende-Datei (' . $result['sende_file_id'] . '). ';
            }
            if ($result['archive_file_id']) {
                $msg .= 'Kämpfer ist in der Benutzung von Archiv-Datei (' . $result['archive_file_id'] . '). ';
            }
            $this->flashMessenger()->addMessage($msg);
            return $this->redirect()->toRoute('fighter', array('action' => 'index')); 
        }
        return $this->redirect()->toRoute('fighter', array('action' => 'index')); 
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
            $actionParams['page'] = 1;
            return $this->redirect()->toRoute('fighters', $actionParams);
        }
        
        $page = $this->params()->fromRoute('page', 1);
        # move to service
        $limit = $this->params()->fromRoute('limit', 20);
        $offset = ($page == 0) ? 0 : ($page - 1) * $limit;
        
        $fighters = $this->fighterService->getPagedFighters($offset, $limit);
        
        $viewArray = array(
            'fighters' => $fighters,
            'page' => $page,
            'limit' => $limit            
        );
        
        return new ViewModel(
            $viewArray
        );
        
        return new ViewModel(array('fighters' => $fighters)); 
    }
    
    public function newAction()
    {
        if ($this->request->isPost()) {
            $data = $this->request->getPost();
            $rawData = $data->toArray();
            $fighter = new \Application\Entity\Fighter();
            $fighter->setRawData($rawData);
            $fighter->setFullname($fighter->getFirstname() . ' ' . $fighter->getLastname());
            $fighter->setLastnameShortcut(substr($fighter->getLastname(), 0, 3));
            $this->fighterService->getDb()->persist($fighter);
            $this->fighterService->getDb()->flush();
            return $this->redirect()->toRoute('fighter', array('action' => 'edit', 'id' => $fighter->getId()));
        }
    }
    
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if (!$id && !$this->request->getPost()) {
            return $this->redirect()->toRoute('fighter', array('action' => 'index'));
        }
        
        if ($id && !$this->request->isPost()) {
            $fighter = $this->fighterService->getFighter($id);
            return new ViewModel(array('fighter' => $fighter));
        }
        if ($this->request->isPost()) {             
            $data = $this->request->getPost();
            if (!$data->id) {
                return $this->redirect()->toRoute('fighter', array('action' => 'index'));
            }
            $fighter = $this->fighterService->getFighter($data->id);
            $rawData = $data->toArray();
            unset($rawData['id']);
            $fighter->setRawData($rawData);
           // $fighter->setLastnameShortcut(substr($fighter->getLastname(), 0, 3));
            $fighter->setFullname($fighter->getFirstname() . ' ' . $fighter->getLastname());
            $this->fighterService->save($fighter);
            return $this->redirect()->toRoute('fighter', array('action' => 'edit', 'id' => $fighter->getId()));
        }
        return $this->redirect()->toRoute('fighter', array('action' => 'index'));

    }
    
    

    
    
    
    
    
    
    
    
    
    
    
    function getArchiveFileService()
    {
        return $this->archiveFileService;
    }

    function setArchiveFileService($archiveFileService)
    {
        $this->archiveFileService = $archiveFileService;
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
