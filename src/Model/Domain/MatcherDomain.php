<?php

namespace App\Model\Domain;

use App\Model\Contracts\IMatch;
use App\Model\Services\GoogleMaps;
use App\Model\Vo\Route;

class MatcherDomain {

	private $repository;

	public function __construct(IMatch $repository) {
		$this->repository = $repository;
		$this->mapsService = new GoogleMaps();
	}

	public function getMatchFor(Route $route) {

		$routerDomain = new RouteDomain($route, $this->mapsService);

		return $this->repository->getPeopleNearOfThis($routerDomain);
	}

}