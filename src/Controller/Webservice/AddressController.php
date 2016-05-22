<?php

namespace App\Controller\Webservice;

use App\Controller\AppController;
use App\Model\Domain\AddressDomain;

class AddressController extends AppController {
	/** @var  AddressDomain */
	private $address;

	public function initialize() {
		parent::initialize();
		$this->viewBuilder()->layout('ajax');

		$this->address = new AddressDomain();
	}

	public function getListAdresses($address = null) {

		$result = [];

		if ($address != null) {
			$result = $this->address->getListAddresses($address);
		}

		$this->set(compact("result"));
	}

}