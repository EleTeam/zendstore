<?php

namespace ZendStore\Controller;

/**
 * ZendStore admin platform based action controller
 */
abstract class AbstractAdminActionController extends AbstractStoreActionController
{
	/**
	 * Default layout template for admin platform
	 *
	 * @var string
	 */
	protected $layout = 'layout/admin/default';
}