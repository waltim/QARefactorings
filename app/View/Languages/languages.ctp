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
                        believe that your attendance is your own free will. <b>By proceeding to the next screen, you agree
                        to the terms for this research</b>.</p>

                    <h3>INSTRUCTIONS</h3>
                    <p style="text-align: justify; font-size: 16px;">To participate in this survey, it is necessary to answer 7 questions
                        for each pair of code snippets presented at the top of the screen.<br>
                        - The code snippets are organized in: the <b>Old Version</b> (code before adding
                        the lambda expression) and the <b>New Version</b> (after the change and introduction of lambda
                        expressions to the snippet).<br>
                        - Below, the participants will have 5 options to inform their agreement / disagreement level
                        according to their observation regarding the two codes presented.<br>
						- The final question is not mandatory and allows you to write your opinion about the other questions answered previously. But this question is very important for this research and we need to you answer it.
                        - <b>The participant may evaluate 5 snippets of code answering the 7 questions presented on the screen.</b>.

                    </p>
                </div>

				<?php if(empty($getUser['Language'])){ ?>
                <div class="box-header with-border">
                    <h3 class="box-title">
						Developer experience
                    </h3>
                </div>

                <form class="form-horizontal" method="post" action="<?= $this->webroot ?>languages/languages">
                    <div class="box-body">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Development experience</label>
                            <div class="col-sm-4">
                                <?php echo $this->Form->input('UserLanguage.experience', array(
                                    'type' => 'select',
                                    'label' => false,
                                    'options' => array(
                                    	'less than one year' => 'less than one year',
										'between one and four years' => 'between one and four years',
										'between five and ten years' => 'between five and ten years',
										'more than ten years' => 'more than ten years'),
                                    'class' => 'form-control',
									'required' => 'required',
									'empty'=>'Choose One'
                                )); ?>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputEmail3" class="col-sm-2 control-label">Education</label>
                            <div class="col-sm-4">
                                <select name="data[User][formation]" required class="form-control">
                                    <option disabled selected value>Choose One</option>
                                    <option value="hsn">Some high school, no diploma</option>
                                    <option value="hsg">High school graduate</option>
									<option value="under">Undergraduate</option>
                                    <option value="bd">Bachelor’s degree</option>
                                    <option value="md">Master’s degree</option>
                                    <option value="dd">Doctorate degree</option>
                                </select>
                            </div>
                        </div>

						<div class="form-group">
							<label for="inputEmail3" class="col-sm-2 control-label">Employment</label>
							<div class="col-sm-4">
								<select name="data[User][profession]" required class="form-control">
									<option disabled selected value>Choose One</option>
									<option value="dfullst">Developer, full-stack</option>
									<option value="dback">Developer, back-and</option>
									<option value="dfront">Developer, front-and</option>
									<option value="dmbile">Developer, mobile</option>
									<option value="dmbile">Educator</option>
									<option value="dmbile">Student</option>
								</select>
							</div>
						</div>
                    </div>
                    <!-- /.box-body -->
                    <div class="box-footer">
                        <button type="submit" name="data[UsersLanguage][languages_id]"
                                value="<?= $linguagem['Language']['id']; ?>"
                                class="btn btn-info pull-right">Go to survey
                        </button>
                    </div>
                    <!-- /.box-footer -->
                </form>
				<?php }else{ ?>
					<div class="box-footer">
						<a href="<?php $this->webroot;?>/questions/likert" class="btn btn-info pull-right"> Return to survey </a>
					</div>
				<?php } ?>
            </div>
        </div>
        <!-- /.col-->
    </div>
