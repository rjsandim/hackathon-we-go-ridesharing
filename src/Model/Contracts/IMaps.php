<?php

namespace App\Model\Contracts;

interface IMaps {
	public function getPossibleAddresses($address);
	public function getDirectionsBetweenPlaceIds($start, $end);
}