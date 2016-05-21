<?php

namespace App\Model\Domain;

use App\Model\Contracts\IMatch;
use App\Model\Dto\Route;

class MatcherDomain {

	private $repository;

	public function __construct(IMatch $repository) {
		$this->repository = $repository;
	}

	public function getMatchFor(Route $route) {
		return $this->repository->getPeopleNearOfThis($route);
	}
}