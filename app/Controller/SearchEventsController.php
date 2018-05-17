<?php
/**
 * Created by PhpStorm.
 * User: walter
 * Date: 17/04/18
 * Time: 14:22
 */

class SearchEventsController extends AppController
{

    function beforeFilter()
    {
        parent::beforeFilter();
        $this->layout = 'admin';
        $this->loadModel('SearchEvent');
        $this->loadModel('Transformation');
        $this->loadModel('Participant');
        $this->loadModel('User');
        $this->loadModel('LanguageSearchEvent');
        $this->loadModel('Language');
    }

    public function loadDataCsv($pesquisa = null)
    {
        if ($this->request->is('post')) {
//            pr($this->request->data);
//            exit();
            $pasta = WWW_ROOT . "files/";
            $partenome = explode(".", $this->request->data["file"]["name"]);
            $nomearquivo = $partenome[0] . "-" . date('dmYHis', time()) . ".csv";
            $oldmask = umask(0);
            if ($this->request->data["file"]['type'] == 'text/csv') {
                if (move_uploaded_file($this->request->data["file"]["tmp_name"], $pasta . $nomearquivo)) {
                    $array = Array();
                    $file = fopen($pasta . $nomearquivo, 'r');
                    while (($line = fgetcsv($file)) !== false) {
                        $array[] = $line;
                    }
                    fclose($file);
                    umask($oldmask);
                    @unlink($pasta . $nomearquivo);
                    foreach ($array as $line) {
                        $this->capturaCodigo($pesquisa, $line[3], $line[4], $line[0], $line[1], $line[2]);

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
    }

    public function capturaCodigo($pesquisa = null, $transformationType = null, $language = null, $url = null, $start = null, $end = null)
    {
        $start = strtoupper($start);
        $end = strtoupper($end);

        $cortaLink = explode("#", $url);

        $conecurl = @fopen("$url", "r") or die ('<center>erro na conexão<br><b>informe o administrador erro 15 </b></center>');
        $lin = '';
        while (!feof($conecurl)) {
            $lin .= fgets($conecurl, 4096);
        }
        fclose($conecurl);
        if (stristr($lin, 'id="' . $cortaLink[1] . $start . '" data-line-number="' . substr($start, 1) . '"') == false) {
            $this->Session->setFlash(__("A refatoração: <b>" . $cortaLink[1] . "</b> está com problema e não foi importada. verifique os dados!"), 'Flash/error');
        } elseif (stristr($lin, 'id="' . $cortaLink[1] . $end . '" data-line-number="' . substr($end, 1) . '"') == false) {
            $this->Session->setFlash(__("A refatoração: <b>" . $cortaLink[1] . "</b> está com problema e não foi importada. verifique os dados!"), 'Flash/error');
        } else {
            $inicio = strpos($lin, 'id="' . $cortaLink[1] . $start . '" data-line-number="' . substr($start, 1) . '"') + 290;

            $fim = strpos($lin, 'id="' . $cortaLink[1] . $end . '" data-line-number="' . substr($end, 1) . '"');

            $quantopula = $fim - $inicio;
            $conteudo = substr($lin, $inicio, $quantopula);
            $conteudo = strip_tags($conteudo, '<br>');
            $conteudo = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $conteudo);
            $conditions = array(
                'search_event_id' => $pesquisa,
                'diff_id' => $cortaLink[1],
            );
            if ($this->Transformation->hasAny($conditions)) {
                $this->Session->setFlash(__("A refatoração: <b>" . $cortaLink[1] . "</b> já foi cadastrada nesta pesquisa!"), 'Flash/info');
            } else {
                $this->Transformation->create();
                $refactor = array(
                    'Transformation' => array(
                        'transformation_type_id' => $transformationType,
                        'language_id' => $language,
                        'search_event_id' => $pesquisa,
                        'diff_id' => $cortaLink[1],
                        'site_link' => $url
                    )
                );
                $this->Transformation->save($refactor);

                $nomecode = $cortaLink[1];
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

                $escreve = fwrite($fp, $conteudo);

                fclose($fp);
                umask($oldmask);

                $lastTransformationCreated = $this->Transformation->find('first', array(
                    'conditions' => array('Transformation.diff_id' => $cortaLink[1]),
                    'order' => array('Transformation.created DESC')
                ));

                $this->separaAnteriorETransformado($lastTransformationCreated['Transformation']['id'], $pasta, $caminho);
            }
        }

    }


    function separaAnteriorETransformado($transformation = null, $pasta = null, $arquivo = null)
    {
        //Variável $fp armazena a conexão com o arquivo e o tipo de ação.
        $fp = fopen($arquivo, "r");

        //Lê o conteúdo do arquivo aberto.
        $oldmask = umask(0);
        $a = fopen($pasta . "a.txt", "w+");
        $b = fopen($pasta . "b.txt", "w+");
        $Aconteudo = '';
        $Bconteudo = '';
        while (!feof($fp)) {
            $valor = fgets($fp, 4096);
            if (strstr($valor, "    +")) {
                $valor = str_replace("    +", "      ", $valor);
                $Bconteudo .= fwrite($b, $valor);
            } elseif (strstr($valor, "    -")) {
                $valor = str_replace("    -", "      ", $valor);
                $Aconteudo .= fwrite($a, $valor);
            } else {
                $Aconteudo .= fwrite($a, $valor);
                $Bconteudo .= fwrite($b, $valor);
            }
        }
        fclose($a);
        fclose($b);
        umask($oldmask);
        //Fecha o arquivo.
        fclose($fp);
        $oldCode = fopen($pasta . "a.txt", "r");
        $oldCodeContent = '';
        while (!feof($oldCode)) {
            $oldCodeContent .= fgets($oldCode, 4096);
        }
        fclose($oldCode);

        $newCode = fopen($pasta . "b.txt", "r");
        $newCodeContent = '';
        while (!feof($newCode)) {
            $newCodeContent .= fgets($newCode, 4096);
        }
        fclose($newCode);

        //retorna o conteúdo.
        $this->Transformation->id = $transformation;
        $refactor = array(
            'Transformation' => array(
                'code_before' => "<p>" . $oldCodeContent . "</p>",
                'old_code' => $pasta . "a.txt",
                'code_after' => "<p>" . $newCodeContent . "</p>",
                'new_code' => $pasta . "b.txt",
            )
        );
        $this->Transformation->save($refactor);
    }


    public function index()
    {
        if ($this->Auth->user('UserType.description') == 'administrador') {
            $participations = $this->Participant->find('all', array(
                'conditions' => array(
                    'Participant.participant_type_id' => 1
                ),
                'order' => array('Participant.search_event_id DESC')
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
                    'Participant.user_id' => $this->Auth->user('id')
                ),
                'order' => array('Participant.search_event_id DESC')
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
                'SearchEvent.title' => $search['SearchEvent']['title']
            );

            if ($this->SearchEvent->hasAny($conditions)) {
                $this->Session->setFlash(__('Uma pesquisa com este nome já existe!'), 'Flash/error');
            } else {
                $this->SearchEvent->create();
                $this->SearchEvent->save($search);

                $lastCreated = $this->SearchEvent->find('first', array(
                    'conditions' => array('SearchEvent.title' => $search['SearchEvent']['title'])
                ));

                //pr($lastCreated);exit();

                if ($lastCreated != null) {
                    foreach ($langs as $lang) {
                        $this->LanguageSearchEvent->create();
                        $search_lang = array(
                            'LanguageSearchEvent' => array(
                                'language_id' => $lang,
                                'search_event_id' => $lastCreated['SearchEvent']['id']
                            )
                        );
                        $this->LanguageSearchEvent->save($search_lang);
                    }

                    $this->Participant->create();

                    $participant = array(
                        'Participant' => array(
                            'user_id' => $uid,
                            'search_event_id' => $lastCreated['SearchEvent']['id'],
                            'participant_type_id' => 1
                        )
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
                    'LanguageSearchEvent.search_event_id' => $id
                );
                if ($this->LanguageSearchEvent->hasAny($conditions)) {

                } else {
                    $this->LanguageSearchEvent->create();
                    $search_lang = array(
                        'LanguageSearchEvent' => array(
                            'language_id' => $lang,
                            'search_event_id' => $id
                        )
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

    public function delete($id = null)
    {

    }
}