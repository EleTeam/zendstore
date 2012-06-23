<?php

namespace User\Model;

use Zend\Acl\Exception\InvalidArgumentException;

use Zend\Db\TableGateway\AbstractTableGateway,
	Zend\Db\Adapter\Adapter,
	Zend\Db\ResultSet\ResultSet;

class UserTable extends AbstractTableGateway
{
	/**
	 * @var string
	 */
	protected $table = 'user';
	
	/**
	 * @var array
	 */
	protected $columns = array(
		'user_id',		'email', 			'password', 		'password_salt', 	'username',
		'real_name', 	'register_date',	'register_ip', 		'last_login',		'last_ip', 
		'active', 		'enabled', 		
	);
	
	public function __construct(Adapter $adapter)
	{
		$this->adapter = $adapter;
		$this->resultSetPrototype = new ResultSet(new User());
	
		$this->initialize();
	}
	
	/**
	 * Get a user
	 * 
	 * @param int $userId
	 * @throws Exception\UnexpectedValueException
	 * @return User
	 */
	public function getUser($userId)
	{
		$userId = (int)$userId;
		$rowSet = $this->select(array('user_id' => $userId));
		$row 	= $rowSet->current();
		if (!$row) {
			throw new Exception\UnexpectedValueException("User $userId doesn't exist");
		}
		
		return new User($row->getArrayCopy());
	}
	
	public function saveUser(User $user)
	{
		if ($user->user_id) {
			$this->updateUser($user);
		} else {
			$this->addUser($user);
		}
	}
	
	public function addUser(User $user)
	{
		$this->insert($user->getArrayCopy());
	}
	
	public function updateUser(User $user)
	{
		$this->update($user->toArray(), $user->user_id);
	}
	
}