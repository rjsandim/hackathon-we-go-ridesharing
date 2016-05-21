<?php

namespace App\Model\Vo;

class Route {

	const ROUTING_BY_ADDRESS = 'ADDRESS';
	const ROUTING_BY_POSITION = 'POSITION';

	private $typeStartRoute;
	private $initLat;
	private $initLon;
	private $startAddress;
	private $endAddress;

	public function __construct($initLat, $initLon, $endAddress = null) {

		if ($endAddress == null) {
			$this->initLat = 0;
			$this->initLon = 0;
			$this->startAddress = $initLat;
			$this->endAddress = $initLon;
			$this->typeStartRoute = self::ROUTING_BY_ADDRESS;
		} else {
			$this->initLat = $initLat;
			$this->initLon = $initLon;
			$this->startAddress = '';
			$this->endAddress = $endAddress;
			$this->typeStartRoute = $this->typeStartRoute = self::ROUTING_BY_POSITION;
		}
	}

	public function isAddressRoute() {
		return $this->typeStartRoute === self::ROUTING_BY_ADDRESS;
	}

	public function isPositionRoute() {
		return $this->typeStartRoute === self::ROUTING_BY_POSITION;
	}

	public function getInitLat() {
		return $this->initLat;
	}

	public function getInitLon() {
		return $this->initLon;
	}

	public function getStartAddress() {
		return $this->startAddress;
	}

	public function getEndAddress() {
		return $this->endAddress;
	}
	
}