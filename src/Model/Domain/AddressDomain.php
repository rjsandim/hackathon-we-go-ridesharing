<?php

namespace App\Model\Domain;

use App\Model\Services\GoogleMaps;

class AddressDomain {

	private $mapsService;

	public function __construct() {
		$this->mapsService = new GoogleMaps();
	}

	public function getListAddresses($address) {

		return $this->mapsService->getPossibleAddresses($address);
	}

}