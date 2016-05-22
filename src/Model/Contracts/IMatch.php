<?php

namespace App\Model\Contracts;

use App\Model\Domain\MatcherDomain;

interface IMatch {
	public function getPeopleNearOfThis(MatcherDomain $route);
}