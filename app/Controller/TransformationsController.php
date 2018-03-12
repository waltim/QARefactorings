<?php
App::uses('AppController', 'Controller');
class TransformationsController extends AppController
{
	function beforeFilter()
	{
		parent::beforeFilter();
		$this->layout = 'admin';
		$this->loadModel('TransformationType');
		$this->loadModel('Metric');
		$this->loadModel('Language');
		$this->loadModel('Result');
		$this->loadModel('Question');
		$this->loadModel('Answer');
	}

	public function index()
	{
		if ($this->Auth->user('UserType.description') == 'administrador') {
			$transformations = $this->Transformation->find('all', array(
				'order' => array('Transformation.id DESC')
			));
		} else {
			$transformations = $this->Transformation->find('all', array(
				'conditions' => array(
					'Transformation.user_id' => $this->Auth->user('id')
				),
				'order' => array('Transformation.id DESC')
			));
		}
		$aics = $this->Transformation->find('count', array(
			'conditions' => array(
				'Transformation.transformation_type_id' => 1
			)
		));

		$foreachs = $this->Transformation->find('count', array(
			'conditions' => array(
				'Transformation.transformation_type_id' => 2
			)
		));

		$filters = $this->Transformation->find('count', array(
			'conditions' => array(
				'Transformation.transformation_type_id' => 3
			)
		));

		$exists = $this->Transformation->find('count', array(
			'conditions' => array(
				'Transformation.transformation_type_id' => 4
			)
		));

		$maps = $this->Transformation->find('count', array(
			'conditions' => array(
				'Transformation.transformation_type_id' => 5
			)
		));

		$this->set(compact('transformations', 'aics', 'foreachs', 'filters', 'exists', 'maps'));
	}

	public function add()
	{
		if ($this->request->is('post')) {
			$uid = $this->Auth->user('id');
			$refactoring['Transformation'] = $this->request->data['Transformation'];
			$refactoring['Transformation']['user_id'] = $uid;
			unset($refactoring['Transformation']['metricas']);
			$metricas = $this->request->data['Transformation']['metricas'];
			$this->Transformation->create();
			if ($this->Transformation->validates() != false && $this->Transformation->save($refactoring)) {
				if (count($metricas) > 0) {
					$lastCreated = $this->Transformation->find('first', array(
						'conditions' => array('Transformation.user_id' => $uid),
						'order' => array('Transformation.id DESC')
					));
					foreach ($metricas as $metrica) {
						$this->Result->create();
						$result = array(
							'Result' => array(
								'transformation_id' => $lastCreated['Transformation']['id'],
								'metric_id' => $metrica,
							)
						);
						$this->Result->save($result);
					}
					$this->Session->setFlash(__('Transformação cadastrada com sucesso.'), 'Flash/success');
					$this->redirect(array('action' => 'manipulaMetricas', $lastCreated['Transformation']['id']));
				} else {
					$this->Session->setFlash(__('Transformação cadastrada com sucesso.'), 'Flash/success');
					$this->redirect(array('action' => 'view', $lastCreated['Transformation']['id']));
				}
			} else {
				$this->Session->setFlash(__('Houve um erro ao salvar, tente novamente.'), 'Flash/error');
			}
		}
		$this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
		$this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
		$this->set('metrics', $this->Metric->find('list', array('fields' => 'Metric.acronym')));
	}

