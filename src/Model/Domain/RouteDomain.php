<?php

namespace App\Model\Domain;

use App\Model\Vo\Address;
use App\Model\Vo\Route;

class RouteDomain {

	private $GEOCODE_URL = 'https://maps.googleapis.com/maps/api/geocode/json?';
	private $DIRECTIONS_URL = 'https://maps.googleapis.com/maps/api/directions/json?';
	private $API_KEY = 'AIzaSyDBEIpAx7jqtYFT7eUBgPxvg_M4XkDwmHg';

	private $start;
	private $end;
	private $distance;
	private $unit;
	private $peopleNearby;

	public function __construct(Route $route) {

		if ($route->isAddressRoute()) {
			$this->start = $this->getPositionsForAddress($route->getStartAddress());
		}

		$this->end = $this->getPositionsForAddress($route->getEndAddress());
		$this->distance = $this->getDistanceBetween($this->start, $this->end);
		$this->unit = 'meters';
	}

	private function getPositionsForAddress($address) {

		$url = $this->GEOCODE_URL.'address='.urlencode($address).'&key='.$this->API_KEY;
		$json = file_get_contents($url);
		$result = json_decode($json);

		if ($result->status != 'OK') {
			return null;
		}

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
		$url = $this->DIRECTIONS_URL.'origin=place_id:'.$start->getId().'&destination=place_id:'.$end->getId().'&key='.$this->API_KEY;
		$json = file_get_contents($url);
		$result = json_decode($json);

		return $result->routes[0]->legs[0]->distance->value;
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

