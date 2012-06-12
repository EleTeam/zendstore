<?php

namespace Media\Model;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class UploadedFileTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'media_uploaded_file';
	
	/**
	 * @var array
	 */
	protected $columns = array();
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(new UploadedFile());
		
		$this->initialize();
	}
	
	/**
	 * Add uploaded file
	 * 
	 * @param UploadedFile $uploadedFile
	 * @return int
	 */
	public function addFile(UploadedFile $uploadedFile)
	{
		
	}
}