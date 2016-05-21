<?php

namespace App\Model\Vo;

class Address {

	private $postCode = '';
	private $country = '';
	private $state = '';
	private $neighborhood = '';
	private $city = '';
	private $street = '';
	private $number = '';
	private $lat = '';
	private $lng = '';
	private $id = '';

	public function __construct(array $address) {
		$this->postCode = $address['postcode'];
		$this->country = $address['country'];
		$this->state = $address['state'];
		$this->city = $address['city'];
		$this->neighborhood = $address['neighborhood'];
		$this->street = $address['street'];
		$this->number = $address['number'];
		$this->lat = $address['lat'];
		$this->lng = $address['lng'];
		$this->id = $address['id'];
	}

	/**
	 * @return mixed|string
	 */
	public function getPostCode() {
		return $this->postCode;
	}

	/**
	 * @return mixed|string
	 */
	public function getCountry() {
		return $this->country;
	}

	/**
	 * @return mixed|string
	 */
	public function getState() {
		return $this->state;
	}

	/**
	 * @return mixed|string
	 */
	public function getNeighborhood() {
		return $this->neighborhood;
	}

	/**
	 * @return mixed|string
	 */
	public function getCity() {
		return $this->city;
	}

	/**
	 * @return mixed|string
	 */
	public function getStreet() {
		return $this->street;
	}

	/**
	 * @return mixed|string
	 */
	public function getNumber() {
		return $this->number;
	}

	/**
	 * @return mixed|string
	 */
	public function getLat() {
		return $this->lat;
	}

	/**
	 * @return mixed|string
	 */
	public function getLng() {
		return $this->lng;
	}

	/**
	 * @return mixed|string
	 */
	public function getId() {
		return $this->id;
	}

	public function toString() {
		$address = [
			$this->city,
			$this->neighborhood,
			$this->street,
			$this->number
		];

		return implode(', ', $address);
	}


}