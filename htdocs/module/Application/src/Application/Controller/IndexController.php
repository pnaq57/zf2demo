<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2014 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Application\Entity\User;

class IndexController extends AbstractActionController
{
    protected $_objectManager;
    
    protected $changeLogService;

    public function indexAction()
    {
        
    }
    
    public function addAction()
    {
        if ($this->request->isPost()) {
            $user = new User();
            $user->setFullName($this->getRequest()->getPost('fullname'));

            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();
            $newId = $user->getId();

            return $this->redirect()->toRoute('home');
        }
        return new ViewModel();
    }

    public function newAction()
    {
        if ($this->request->isPost()) {

        }
        return new ViewModel();
    }
    
    public function showAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        if ($id > 0) {
            $changeLogs = $this->changeLogService->getChangeLogsByProjectId($id);
            return new ViewModel(
                array(
                    'changeLogs' => $changeLogs,
                    'projectId' => $id
                ));
        }
        
        return new ViewModel();
    }

    public function editAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getObjectManager()->find('\Application\Entity\User', $id);

        if ($this->request->isPost()) {
            $user->setFullName($this->getRequest()->getPost('fullname'));

            $this->getObjectManager()->persist($user);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('user' => $user));
    }

    public function deleteAction()
    {
        $id = (int) $this->params()->fromRoute('id', 0);
        $user = $this->getObjectManager()->find('\Application\Entity\User', $id);

        if ($this->request->isPost()) {
            $this->getObjectManager()->remove($user);
            $this->getObjectManager()->flush();

            return $this->redirect()->toRoute('home');
        }

        return new ViewModel(array('user' => $user));
    }

    protected function getObjectManager()
    {
        if (!$this->_objectManager) {
            $this->_objectManager = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }

        return $this->_objectManager;
    }
    
    
    public function getChangeLogService()
    {
        return $this->changeLogService;
    }

    public function setChangeLogService($changeLogService)
    {
        $this->changeLogService = $changeLogService;
    }


}