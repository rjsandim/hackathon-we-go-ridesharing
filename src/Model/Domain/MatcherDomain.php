<?php

namespace App\Model\Domain;

use App\Model\Services\GoogleMaps;
use App\Model\Table\RoutesTable;
use App\Model\Vo\Address;
use App\Model\Vo\Route;
use Cake\Error\Debugger;

class MatcherDomain {

	private $maps;
	/** @var  Address */
	private $start;
	/** @var  Address */
	private $end;
	private $distance;
	private $unit;
	/** @var  RoutesTable */
	private $repository;

	public function __construct($repository) {

		$this->repository = $repository;
		$this->maps = new GoogleMaps();
		$this->unit = 'meters';
	}

	public function getMatchFor(Route $route) {

		if ($route->isAddressRoute()) {
			$this->start = $this->getPositionsForAddress($route->getStartAddress());
		}

		$this->end = $this->getPositionsForAddress($route->getEndAddress());
		$this->distance = $this->getDistanceBetween($this->start, $this->end);

		$peopleNear = $this->repository->getPeopleNearOfThis($this);

		$results = $this->findBestsRoutes($this->start, $this->end, $peopleNear);

		if (count($results) == 0) {
			$this->repository->saveNewRoute($this);
		}

		return [
			'unit' => $this->unit,
			'route' => [
				'startedAt' => $this->start->getFormattedAddress(),
				'endedAt' => $this->end->getFormattedAddress(),
				'distance' => $this->distance
			],
			'people' => $results
		];
	}

	private function getPositionsForAddress($address) {

		$result = $this->maps->getPossibleAddresses($address);

		$firstResult = $result->results[0];
		$placeId = $firstResult->place_id;
		$location = $firstResult->geometry->location;
		$ac = $firstResult->address_components;

		$address = [
			'formatted_address' => $firstResult->formatted_address,
			'postcode' => $this->getProperty($ac, 'postal_code'),
			'country' => $this->getProperty($ac, 'country'),
			'state' => $this->getProperty($ac, 'administrative_area_level_1'),
			'city' => $this->getProperty($ac, 'administrative_area_level_2'),
			'neighborhood' => $this->getProperty($ac, 'sublocality_level_1'),
			'street' => $this->getProperty($ac, 'route'),
			'number' => $this->getProperty($ac, 'street_number'),
			'lat' => $location->lat,
			'lng' => $location->lng,
			'id' => $placeId
		];

		return new Address($address);

	}

	private function getProperty(array $address, $filter) {

		foreach ($address as $property) {
			if ($property->types[0] == $filter) {
				return $property->long_name;
			}
		}

		return '';
	}

	private function getDistanceBetween(Address $start, Address $end)  {
		$result = $this->maps->getDirectionsBetweenPlaceIds($start->getId(), $end->getId());
		return $result->routes[0]->legs[0]->distance->value;
	}

	private function findBestsRoutes(Address $start, Address $end, $routes) {

		$directions = [];

		foreach ($routes as $route) {

			$directions[] = [
				'route' => $start->getFormattedAddress().' to '.$route->start_formated.' to '.$end->getFormattedAddress().' to'.$route->end_formated,
				'getFirst' => 'you',
				'goesDownFirst' => 'you',
				'wayWithYou' => $this->distanceRoute($start->getId(), $end->getId(), ['place_id:'.$route->start_id])

			];

			$directions[] = [
				'route' => $start->getFormattedAddress().' to '.$route->start_formated.' to '.$route->end_formated.' to'.$end->getFormattedAddress(),
				'getFirst' => 'you',
				'goesDownFirst' => 'him',
				'wayWithYou' => $this->distanceRoute($start->getId(), $end->getId(), ['place_id:'.$route->start_id, 'place_id:'.$route->end_id])
			];

			$directions[] = [
				'route' => $route->start_formated.' to '.$start->getFormattedAddress().' to '.$end->getFormattedAddress().' to'.$route->end_formated,
				'getFirst' => 'him',
				'goesDownFirst' => 'you',
				'wayWithYou' => $this->getDistance()
			];

			$directions[] = [
				'route' => $route->start_formated.' to '.$start->getFormattedAddress().' to '.$route->end_formated.' to'.$end->getFormattedAddress(),
				'getFirst' => 'him',
				'goesDownFirst' => 'him',
				'wayWithYou' => $this->distanceRoute($start->getId(), $end->getId(), ['place_id:'.$route->end_id])
			];

		}

		usort($directions, function($a, $b) {
			return $a['wayWithYou'] <=> $b['wayWithYou'];
		});


		return $directions;
	}


	public function cmp($a, $b) {
		return $a["wayWithYou"] < $b["wayWithYou"];
	}

	private function distanceRoute($start, $end, array $waypoints) {
		
		$result = $this->maps->getDirectionsBetweenPlaceIdsWithWaypoints($start, $end, $waypoints);

		$distance = 0;
		foreach ($result->routes[0]->legs as $distances) {
			$distance += $distances->distance->value;
		}
		
		return $distance;
		
	}

	private function getPeoplenNearby($start, $end) {

		return [
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
		];

	}

	public function getUnit() {
		return $this->unit;
	}

	public function getDistance() {
		return $this->distance;
	}

	public function getStart() {
		return $this->start;
	}

	public function getEnd() {
		return $this->end;
	}
}