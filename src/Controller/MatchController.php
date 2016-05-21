<?php

namespace App\Controller;

use App\Model\Domain\MatcherDomain;
use App\Model\Double\MatchDouble;
use App\Model\Dto\Route;

class MatchController extends AppController {
	/** @var  MatcherDomain */
	private $match;

	public function initialize() {
		parent::initialize();
		$this->viewBuilder()->layout('ajax');


		$this->match = new MatcherDomain(new MatchDouble());
	}

	public function getPartner($initLat, $initLon, $lat, $lon) {
		$route = new Route($initLat, $initLon, $lat, $lon);
		$result = $this->match->getMatchFor($route);
		$this->set("peoplesNearOfMe", $result);
	}


}