<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div style="margin-left: 8px; margin-right: 8px;">
                <h3>OBJETIVO DA PESQUISA</h3>

                <p style="text-align: justify">Desenvolvedores utilizam IDEs e bibliotecas de transformação
                de código para introduzir novas construções de linguagem de programação em
                sistemas legados, suportando assim esforços de rejuvenescimento de software.
                No entanto, existem alguns fatores que impedem a aplicação de tais ferramentas, incluindo
                sugestões inadequadas de ferramentas de refatoração e transformações que não levam a
                melhorias efetivas no código-fonte. Dessa forma, o principal objetivo desta pesquisa é investigar empiricamente
                se a adoção de expressões lambda melhora ou não a compreensão do programa—um dos
                    benefícios esperados pelo uso de expressões lambda em Java.</p>

                    <h3>TERMOS DE CONSENTIMENTO</h3>
                    <p style="text-align: justify; font-size: medium;">
                        Os participantes não possuem a obrigação de responder o questionário de pesquisa até o fim, <b> mas é de suma importância
                        que todas as questões sejam respondidas com o maior grau de seriedade e sinceridade</b>. Acreditamos que sua participação seja por livre e espontanea vontade. Ao prosseguir para a próxima tela, você estara concordando com os termos
                    para realização desta pesquisa.</p>

                <h3>INSTRUÇÕES</h3>
                    <p style="text-align: justify">Para participar desta pesquisa, será necessário que o participador responda 10 questões
                        sobre os trechos de código apresentados no topo da tela.<br>
                        - Os trechos de código estão organizados em: o <b>código anterior</b> (código antes da alteração para adição das novas construções) e
                        o <b>código transformado</b> (depois da alteração e introdução de expressões lambda ao trecho).<br>
                        - Logo abaixo o participador terá 5 opções para informar seu nível concordância/discordância de acordo com
                        sua observação em relação aos dois códigos apresentados.<br>
                        - Além das opções a serem selecionadas, o participador poderá informar o motivo de sua escolha através
                        de um campo de texto (<b>Opcional, mas de extrema importância para contribuição com a pesquisa</b>)
                        logo abaixo das opções.

                    </p>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Linguagem <?= $linguagem['Language']['description']; ?></h3>
                </div>

                <form class="form-horizontal" method="post" action="<?= $this->webroot ?>languages/languages">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Tempo de experiência</label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('UserLanguage.experience', array(
                                    'type' => 'select',
                                    'label' => false,
                                    'options' => array('1' => '1 ano', '2' => '2 anos', '3' => '3 anos', '4' => '4 anos', '5' => '5 anos',
                                        '6' => '6 anos', '7' => '7 anos', '8' => '8 anos', '9' => '9 anos', '10' => '10 anos', '11' => 'mais de 10 anos'),
                                    'default' => 5,
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Formação</label>
                            <div class="col-sm-4">
                                <select name="data[User][formation]" required class="form-control">
                                    <option disabled selected value> -- Formação --</option>
                                    <option value="EMC">Ensino médio completo</option>
                                    <option value="SI">Superior incompleto</option>
                                    <option value="SC">Superior completo</option>
                                    <option value="PGI">Pós Graduação incompleta</option>
                                    <option value="PGC">Pós Graduação completa</option>
                                    <option value="MM">Mestrado</option>
                                    <option value="DC">Doutorado</option>
                                    <option value="PDC">Pós Doutorado</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="data[UsersLanguage][languages_id]"
                                value="<?= $linguagem['Language']['id']; ?>" class="btn btn-info pull-right">Salvar
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.col-->
    </div>
