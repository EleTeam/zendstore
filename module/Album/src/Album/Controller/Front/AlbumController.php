<?php

namespace Album\Controller\Front;

use ZendStore\Controller\AbstractFrontActionController;
use Doctrine\ORM\EntityManager;
use Album\Form\AlbumForm;
use Album\Entity\Album;

class AlbumController extends AbstractFrontActionController
{
	/**
	 * @var EntityManager
	 */
    protected $em;

    public function indexAction()
    {
    	$viewModel = $this->getViewModel();
    	$em = $this->getEntityManager();

        return $viewModel->setVariables(array(
            'albums' => $this->getEntityManager()->getRepository('Album\Entity\Album')->findAll(),
        ));
    }

    public function addAction()
    {
    	$viewModel = $this->getViewModel();
    	
        $form = new AlbumForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $album->exchangeArray($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album-front-album');
            }
        }

        return $viewModel->setVariables(array(
			'form' => $form,
        ));
    }

    public function editAction()
    {
    	$viewModel = $this->getViewModel();
    	
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('album', array('action'=>'add'));
        }
        $album = $this->getAlbumTable()->getAlbum($id);

        $form = new AlbumForm();
        $form->bind($album);
        $form->get('submit')->setAttribute('value', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
        	//$form->setInputFilter($album->getInputFilter());
            $form->setData($request->getPost());
            if ($form->isValid()) {
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album-front-album');
            }
        }

        return $viewModel->setVariables(array(
            'id' => $id,
            'form' => $form,
        ));        
    }

    public function deleteAction()
    {
    	$viewModel = $this->getViewModel();
    	
        $id = (int)$this->params('id');
        if (!$id) {
            return $this->redirect()->toRoute('album-front-album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->getPost()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->getPost()->get('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album-front-album');
        }

        return $viewModel->setVariables(array(
            'id' => $id,
            'album' => $this->getAlbumTable()->getAlbum($id)
        ));
    }

    /**
     * Get entity manager
     * 
     * @return EntityManager
     */
    public function getEntityManager()
    {
        if (is_null($this->em)) {
            $sm = $this->getServiceLocator();
            $this->em = $sm->get('doctrine.entitymanager.orm_default');
        }
        
        return $this->em;
    }    
    
    public function setEntityManager(EntityManager $em)
    {
    	$this->em = $em;	
    }
    
}
