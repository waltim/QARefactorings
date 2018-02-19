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
	}

	public function index()
	{
		$transformations = $this->Transformation->find('all', array(
			'order' => array('Transformation.id DESC')
		));

		$this->set('transformations', $transformations);
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
					$this->redirect(array('action' => 'calculaMetricasQuantitativas', $lastCreated['Transformation']['id']));
				} else {
					$this->Session->setFlash(__('Transformação cadastrada com sucesso.'));
					$this->redirect(array('action' => 'view', $lastCreated['Transformation']['id']));
				}
			} else {
				$this->Session->setFlash(__('Houve um erro ao salvar, tente novamente.'));
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
									'transformation_id' => $id = null,
									'metric_id' => $metrica
								)
							);
							$this->Result->save($result);
						}
						$this->Session->setFlash(__('Transformação atualizada com sucesso.'));
						$this->redirect(array('action' => 'view', $id));
					}
				}
				$this->Session->setFlash(__('Transformação atualizada com sucesso.'));
				$this->redirect(array('action' => 'view', $id));
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
			$this->Session->setFlash(__('Transformação não encontrada.'));
		} elseif ($Selected['Transformation']['user_id'] != $this->Auth->user('id')) {
			$this->Session->setFlash(__('Você não tem permissão para isso.'));
		} else {
			$this->Transformation->delete($id);
			$this->Session->setFlash(__('Deletada com sucesso!'));
			$this->redirect(array('action' => 'index'));
		}
	}

	public function view($id = null)
	{
		if ($id == null) {
			$this->Session->setFlash(__('Esta transformação não existe!'));
			$this->redirect(array('action' => 'index'));
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

		// pr($quantitativas);
		// exit();

		$this->set('transformation', $show);
		$this->set('quantitativas', $quantitativas);
		$this->set('qualitativas', $qualitativas);
	}

	public function identCode($string = null)
	{
		$string = strip_tags(str_replace("{", "{#", $string));
		$code = str_replace(" ", "x*x", $string);
		$code = str_replace("x*x", "", $code);
		$code = str_replace(";", ";#", $code);
		$code = str_replace("{", "{#", $code);
		$code = str_replace(";}", ";}#", $code);
		$array = array_filter(explode("#", $code));
		foreach ($array as $key => $linha) {
			if (strlen($linha) == 6 || $linha == null) {
				unset($array[$key]);
			}
		}
		return $array;
	}

	public function locAndAmloc($string = null)
	{
		$numLoc = count($this->identCode($string));
		return $numLoc;
	}

	public function accm($string = null)
	{
		$complex = 1;
		$complex = $complex + substr_count($string, 'if');
		$complex = $complex + substr_count($string, 'elseif');
		$complex = $complex + substr_count($string, 'else');
		$complex = $complex + substr_count($string, 'while');
		$complex = $complex + substr_count($string, 'for');
		$complex = $complex + substr_count($string, 'foreach');
		$complex = $complex + substr_count($string, 'catch');
		$complex = $complex + substr_count($string, '?');
		$complex = $complex + substr_count($string, '&&');
		$complex = $complex + substr_count($string, 'switch');
		$complex = $complex + substr_count($string, 'case');
		$complex = $complex + substr_count($string, '||');
		return $complex;
	}

	public function calculaMetricasQuantitativas($id = null)
	{
		$this->autoRender = false;
		$quantitativas = $this->Transformation->Result->find('all', array(
			'conditions' => array(
				'Metric.metric_type_id' => 3,
				'Transformation.id' => $id
			)
		));
		foreach ($quantitativas as $metricas) {
			$this->Result->id = $metricas['Result']['id'];
			//pr($this->Result->id);exit();
			if ($metricas['Metric']['acronym'] == 'LOC' || $metricas['Metric']['acronym'] == 'AMLOC') {
				$result = array(
					'Result' => array(
						'before' => (int)$this->locAndAmloc($metricas['Transformation']['code_before']),
						'after' => (int)$this->locAndAmloc($metricas['Transformation']['code_after'])
					)
				);
				$this->Result->save($result);
			} elseif ($metricas['Metric']['acronym'] == 'ACCM') {
				$result = array(
					'Result' => array(
						'before' => $this->accm($metricas['Transformation']['code_before']),
						'after' => $this->accm($metricas['Transformation']['code_after'])
					)
				);
				$this->Result->save($result);
			}
		}
		$this->Session->setFlash(__('Transformação cadastrada com sucesso.'));
		$this->redirect(array('action' => 'view', $metricas['Transformation']['id']));
	}
}
