<?php

namespace App\Model\Table;

use App\Model\Contracts\IMatch;
use App\Model\Dto\Route;
use Cake\ORM\Table;

class MatchTable extends Table implements IMatch
{

	public function getPeopleNearOfThis(Route $route) {
		// TODO: Implement getPeopleNearOfThis() method.
	}
}