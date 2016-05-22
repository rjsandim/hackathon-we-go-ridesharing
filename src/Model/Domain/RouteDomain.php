<?php

namespace App\Model\Domain;

use App\Model\Contracts\IMaps;
use App\Model\Vo\Address;
use App\Model\Vo\Route;

class RouteDomain {

	private $maps;
	private $start;
	private $end;
	private $distance;
	private $unit;


	public function __construct(Route $route, IMaps $maps) {

		$this->maps = $maps;

		if ($route->isAddressRoute()) {
			$this->start = $this->getPositionsForAddress($route->getStartAddress());
		}

		$this->end = $this->getPositionsForAddress($route->getEndAddress());
		$this->distance = $this->getDistanceBetween($this->start, $this->end);
		$this->unit = 'meters';
	}



	private function getPositionsForAddress($address) {

		$result = $this->maps->getPossibleAddresses($address);

		$firstResult = $result->results[0];
		$placeId = $firstResult->place_id;
		$location = $firstResult->geometry->location;
		$ac = $firstResult->address_components;

		$address = [
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

	private function getPeoplenNearby($start, $end) {


	}

	public function getUnit() {
		return $this->unit;
	}

	public function getDistance() {
		return $this->distance;
	}

	public function getStringStartAddress() {
		return $this->start->toString();
	}

	public function getStringEndAddress() {
		return $this->end->toString();
	}

}

