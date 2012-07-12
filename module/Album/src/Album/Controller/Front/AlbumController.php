<?php

namespace Album\Controller\Front;

use ZendStore\Controller\AbstractFrontActionController;

use Album\Model\AlbumTable;
use Album\Model\Album;
use Album\Form\AlbumForm;

class AlbumController extends AbstractFrontActionController
{
    /**
     * @var \Album\Model\AlbumTable
     */
    protected $albumTable;

    public function indexAction()
    {
    	$viewModel = $this->getViewModel();
    	$viewVars  = array(
    		'albums' => $this->getAlbumTable()->fetchAll(),
    	);
    	$viewModel->setVariables($viewVars);
    	
    	return $viewModel;
    }

    public function addAction()
    {
        $form = new AlbumForm();
        $form->get('submit')->setAttribute('value', 'Add');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $album = new Album();
            $form->setInputFilter($album->getInputFilter());
            $form->setData($request->post());
            if ($form->isValid()) {

                $album->populate($form->getData());
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album-front-album');

            }
        }
        
        $viewVars = array(
        	'form' => $form,
        );
        $viewModel = $this->getViewModel();
        $viewModel->setVariables($viewVars);
        
        return $viewModel;
    }

    public function editAction()
    {
    	$viewModel = $this->getViewModel();
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('album-front-album', array('action'=>'add'));
        }
        
        $album = $this->getAlbumTable()->getAlbum($id);

        $form = new AlbumForm();
        $form->setBindOnValidate(false);
        $form->bind($album);
        $form->get('submit')->setAttribute('label', 'Edit');
        
        $request = $this->getRequest();
        if ($request->isPost()) {
            $form->setData($request->post());
            if ($form->isValid()) {
                $form->bindValues();
                $this->getAlbumTable()->saveAlbum($album);

                // Redirect to list of albums
                return $this->redirect()->toRoute('album-front-album');
            }
        }

        $viewVars = array(
        	'id' 	=> $id,
        	'form'	=> $form,
        );
        $viewModel->setVariables($viewVars);
        
        return $viewModel;
    }

    public function deleteAction()
    {
        $id = (int) $this->getEvent()->getRouteMatch()->getParam('id');
        if (!$id) {
            return $this->redirect()->toRoute('album-front-album');
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            $del = $request->post()->get('del', 'No');
            if ($del == 'Yes') {
                $id = (int)$request->post()->get('id');
                $this->getAlbumTable()->deleteAlbum($id);
            }

            // Redirect to list of albums
            return $this->redirect()->toRoute('album-front-album');
        }

        $viewVars  = array(
        	'id' 	=> $id,
        	'album' => $this->getAlbumTable()->getAlbum($id),
        );
        $viewModel = $this->getViewModel();
        $viewModel->setVariables($viewVars);
        
        return $viewModel;
    }

    public function setAlbumTable(AlbumTable $albumTable)
    {
        $this->albumTable = $albumTable;
        return $this;
    }

    public function getAlbumTable()
    {
        if (!$this->albumTable) {
            $sm = $this->getServiceLocator();
            $this->albumTable = $sm->get('album-table');
        }
        return $this->albumTable;
    }
}