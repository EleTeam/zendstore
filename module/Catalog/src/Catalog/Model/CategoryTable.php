<?php

namespace Catalog\Model;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class CategoryTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'catalog_category';

	/**
	 * @var array
	 */
	protected $columns = array(
		'category_id',		'category_name',	'parent_id',		'is_active',		'sort_order',
		'type',				'created_date',		'updated_date',				
	);
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(ResultSet::TYPE_ARRAYOBJECT, new Category());
	
		$this->initialize();
	}
	
	/**
	 * Get a category
	 * 
	 * @param int $id
	 * @throws Exception\UnexpectedValueException
	 * @return Category
	 */
	public function getCategory($id)
	{
		$id = (int) $id;
		$resultSet = $this->select(array('category_id' => $id));
		$category  = $resultSet->current();
		
		if (! $category) {
			throw new Exception\UnexpectedValueException("Category $id doesn't exist");
		}
		
		return $category;
	}
	
	/**
	 * Get children of a category
	 * 
	 * @param int $id
	 * @param bool $recursive Get all children, if the value is set to true.
	 * @throws Exception\UnexpectedValueException
	 * @return \Zend\Db\ResultSet\ResultSet
	 */
	public function getCategoryChildren($id, $recursive = false)
	{
		$id = (int) $id;
		$resultSet = $this->select(array('parent_id' => $id));
		
		if (! $resultSet->count()) {
			throw new Exception\UnexpectedValueException("Category $id hasn't children");
		}
		
		return $resultSet;
	}
	
	/**
	 * Add or update a category
	 * 
	 * @param Category $category
	 * @return int
	 */
	public function saveCategory(Category $category)
	{
		if ($category->category_id) {
			return $this->updateCategory($category);
		} else {
			return $this->addCategory($category);
		}
	}
	
	/**
	 * Add a category
	 * 
	 * @param Category $category
	 * @return int
	 */
	public function addCategory(Category $category)
	{
		return $this->insert($category->toArray());
	}
	
	/**
	 * Update a category
	 * 
	 * @param Category $category
	 * @return int
	 */
	public function updateCategory(Category $category)
	{
		return $this->update($category->toArray(), $category->category_id);
	}
}