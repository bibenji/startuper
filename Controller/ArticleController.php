<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\UserService};

class ArticleController extends BaseController
{
	public function handle()
	{	
		$this->renderView('View\ArticleView', []);
	}
}
