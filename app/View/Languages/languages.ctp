<div class="row">
    <div class="col-md-12">
        <!-- general form elements -->
        <div class="box box-primary">
            <!-- Horizontal Form -->
            <div class="box box-info">
                <div style="margin-left: 8px; margin-right: 8px;">
                    <h3>Survey Objective</h3>

                    <p style="text-align: justify">Developers use IDEs and code transformation libraries to introduce
                        new programming language constructions into legacy systems, thereby supporting software
                        rejuvenation efforts. However, there are some factors that prevent the application of such
                        tools, including inadequate suggestions of refactoring tools and transformations that do not
                        lead to effective improvements in the source code. Therefore, the main purpose of this research
                        is to investigate empirically whether the adoption of lambda expressions improves or not the
                        understanding of the program-one of the expected benefits by the use of lambda expressions in
                        Java.</p>

                    <h3>CONSENT TERMS</h3>
                    <p style="text-align: justify; font-size: medium;">
                        Participants do not have the obligation to answer the research questionnaire until the end, but
                        it is of the utmost importance to answer all questions with seriousness and sincerity. We
                        believe that your attendance is your own free will. By proceeding to the next screen, you agree
                        to the terms for this research.</p>

                    <h3>INSTRUCTIONS</h3>
                    <p style="text-align: justify">To participate in this survey, it is necessary to answer 6 questions
                        for each pair of code snippets presented at the top of the screen.<br>
                        - The code snippets are organized in: the <b>Old Version</b> (code before to add
                        the lambda expression) and the <b>New Version</b> (after the change and introduction of lambda
                        expressions to the snippet).<br>
                        - Below the participant will have 5 options to inform their agreement / disagreement level
                        according to their observation regarding the two codes presented.<br>
                        - In addition to the questions with options to be selected, the participant can inform the
                        reason for their choices through a text field (<b>Optional, but of extreme importance for
                        contribution to the research</b>) located at the bottom of the page just below the options. <br>
                        - <b>The participant may evaluate 10 pieces of code answering the 6 questions presented on the screen.</b>.

                    </p>
                </div>
                <div class="box-header with-border">
                    <h3 class="box-title">Language
                        <?= $linguagem['Language']['description']; ?>
                    </h3>
                </div>

                <form class="form-horizontal" method="post" action="<?= $this->webroot ?>languages/languages">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Time experience</label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('UserLanguage.experience', array(
                                    'type' => 'select',
                                    'label' => false,
                                    'options' => array('1' => '1 year', '2' => '2 years', '3' => '3 years', '4' => '4 years', '5' => '5 years',
                                        '6' => '6 years', '7' => '7 years', '8' => '8 years', '9' => '9 years', '10' => '10 years', '11' => 'over 10 years'),
                                    'default' => 5,
                                    'class' => 'form-control'
                                )); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">functional programming</label>
                            <div class="col-sm-4">
                                <select name="data[User][functional_program]" required class="form-control">
                                    <option disabled selected value> -- experience --</option>
                                    <option value="NC">I never programmed in functional languages</option>
                                    <option value="1">Less than a year</option>
                                    <option value="1-4">1 a 4 years</option>
                                    <option value="4-5">4 a 5 years</option>
                                    <option value="5+">over 5 years</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Do you know / use lambda expressions?</label>
                            <div class="col-sm-4">
                                <select name="data[User][lambda_exp]" required class="form-control">
                                    <option disabled selected value> -- select an answer --</option>
                                    <option value="S">Yes</option>
                                    <option value="N">No</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Formation</label>
                            <div class="col-sm-4">
                                <select name="data[User][formation]" required class="form-control">
                                    <option disabled selected value> -- Formation --</option>
                                    <option value="EMC">Complete high school</option>
                                    <option value="SI">Incomplete higher</option>
                                    <option value="SC">Graduated</option>
                                    <option value="PGI">Post incomplete graduation</option>
                                    <option value="PGC">Complete post graduation</option>
                                    <option value="MM">Master's degree</option>
                                    <option value="DC">Doctorate degree</option>
                                    <option value="PDC">Post Doctoral</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Profession</label>
                            <div class="col-sm-4">
                                <select name="data[User][profession]" required class="form-control">
                                    <option disabled selected value> -- Profession --</option>
                                    <option value="DJ">Developer junior</option>
                                    <option value="DP">Developer Full</option>
                                    <option value="DS">Senior Developer</option>
                                    <option value="AD">Analyst/Developer</option>
                                    <option value="AS">Senior analyst</option>
                                    <option value="TT">Tester</option>
                                    <option value="OT">Others</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Sex</label>
                            <div class="col-sm-4">
                                <select name="data[User][sex]" required class="form-control">
                                    <option disabled selected value> -- Sex --</option>
                                    <option value="Masculino">Male</option>
                                    <option value="Feminino">Female</option>
                                    <option value="Não informado">Not inform</option>
                                </select>
                            </div>
                            <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
                        </div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="data[UsersLanguage][languages_id]"
                                value="<?= $linguagem['Language']['id']; ?>"
                                class="btn btn-info pull-right">Save
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
            </div>
        </div>
        <!-- /.col-->
    </div>
