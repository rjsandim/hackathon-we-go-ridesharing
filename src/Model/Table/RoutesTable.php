<?php

namespace App\Model\Table;

use App\Model\Contracts\IMatch;
use App\Model\Domain\MatcherDomain;
use App\Model\Entity\Route;
use Cake\Error\Debugger;
use Cake\ORM\Table;

class RoutesTable extends Table implements IMatch {

	public function initialize(array $config)
	{
		$this->addBehavior('Timestamp');
	}

	public function getPeopleNearOfThis(MatcherDomain $matcher) {

		$options = [
			'conditions' =>
				[
					'start_city' => $matcher->getStart()->getCity(),
					'start_state' => $matcher->getStart()->getState(),
					'end_city' => $matcher->getEnd()->getCity(),
					'end_state' => $matcher->getEnd()->getState(),
					'start_id !=' => $matcher->getStart()->getId(),
					'created >=' => date('Y-m-d H:i:s', strtotime('-15 minute'))
				]
		];


		return $this->find('all', $options)->toArray();

	}


	public function saveNewRoute(MatcherDomain $matcher) {

		$hasItem = $this->find('all', ['conditions' => ['start_id' => $matcher->getStart()->getId(), 'end_id' => $matcher->getEnd()->getId()]])->toArray();

		//Debugger::dump($hasItem);

		if (count($hasItem)) {

			$hasItem[0]->created = date('Y-m-d H:i:s');
			return $this->save($hasItem[0]);
		}

		$address = [
			'start_lat' => $matcher->getStart()->getLat(),
			'start_lng' => $matcher->getStart()->getLng(),
			'start_id' => $matcher->getStart()->getId(),
			'start_city' => $matcher->getStart()->getCity(),
			'start_state' => $matcher->getStart()->getState(),
			'end_lat' => $matcher->getEnd()->getLat(),
			'end_lng' => $matcher->getEnd()->getLng(),
			'end_id' => $matcher->getEnd()->getId(),
			'end_city' => $matcher->getEnd()->getCity(),
			'end_state' => $matcher->getEnd()->getState(),
			'start_formated' => $matcher->getStart()->getFormattedAddress(),
			'end_formated' => $matcher->getEnd()->getFormattedAddress(),
			'distance' => $matcher->getDistance(),
		];

		$entity = $this->newEntity($address);
		return $this->save($entity);
	}
}