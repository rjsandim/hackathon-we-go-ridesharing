<?php

namespace App\Controller\Webservice;

use App\Controller\AppController;
use App\Model\Domain\MatcherDomain;
use App\Model\Vo\Route;
use Cake\ORM\TableRegistry;

class MatchController extends AppController {
	/** @var  MatcherDomain */
	private $match;

	public function initialize() {
		parent::initialize();
		$this->viewBuilder()->layout('ajax');

		$routes = TableRegistry::get('Routes');
		$this->match = new MatcherDomain($routes);
	}

	public function getPeopleNearby($initLat, $initLon, $endAddress = null) {
		$route = new Route($initLat, $initLon, $endAddress);
		
		$result = $this->match->getMatchFor($route);
		
		$this->set(compact("result"));
	}


}