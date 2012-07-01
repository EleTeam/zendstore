<?php

namespace ZendStore\Controller;

/**
 * ZendStore error page based action controller
 */
abstract class AbstractErrorActionController extends AbstractStoreActionController
{
	/**
	 * Default layout template for error page
	 * 
	 * @var string
	 */
	protected $layout = 'layout/error/default';
}