<?php

namespace Controller;

use Database\{Connection, Finder, Paginate, Service\UserService};

class HomeController extends BaseController
{
	public function handle()
	{	
        $userService = new UserService($this->connection);	
		
		$this->renderView('View\HomeView', []);
	}
}
