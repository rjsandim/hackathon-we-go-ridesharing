<?php

namespace App\Model\Contracts;

use App\Model\Dto\Route;

interface IMatch {
	public function getPeopleNearOfThis(Route $route);
}