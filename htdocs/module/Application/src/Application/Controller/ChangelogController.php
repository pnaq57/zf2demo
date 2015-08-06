<?php
namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;

class ChangelogController extends AbstractActionController
{
    protected $changeLogService;
    
    public function getChangeLogService()
    {
        return $this->changeLogService;
    }

    public function setChangeLogService($changeLogService)
    {
        $this->changeLogService = $changeLogService;
    }
        
    
    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($this->request->isPost()) {
            $data = $this->getRequest()->getPost();
            $data = $data->toArray();
            $this->changeLogService->updateChangelog($data['id'], $data);
            return $this->redirect()->toRoute('changelog', array(
                'action' => 'edit',
                'id' =>  $data['id']
            ));
        }
        
        if ($id > 0) {
            $changeLogs = $this->changeLogService->getChangeLogsWithProjectById($id);
            if ($changeLogs) {
                $changeLog = reset($changeLogs);
            }
            return new ViewModel(array('changeLog' => $changeLog));
        }
    }

    public function newAction()
    {
        
        $projectId = (int) $this->params()->fromRoute('id', 0);

        if ($this->request->isPost()) {
            $data = $this->getRequest()->getPost();
            $data = $data->toArray();

            $result = $this->changeLogService->createChangelog($data);

            return $this->redirect()->toRoute('projects', array(
                'action' => 'show',
                'id' =>  $data['projectId']
            ));
        }
        return new ViewModel(array('projectId' => $projectId));
    }

    
    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $projectId = (int) $this->params()->fromRoute('projectId', 0);

        if ($id > 0) {
            $result = $this->changeLogService->removeChangelog($id);

            return $this->redirect()->toRoute('projects', array(
                'action' => 'show',
                'id' =>  $projectId
            ));
        }
        return new ViewModel(array('projectId' => $projectId));
    }

}
