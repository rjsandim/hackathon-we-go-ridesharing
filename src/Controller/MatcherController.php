<?php

namespace App\Controller;

class MatcherController extends AppController {

	public function index() {

	}

	public function map() {
		$this->viewBuilder()->layout('map');
	}
}