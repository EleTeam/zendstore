<?php

namespace Album\Controller\Front;

use ZendStore\Controller\AbstractFrontActionController;
use Album\Model\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractFrontActionController
{
    protected $albumTable;

    public function indexAction()
    {
    	$viewModel = $this->getViewModel();
    	
        return $viewModel->setVariables(array(
            'albums' => $this->getAlbumTable()->fetchAll(),
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

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('Album\Model\AlbumTable');
        }
        return $this->albumTable;
    }    
}
