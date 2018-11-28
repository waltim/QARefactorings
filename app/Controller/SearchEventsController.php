<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 17/04/18
 * Time: 14:22
 */
App::uses('TransformationsController', 'Controller');
class SearchEventsController extends AppController
{

    public function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'admin';
        $this->loadModel('SearchEvent');
        $this->loadModel('Transformation');
        $this->loadModel('Participant');
        $this->loadModel('User');
        $this->loadModel('LanguageSearchEvent');
        $this->loadModel('Language');
        $this->loadModel('Metric');
        $this->loadModel('Result');
    }

    public function loadDataCsv($pesquisa = null)
    {
        if ($this->request->is('post')) {
            $pasta = WWW_ROOT . "files/";
            $partenome = explode(".", $this->request->data["file"]["name"]);
            $nomearquivo = $partenome[0] . "-" . date('dmYHis', time()) . ".csv";
            $oldmask = umask(0);
//            pr($this->request->data["file"]);exit();
            if ($this->request->data["file"]['type'] == 'text/csv' || $this->request->data["file"]['type'] == 'application/vnd.ms-excel') {
                if (move_uploaded_file($this->request->data["file"]["tmp_name"], $pasta . $nomearquivo)) {
                    $array = array();
                    $file = fopen($pasta . $nomearquivo, 'r');
                    while (($line = fgetcsv($file)) !== false) {
                        $array[] = $line;
                    }
                    fclose($file);
                    umask($oldmask);
                    @unlink($pasta . $nomearquivo);
                    foreach ($array as $line) {
                        $this->capturaCodigo($pesquisa, $line[3], $line[4], $line[0], $line[1], $line[2], $this->request->data['metricas']);

                    }
                    $this->Session->setFlash(__('Importação finalizada com sucesso!'), 'Flash/success');
                } else {
                    $this->Session->setFlash(__('O arquivo não pode ser salvo, tente novamente.'), 'Flash/error');
                }
            } else {
                $this->Session->setFlash(__('Este não é um arquivo .CSV!!'), 'Flash/error');
            }
        }
        $this->set('pesquisa', $pesquisa);
        $this->set('metrics', $this->Metric->find('list', array('fields' => 'Metric.acronym')));
    }

    public function get_title($url){
        $str = file_get_contents($url);
        if(strlen($str)>0){
          $str = trim(preg_replace('/\s+/', ' ', $str)); // supports line breaks inside <title>
          preg_match("/\<title\>(.*)\<\/title\>/i",$str,$title); // ignore case
          return $title[1];
        }
    }

    public function capturaCodigo($pesquisa = null, $transformationType = null, $language = null, $url = null, $start = null, $end = null, $metricas = null)
    {
        $start = strtoupper($start);
        $end = strtoupper($end);

        $cortaLink = explode("#", $url);
        $stringz = $this->get_title($url);
        $stringz = str_replace("/", "_", $stringz);
        $stringz = str_replace(":", "_", $stringz);
        $stringz = str_replace(" · GitHub", ".html", $stringz);
        // $conecurl = @fopen("$url", "r") or die('<center>erro na conexão<br><b>informe o administrador erro 15 </b></center>');
        // $lin = '';
        // while (!feof($conecurl)) {
        //     $lin .= fgets($conecurl, 4096);
        // }
        // fclose($conecurl);

        // $conecurl = file_get_contents("/home/machine/Downloads/Remove useless final and this modifiers · FluentLenium_FluentLenium@73bac61.html");
        // pr($conecurl);exit();
        $pages = WWW_ROOT . "files/pages-html/";
        $file = fopen($pages.html_entity_decode($stringz, ENT_QUOTES), "r");
        $lin = '';
        while (!feof($file)) {
            $lin .= fgets($file, 4096);
         }
        fclose($file);

        // pr($pages.$stringz);
        if (stristr($lin, 'id="' . $cortaLink[1] . $start . '" data-line-number="' . substr($start, 1) . '"') == false) {
            //$this->Session->setFlash(__("A refatoração: <b>" . $cortaLink[1] . "</b> está com problema e não foi importada. verifique os dados!"), 'Flash/error');
        } elseif (stristr($lin, 'id="' . $cortaLink[1] . $end . '" data-line-number="' . substr($end, 1) . '"') == false) {
            //$this->Session->setFlash(__("A refatoração: <b>" . $cortaLink[1] . "</b> está com problema e não foi importada. verifique os dados!"), 'Flash/error');
        } else {
            $inicio = strpos($lin, 'id="' . $cortaLink[1] . $start . '" data-line-number="' . substr($start, 1) . '"') + 323;

            $fim = strpos($lin, 'id="' . $cortaLink[1] . $end . '" data-line-number="' . substr($end, 1) . '"');

            $quantopula = $fim - $inicio;
            $conteudo = substr($lin, $inicio, $quantopula);
            $conteudo = str_replace('<span class="blob-code-inner blob-code-marker-deletion">', "-", $conteudo);
            $conteudo = str_replace('<span class="blob-code-inner blob-code-marker-addition">', "+", $conteudo);
            $conteudo = strip_tags($conteudo, '<br>');
            $conteudo = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\r\n", $conteudo);
            // pr($conteudo);exit();
            $conditions = array(
                'search_event_id' => $pesquisa,
                'site_link' => $url,
                'line_start' => $start,
                'line_end' => $end,
            );
            // pr($conditions);
            if ($this->Transformation->hasAny($conditions)) {
                $this->Session->setFlash(__("A refatoração: <b>" . $url . "</b> já foi cadastrada nesta pesquisa!"), 'Flash/info');
            } else {
                $anomesdiahora = date('YmdHis');
                $this->Transformation->create();
                $refactor = array(
                    'Transformation' => array(
                        'transformation_type_id' => $transformationType,
                        'language_id' => $language,
                        'search_event_id' => $pesquisa,
                        'diff_id' => $cortaLink[1] . "-" . $anomesdiahora,
                        'site_link' => $url,
                        'line_start' => $start,
                        'line_end' => $end,
                    ),
                );
                $this->Transformation->save($refactor);

                $lastTransformationCreated = $this->Transformation->find('first', array(
                    'conditions' => array('Transformation.search_event_id' => $pesquisa),
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
//                pr($conteudo);
                $escreve = fwrite($fp, utf8_encode($conteudo));

                fclose($fp);
                umask($oldmask);
                // pr(explode("\n", file_get_contents($caminho)));exit();
                $this->separaAnteriorETransformado($lastTransformationCreated['Transformation']['id'], $pasta, $caminho);
            }
        }
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
            if (strstr($valor, "    +")) {
                $Cconteudo .= $valor . '<br/>';
                $valor = str_replace("    +", "      ", $valor);
                $Bconteudo .= fwrite($b, utf8_encode($valor));
            } elseif (strstr($valor, "    -")) {
                $Dconteudo .= $valor . '<br/>';
                $valor = str_replace("    -", "      ", $valor);
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

//        pr($Aconteudo);
//        pr($Bconteudo);
        // $oldCode = fopen($pasta . "a.txt", "r");
        // $oldCodeContent = '';
        // while (!feof($oldCode)) {
        //     $oldCodeContent .= fgets($oldCode, 4096);
        // }
        // fclose($oldCode);

        // $newCode = fopen($pasta . "b.txt", "r");
        // $newCodeContent = '';
        // while (!feof($newCode)) {
        //     $newCodeContent .= fgets($newCode, 4096);
        // }
        // fclose($newCode);

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
        $transf = new TransformationsController();
        $transf->manipulaMetricas($transformation);
    }

    public function index()
    {
        if ($this->Auth->user('UserType.description') == 'administrador') {
            $participations = $this->Participant->find('all', array(
                'conditions' => array(
                    'Participant.participant_type_id' => 1,
                ),
                'order' => array('Participant.search_event_id DESC'),
            ));
            $pesquisas = array();
            foreach ($participations as $key => $participation) {
                $pesquisas[$key]['SearchEvent'] = $participation['SearchEvent'];
                $pesquisas[$key]['Participant'] = $participation['Participant'];
                $pesquisas[$key]['User'] = $participation['User'];
            }
        } else {
            $participations = $this->Participant->find('all', array(
                'conditions' => array(
                    'Participant.user_id' => $this->Auth->user('id'),
                ),
                'order' => array('Participant.search_event_id DESC'),
            ));
            $pesquisas = array();
            foreach ($participations as $key => $participation) {
                $pesquisas[$key]['SearchEvent'] = $participation['SearchEvent'];
                $pesquisas[$key]['Participant'] = $participation['Participant'];
                $pesquisas[$key]['User'] = $participation['User'];
            }
        }

        $this->set('pesquisas', $pesquisas);
    }

    public function add()
    {
        if ($this->request->is('post')) {

            $uid = $this->Auth->user('id');

            //pr($uid);exit();
            $search['SearchEvent'] = $this->request->data['SearchEvent'];
            unset($search['SearchEvent']['linguages']);
            $langs = $this->request->data['SearchEvent']['linguages'];

            $conditions = array(
                'SearchEvent.title' => $search['SearchEvent']['title'],
            );

            // pr($this->request->data);exit();
            if ($this->SearchEvent->hasAny($conditions)) {
                $this->Session->setFlash(__('Uma pesquisa com este nome já existe!'), 'Flash/error');
            } else {
                $this->SearchEvent->create();
                $this->SearchEvent->save($search);

                $lastCreated = $this->SearchEvent->find('first', array(
                    'conditions' => array('SearchEvent.title' => $search['SearchEvent']['title']),
                ));

                //pr($lastCreated);exit();

                if ($lastCreated != null) {
                    foreach ($langs as $lang) {
                        $this->LanguageSearchEvent->create();
                        $search_lang = array(
                            'LanguageSearchEvent' => array(
                                'language_id' => $lang,
                                'search_event_id' => $lastCreated['SearchEvent']['id'],
                            ),
                        );
                        $this->LanguageSearchEvent->save($search_lang);
                    }

                    $this->Participant->create();

                    $participant = array(
                        'Participant' => array(
                            'user_id' => $uid,
                            'search_event_id' => $lastCreated['SearchEvent']['id'],
                            'participant_type_id' => 1,
                        ),
                    );

                    $this->Participant->save($participant);

                    $this->Session->setFlash(__('Evento de pesquisa cadastrado com sucesso.'), 'Flash/success');
                    $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
                }
            }
        }

        $this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));

    }

    public function edit($id = null)
    {

        if ($this->request->is('post')) {

            $data = $this->request->data;
            $data['SearchEvent']['id'] = $id;
            unset($data['SearchEvent']['linguages']);
            foreach ($this->request->data['SearchEvent']['linguages'] as $lang) {
                $conditions = array(
                    'LanguageSearchEvent.language_id' => $lang,
                    'LanguageSearchEvent.search_event_id' => $id,
                );
                if ($this->LanguageSearchEvent->hasAny($conditions)) {

                } else {
                    $this->LanguageSearchEvent->create();
                    $search_lang = array(
                        'LanguageSearchEvent' => array(
                            'language_id' => $lang,
                            'search_event_id' => $id,
                        ),
                    );
                    $this->LanguageSearchEvent->save($search_lang);
                }
            }
            $this->SearchEvent->save($data);

            $this->Session->setFlash(__('Evento de pesquisa atualizado com sucesso!'), 'Flash/success');

            $this->redirect(array('controller' => 'searchEvents', 'action' => 'index'));
        }

        $this->set('search', $this->SearchEvent->find('first', array('conditions' => array('SearchEvent.id' => $id))));

        $this->set('languages', $this->Language->find('list', array('fields' => 'Language.description')));
        $this->set('pesquisa', $id);
    }

    public function view()
    {
    }
}
