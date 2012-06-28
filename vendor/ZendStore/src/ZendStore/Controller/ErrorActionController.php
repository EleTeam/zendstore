<?php

namespace ZendStore\Controller;

/**
 * ZendStore front platform based action controller
 */
abstract class FrontActionController extends AbstractActionController
{
	/**
	 * Default layout template for front platform
	 * 
	 * @var string
	 */
	protected $layout = 'layout/front/default';
}