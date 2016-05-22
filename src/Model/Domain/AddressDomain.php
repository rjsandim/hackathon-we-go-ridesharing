<?php

namespace App\Model\Domain;

use App\Model\Services\GoogleMaps;

class AddressDomain {

	private $mapsService;

	public function __construct() {
		$this->mapsService = new GoogleMaps();
	}

	public function getListAddresses($address) {

		$var = $this->mapsService->getPossibleAddresses($address);
		return $var;
	}

}