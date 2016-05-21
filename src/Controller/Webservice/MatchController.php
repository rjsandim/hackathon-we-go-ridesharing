<?php

namespace App\Controller\Webservice;

use App\Controller\AppController;
use App\Model\Domain\MatcherDomain;
use App\Model\Double\MatchDouble;
use App\Model\Vo\Route;

class MatchController extends AppController {
	/** @var  MatcherDomain */
	private $match;

	public function initialize() {
		parent::initialize();
		$this->viewBuilder()->layout('ajax');
		
		$this->match = new MatcherDomain(new MatchDouble());
	}

	public function getPeopleNearby($initLat, $initLon, $endAddress = null) {
		$route = new Route($initLat, $initLon, $endAddress);
		$result = $this->match->getMatchFor($route);
		$this->set("peoplesNearOfMe", $result);
	}


}