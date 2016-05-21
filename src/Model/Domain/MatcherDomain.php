<?php

namespace App\Model\Domain;

use App\Model\Contracts\IMatch;
use App\Model\Vo\Route;

class MatcherDomain {

	private $DEFAULT_URL = 'https://maps.googleapis.com/maps/api/geocode/json?';
	private $API_KEY = 'AIzaSyDBEIpAx7jqtYFT7eUBgPxvg_M4XkDwmHg';
	private $repository;

	public function __construct(IMatch $repository) {
		$this->repository = $repository;
	}

	public function getMatchFor(Route $route) {

		$routerDomain = new RouteDomain($route);

		return $this->repository->getPeopleNearOfThis($routerDomain);
	}

}