	public function edit($id = null)
	{
		if ($this->request->is('post')) {
			$refactoring['Transformation'] = $this->request->data['Transformation'];
			if ($this->Transformation->save($refactoring)) {
				if (isset($this->request->data['Transformation']['metricas'])) {
					$metricas = $this->request->data['Transformation']['metricas'];
					if (count($metricas) > 0) {
						foreach ($metricas as $metrica) {
							$this->Result->create();
							$result = array(
								'Result' => array(
									'transformation_id' => $id,
									'metric_id' => $metrica
								)
							);
							$this->Result->save($result);
						}
					}
				}
				$this->Session->setFlash(__('Transformação atualizada com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'manipulaMetricas', $refactoring['Transformation']['id']));
			}
		}
		$transformation = $this->Transformation->findById($id);
		$metricas = $this->Metric->find('list', array('fields' => 'Metric.acronym'));
		foreach ($transformation['Metric'] as $filter) {
			if (in_array($filter['acronym'], $metricas)) {
				$key = array_search($filter['acronym'], $metricas);
				unset($metricas[$key]);
			}
		}
		$this->set('transformation', $transformation);
		$this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
		$this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
		$this->set('metrics', $metricas);
	}

	public function delete($id = null)
	{
		$Selected = $this->Transformation->find('first', array(
			'conditions' => array('Transformation.id' => $id)
		));
		if (empty($Selected)) {
			$this->Session->setFlash(__('Transformação não encontrada.'), 'Flash/error');
		} else {
			$this->Transformation->delete($id);
			$this->Session->setFlash(__('Deletada com sucesso!'), 'Flash/success');
			$this->redirect(array('action' => 'index'));
		}
	}

	public function view($id = null)
	{
		if ($id == null) {
			$this->Session->setFlash(__('Esta transformação não existe!'), 'Flash/error');
			$this->redirect(array('action' => 'index'));
		}

		if ($this->request->is('post')) {
			$this->Transformation->id = $id;
			if (array_key_exists("deletions", $this->request->data['Transformation'])) {
				$result = array(
					'Transformation' => array(
						'transformation_id' => $id,
						'deletions' => $this->request->data['Transformation']['deletions']
					)
				);
			} else {
				$result = array(
					'Transformation' => array(
						'transformation_id' => $id,
						'additions' => $this->request->data['Transformation']['additions']
					)
				);
			}
			if ($this->Transformation->save($result)) {
				$this->Session->setFlash(__('linhas destacadas com sucesso.'), 'Flash/success');
				$this->redirect(array('action' => 'view', $id));
			}
		}

		$show = $this->Transformation->find('first', array(
			'conditions' => array('Transformation.id' => $id)
		));
		$qualitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Metric.metric_type_id' => 2,
				'Transformation.id' => $id
			)
		));
		$quantitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Metric.metric_type_id' => 3,
				'Transformation.id' => $id
			)
		));

		$questão = $this->Result->find('first', array(
			'conditions' => array(
				'Metric.metric_type_id' => 2,
				'Transformation.id' => $id
			)
		));

		$respostas = $this->Answer->find('all', array(
			'conditions' => array(
				'Answer.question_id' => $questão['Question'][0]['id']
			)
		));

		$this->set('respostas', $respostas);
		$this->set('transformation', $show);
		$this->set('quantitativas', $quantitativas);
		$this->set('qualitativas', $qualitativas);

	}

	public function locAndAmloc($string = null)
	{
		$numLoc = substr_count($string, '<br>');
		return $numLoc;
	}

	public function accm($string = null)
	{
		$complex = 1;
		$complex = $complex + substr_count($string, 'if (');
		$complex = $complex + substr_count($string, 'while (');
		$complex = $complex + substr_count($string, 'for (');
		$complex = $complex + substr_count($string, 'forEach(');
		$complex = $complex + substr_count($string, 'catch (');
		$complex = $complex + substr_count($string, ' ? ');
		$complex = $complex + substr_count($string, ' && ');
		$complex = $complex + substr_count($string, 'case ');
		$complex = $complex + substr_count($string, ' || ');
		$complex = $complex + substr_count($string, 'continue;');
		$complex = $complex + substr_count($string, 'goto ');
		return $complex;
	}

	public function manipulaMetricas($id = null)
	{
		$this->autoRender = false;
		$quantitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Transformation.id' => $id
			)
		));
		foreach ($quantitativas as $metricas) {
			if ($metricas['Metric']['acronym'] == 'LOC') {
				$this->Result->id = $metricas['Result']['id'];
				$result = array(
					'Result' => array(
						'before' => (int)$this->locAndAmloc($metricas['Transformation']['code_before']),
						'after' => (int)$this->locAndAmloc($metricas['Transformation']['code_after'])
					)
				);
				$this->Result->save($result);
			} elseif ($metricas['Metric']['acronym'] == 'ACCM') {
				$this->Result->id = $metricas['Result']['id'];
				$result = array(
					'Result' => array(
						'before' => $this->accm($metricas['Transformation']['code_before']),
						'after' => $this->accm($metricas['Transformation']['code_after'])
					)
				);
				$this->Result->save($result);
			} elseif ($metricas['Metric']['acronym'] == 'LIKERT') {
				$QuestionForResult = $this->Result->Question->find('count', array(
					'conditions' => array(
						'Question.result_id' => $metricas['Result']['id']
					)
				));
				if ($QuestionForResult < 1) {
					$this->Question->create();
					$question = array(
						'Question' => array(
							'result_id' => $metricas['Result']['id'],
							'question_type_id' => 1,
							'description' => 'Você concorda que a transformação melhorou a legibilidade do código?'
						)
					);
					$this->Question->save($question);
				}
			}
		}
		$this->Session->setFlash(__('Métricas calculadas com sucesso.'), 'Flash/success');
		$this->redirect(array('action' => 'view', $metricas['Transformation']['id']));
	}
}
