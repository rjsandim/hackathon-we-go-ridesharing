<?php

namespace App\Controller;

class RouteController extends AppController {

	public function initialize()
	{
		parent::initialize();
		$this->loadComponent('RequestHandler');
	}

	public function route()
	{
		$recipes = $this->Recipes->find('all');
		$this->set([
			'recipes' => $recipes,
			'_serialize' => ['recipes']
		]);
	}

	public function view($id)
	{
		$recipe = $this->Recipes->get($id);
		$this->set([
			'recipe' => $recipe,
			'_serialize' => ['recipe']
		]);
	}

	public function add()
	{
		$recipe = $this->Recipes->newEntity($this->request->data);
		if ($this->Recipes->save($recipe)) {
			$message = 'Saved';
		} else {
			$message = 'Error';
		}
		$this->set([
			'message' => $message,
			'recipe' => $recipe,
			'_serialize' => ['message', 'recipe']
		]);
	}

	public function edit($id)
	{
		$recipe = $this->Recipes->get($id);
		if ($this->request->is(['post', 'put'])) {
			$recipe = $this->Recipes->patchEntity($recipe, $this->request->data);
			if ($this->Recipes->save($recipe)) {
				$message = 'Saved';
			} else {
				$message = 'Error';
			}
		}
		$this->set([
			'message' => $message,
			'_serialize' => ['message']
		]);
	}

	public function delete($id)
	{
		$recipe = $this->Recipes->get($id);
		$message = 'Deleted';
		if (!$this->Recipes->delete($recipe)) {
			$message = 'Error';
		}
		$this->set([
			'message' => $message,
			'_serialize' => ['message']
		]);
	}


}