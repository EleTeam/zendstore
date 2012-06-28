<?php

namespace ZendStore\Controller;

/**
 * ZendStore admin platform based action controller
 */
abstract class AdminActionController extends AbstractActionController
{
	/**
	 * Default layout template for admin platform
	 *
	 * @var string
	 */
	protected $layout = 'layout/admin/default';
}