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

    public function index($pesquisa = null)
    {
        if ($pesquisa == null) {
            $transformations = $this->Transformation->find('all', array(
                'order' => array('Transformation.id DESC')
            ));
        } else {
            $transformations = $this->Transformation->find('all', array(
                'conditions' => array(
                    'Transformation.search_event_id' => $pesquisa
                ),
                'order' => array('Transformation.id DESC')
            ));
        }

        $this->set(compact('transformations'));
        $this->set('pesquisa', $pesquisa);
    }

    public function add($id = null)
    {
        if ($this->request->is('post')) {
            $uid = $id;
            $refactoring['Transformation'] = $this->request->data['Transformation'];
            $refactoring['Transformation']['search_event_id'] = $uid;
            unset($refactoring['Transformation']['metricas']);
            $metricas = $this->request->data['Transformation']['metricas'];
            $conteudo = $refactoring['Transformation']['conteudo'];
            $conteudo = strip_tags($conteudo, '<br>');
            $conteudo = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $conteudo);
            $cortaLink = explode("#", $refactoring['Transformation']['site_link']);
                     
            // pr($conteudo);
            // exit();
            $conditions = array(
                'search_event_id' => $refactoring['Transformation']['search_event_id'],
                'site_link' => $refactoring['Transformation']['site_link'],
                'line_start' => strtoupper($refactoring['Transformation']['line_start']),
                'line_end' => strtoupper($refactoring['Transformation']['line_end'])
            );
            if ($this->Transformation->hasAny($conditions)) {
                $this->Session->setFlash(__("A refatoração: <b>" . $refactoring['Transformation']['site_link'] . "</b> já foi cadastrada nesta pesquisa!"), 'Flash/info');
            } else {
                $anomesdiahora = date('YmdHis');
                $this->Transformation->create();
                $refactor = array(
                    'Transformation' => array(
                        'transformation_type_id' => $refactoring['Transformation']['transformation_type_id'],
                        'language_id' => $refactoring['Transformation']['language_id'],
                        'search_event_id' => $refactoring['Transformation']['search_event_id'],
                        'diff_id' => $cortaLink[1] . "-" . $anomesdiahora,
                        'site_link' => $refactoring['Transformation']['site_link'],
                        'line_start' => strtoupper($refactoring['Transformation']['line_start']),
                        'line_end' => strtoupper($refactoring['Transformation']['line_end']),
                    ),
                );
                $this->Transformation->save($refactor);

                $lastTransformationCreated = $this->Transformation->find('first', array(
                    'conditions' => array('Transformation.search_event_id' => $refactoring['Transformation']['search_event_id']),
                    'order' => array('Transformation.created DESC'),
                ));

                foreach ($metricas as $metrica) {
                    $this->Result->create();
                    $result = array(
                        'Result' => array(
                            'transformation_id' => $lastTransformationCreated['Transformation']['id'],
                            'metric_id' => $metrica,
                        ),
                    );
                    $this->Result->save($result);
                }
                //pr($conteudo);exit();
                $nomecode = $cortaLink[1]."-".$anomesdiahora;
                $pasta = WWW_ROOT . "files/" . $nomecode . "/";
                $caminho = $pasta;
                $oldmask = umask(0);
                if (file_exists($pasta)) {
                    echo "O arquivo $pasta existe";
                } else {
                    mkdir($pasta, 0777, true);
                }
                $caminho = $caminho . "ab.txt";
                $fp = fopen($caminho, "w+");
                $breaks = array("<br />","<br>","<br/>");
                $conteudo = str_ireplace($breaks, "\r\n", $conteudo);
                $conteudo = str_replace("&nbsp;","",$conteudo);
                $escreve = fwrite($fp, utf8_encode($conteudo));
                fclose($fp);
                umask($oldmask);
            
                $this->separaAnteriorETransformado($lastTransformationCreated['Transformation']['id'], $pasta, $caminho);

                $this->Session->setFlash(__('Transformação cadastrada com sucesso.'), 'Flash/success');
                $this->redirect(array('action' => 'add', $lastTransformationCreated['Transformation']['search_event_id']));
            }

        }
        $this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
        $this->set('types', $this->TransformationType->find('list', array('fields' => 'TransformationType.description')));
        $this->set('metrics', $this->Metric->find('list', array('fields' => 'Metric.acronym')));
        $this->set('pesquisa', $id);
    }

    public function separaAnteriorETransformado($transformation = null, $pasta = null, $arquivo = null)
    {
        //pr($arquivo);exit();
        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "r");

        //Lê o conteúdo do arquivo aberto.
        $oldmask = umask(0);
        $a = fopen($pasta . "a.txt", "w+");
        $b = fopen($pasta . "b.txt", "w+");
        $Aconteudo = '';
        $Bconteudo = '';
        $Cconteudo = '';
        $Dconteudo = '';
        while (!feof($fp)) {
            $valor = fgets($fp, 4096);
            if (strstr($valor, "+   ")) {
                $Cconteudo .= $valor . '<br/>';
                $valor = str_replace("+   ", "    ", $valor);
                $Bconteudo .= fwrite($b, utf8_encode($valor));
            } elseif (strstr($valor, "-   ")) {
                $Dconteudo .= $valor . '<br/>';
                $valor = str_replace("-   ", "    ", $valor);
                $Aconteudo .= fwrite($a, utf8_encode($valor));
            } else {
                $Aconteudo .= fwrite($a, utf8_encode($valor));
                $Bconteudo .= fwrite($b, utf8_encode($valor));
                $Cconteudo .= $valor . '<br/>';
                $Dconteudo .= $valor . '<br/>';
            }
        }
        fclose($a);
        fclose($b);
        umask($oldmask);
        //Fecha o arquivo.
        fclose($fp);
    
        //retorna o conteúdo.
        $this->Transformation->id = $transformation;
        $refactor = array(
            'Transformation' => array(
                'code_before' => "<p>" . $Dconteudo . "</p>",
                'old_code' => $pasta . "a.txt",
                'code_after' => "<p>" . $Cconteudo . "</p>",
                'new_code' => $pasta . "b.txt",
            ),
        );
        $this->Transformation->save($refactor);

        $this->manipulaMetricas($transformation);
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

    public function delete($id = null,$pesquisa = null)
    {
        $Selected = $this->Transformation->find('first', array(
            'conditions' => array('Transformation.id' => $id)
        ));
        if (empty($Selected)) {
            $this->Session->setFlash(__('Transformação não encontrada.'), 'Flash/error');
        } else {
            $this->Transformation->delete($id);
            $this->Session->setFlash(__('Deletada com sucesso!'), 'Flash/success');
            $this->redirect(array('action' => 'index',$pesquisa));
        }
    }

    public function deleteAll($pesquisa = null)
    {
        $Selected = $this->Transformation->find('all', array(
            'conditions' => array('Transformation.search_event_id' => $pesquisa)
        ));
        foreach ($Selected as $todel){
            $this->Transformation->delete($todel['Transformation']['id']);
        }
        $this->Session->setFlash(__('Deletadad com sucesso!'), 'Flash/success');
        $this->redirect(array('action' => 'index',$pesquisa));
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

        $questao = $this->Result->find('first', array(
            'conditions' => array(
                'Metric.metric_type_id' => 2,
                'Transformation.id' => $id
            )
        ));
        //pr($questao);exit();
        if (!empty($questao['ResultQuestion'])) {
            $k = 0;
            foreach ($questao['ResultQuestion'] as $rq) {
                $respostas[$k] = $this->Answer->find('first', array(
                    'conditions' => array(
                        'Answer.result_question_id' => $rq['id']
                    )
                ));
                $k++;
            }
            $respostas = array_filter($respostas);
            $this->set('respostas', $respostas);
        }

        $this->set('transformation', $show);
        $this->set('quantitativas', $quantitativas);
        $this->set('qualitativas', $qualitativas);
    }

    public
    function locAndAmloc($string = null)
    {
        $numLoc = substr_count($string, '<br/>')-2;
        return $numLoc;
    }

    public
    function accm($string = null)
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

    public
    function manipulaMetricas($id = null)
    {
        $this->loadModel('Result');

        $this->autoRender = false;
        
        $metrics = $this->Result->find('all', array(
            'conditions' => array(
                'Transformation.id' => $id
            )
        ));

        foreach ($metrics as $metricas) {
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
            }
        }
    }
}
