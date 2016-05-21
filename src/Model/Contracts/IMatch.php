<?php

namespace App\Model\Contracts;

use App\Model\Domain\RouteDomain;

interface IMatch {
	public function getPeopleNearOfThis(RouteDomain $route);
}