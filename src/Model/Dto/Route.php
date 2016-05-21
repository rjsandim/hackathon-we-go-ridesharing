<?php

namespace App\Model\Dto;

class Route {
	private $initLat;
	private $initLon;
	private $endLat;
	private $endLon;

	public function __construct($initLat, $initLon, $endLat, $endLon) {
		$this->initLat = $initLat;
		$this->initLon = $initLon;
		$this->endLat = $endLat;
		$this->endLon = $endLon;
	}

	public function getInitLat() {
		return $this->initLat;
	}

	public function getInitLon() {
		return $this->initLon;
	}

	public function getEndLat() {
		return $this->endLat;
	}

	public function getEndLon() {
		return $this->endLon;
	}
	
}