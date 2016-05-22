<?php

namespace App\Model\Services;

use App\Model\Contracts\IMaps;

class GoogleMaps implements IMaps {

	private $URL_GEOCODE = 'https://maps.googleapis.com/maps/api/geocode/json?';
	private $URL_DIRECTIONS = 'https://maps.googleapis.com/maps/api/directions/json?';
	private $API_KEY = 'AIzaSyDBEIpAx7jqtYFT7eUBgPxvg_M4XkDwmHg';
	private $parameters;

	public function getPossibleAddresses($address) {
		return $this->newRequest()->addParameter('address', urlencode($address))->builGeocode();
	}

	public function getDirectionsBetweenPlaceIds($startId, $endId) {
		return $this->newRequest()->addParameter('origin', 'place_id:'.$startId)->addParameter('destination', 'place_id:'.$endId)->buildDirections();
	}

	public function getDirectionsBetweenPlaceIdsWithWaypoints($start, $end, array $waypoints) {

		return $this->newRequest()
			->addParameter('origin', 'place_id:'.$start)
			->addParameter('destination', 'place_id:'.$end)
			->addParameter('waypoints', implode('|', $waypoints))
			->buildDirections();
	}

	private function newRequest() {
		$this->parameters = [];
		$this->addParameter('key', $this->API_KEY);
		return $this;
	}

	private function addParameter($key, $value) {
		$this->parameters[$key] = $value;
		return $this;
	}

	private function builGeocode() {
		$url = $this->URL_GEOCODE.$this->getParameters();
		return $this->makeRequest($url);
	}

	private function buildDirections() {
		$url = $this->URL_DIRECTIONS.$this->getParameters();
		return $this->makeRequest($url);
	}

	private function getParameters() {
		$query = [];

		foreach ($this->parameters as $key => $value) {
			$query[] = $key.'='.$value;
		}

		return implode('&', $query);
	}

	private function makeRequest($url) {
		$json = file_get_contents($url);
		$result = json_decode($json);

		if ($result->status != 'OK') {
			return null;
		}
		return $result;
	}
}