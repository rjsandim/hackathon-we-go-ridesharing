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
					'id' => '2e6f9b0d5885b6110f9167787445617f553a735f',
					'name' => 'Nick0',
					'wayWithYou' => '7',
					'getFirst' => 'you',
					'goesDownFirst' => 'you',
					'paymentMethod' => 'credit-card'
				],
				[
					'id' => '2e6f9b0d5885b6110f9167787445617f553a735f',
					'name' => 'Nick1',
					'wayWithYou' => '9',
					'getFirst' => 'him',
					'goesDownFirst' => 'him',
					'paymentMethod' => 'cash'
				],
				[
					'id' => '2e6f9b0d5885b6010f9117787445617f553a735f',
					'name' => 'Nick2',
					'wayWithYou' => '11',
					'getFirst' => 'you',
					'goesDownFirst' => 'you'
				],
				[
					'id' => '2e6f9b0d5885b6010f9167787411617f553a735f',
					'name' => 'Nick3',
					'wayWithYou' => '13',
					'getFirst' => 'you',
					'goesDownFirst' => 'her'
				],
				[
					'id' => '2e6f9b0d5885b6010f9167787445617f5532235f',
					'name' => 'Nick4',
					'wayWithYou' => '17',
					'getFirst' => 'him',
					'goesDownFirst' => 'you'
				],
				[
					'id' => '2e6f9b0d5885b6010f9167787445617f553a7325f',
					'name' => 'Nick5',
					'wayWithYou' => '19',
					'getFirst' => 'him',
					'goesDownFirst' => 'you'
				]
			]
		];
	}
}