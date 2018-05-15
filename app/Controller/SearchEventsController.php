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

    public function loadDataCsv()
    {
        if ($this->request->is('post')) {
            $meuArray = Array();
            $file = fopen('numeros.csv', 'r');
            while (($line = fgetcsv($file)) !== false) {
                $meuArray[] = $line;
            }
            fclose($file);
            print_r($meuArray);
        }
    }

    public function capturaCodigo($pesquisa = null, $transformationType = null, $language = null, $url = null, $start = null, $end = null)
    {
//        $url = "https://github.com/spring-projects/spring-framework/commit/164204ca04b9b369267ef5e36c2f243b3898bae1#diff-82984a3951d9fc77df2cd9d6421dc5d6";

        $cortaLink = explode("#", $url);

        $conecurl = @fopen("$url", "r") or die ('<center>erro na conexão<br><b>informe o administrador erro 15 </b></center>');
        $lin = '';
        while (!feof($conecurl)) {
            $lin .= fgets($conecurl, 4096);
        }
        fclose($conecurl);

        $inicio = strpos($lin, "id='diff-82984a3951d9fc77df2cd9d6421dc5d6" . $start . "' data-line-number='" . substr($start, 1) . "'") + 290;

        $fim = strpos($lin, "id='diff-82984a3951d9fc77df2cd9d6421dc5d6" . $end . "' data-line-number='" . substr($end, 1) . "'");

        $quantopula = $fim - $inicio;
        $conteudo = substr($lin, $inicio, $quantopula);
        $conteudo = strip_tags($conteudo, '<br>');
        $conteudo = preg_replace("/(^[\r\n]*|[\r\n]+)[\s\t]*[\r\n]+/", "\n", $conteudo);

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

        $this->separaAnteriorETransformado($pesquisa, $transformationType, $language, $pasta, $caminho);
    }


    function separaAnteriorETransformado($pesquisa = null, $transformationType = null, $language = null, $pasta = null, $arquivo = null)
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
        //retorna o conteúdo.
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