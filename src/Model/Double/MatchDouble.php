<?php

namespace App\Model\Double;

use App\Model\Contracts\IMatch;
use App\Model\Dto\Route;

class MatchDouble implements IMatch{

	public function getPeopleNearOfThis(Route $route) {
		return [
			'unit' => 'km',
			'route' => [
				'startedAt' => 'Street 13123, NY',
				'endedAt' => 'Streed, 1223, MY',
				'distance' => '9'
			],
			'people' => [
				[
					'name' => 'Nick0',
					'wayWithYou' => '7',
					'getFirst' => 'you',
					'goesDownFirst' => 'you',
					'paymentMethod' => 'credit-card'
				],
				[
					'name' => 'Nick1',
					'wayWithYou' => '9',
					'getFirst' => 'him',
					'goesDownFirst' => 'him',
					'paymentMethod' => 'cash'
				],
				[
					'name' => 'Nick2',
					'wayWithYou' => '11',
					'getFirst' => 'you',
					'goesDownFirst' => 'you'
				],
				[
					'name' => 'Nick3',
					'wayWithYou' => '13',
					'getFirst' => 'you',
					'goesDownFirst' => 'her'
				],
				[
					'name' => 'Nick4',
					'wayWithYou' => '17',
					'getFirst' => 'him',
					'goesDownFirst' => 'you'
				],
				[
					'name' => 'Nick5',
					'wayWithYou' => '19',
					'getFirst' => 'him',
					'goesDownFirst' => 'you'
				]
			]
		];
	}
}