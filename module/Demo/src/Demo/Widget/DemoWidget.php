<?php

namespace Demo\Widget\Article;

use Zend\View\Helper\AbstractHelper;

class ArticleWidget extends AbstractHelper
{
	public function __construct()
	{
	}
	
	public function widget()
	{
		return '<h1>article widget</h1>';
	}
}