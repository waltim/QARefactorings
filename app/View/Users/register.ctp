<div class="register-box-body">
    <p class="login-box-msg">Cadastro de usuário</p>

    <form action="<?= $this->webroot ?>Users/register" method="post">
        <div class="form-group has-feedback">
            <input name="data[User][name]" required type="text" class="form-control" placeholder="Nome e Sobrenome">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="data[User][age]" required type="text" class="form-control" placeholder="Sua idade">
            <span class="glyphicon glyphicon-user form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="data[User][work]" type="text" class="form-control" placeholder="Seu trabalho - Ex: Programador, etc...">
            <span class="glyphicon glyphicon-search form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <select name="data[User][sex]" required class="form-control">
                <option disabled selected value> -- Sexo --</option>
                <option value="Masculino">Masculino</option>
                <option value="Feminino">Feminino</option>
                <option value="Não informado">Não informar</option>
            </select>
            <span class="glyphicon glyphicon-eye-open form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="data[User][email]" required type="email" class="form-control" placeholder="Email">
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
        </div>
        <div class="form-group has-feedback">
            <input name="data[User][password]" required type="password" class="form-control" placeholder="Senha">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
        </div>
        <div class="row">
            <div class="col-xs-8">
                <div class="checkbox icheck">
                    <label>
                        <!-- <input type="checkbox"> Concordo com os <a href="#">termos</a> -->
                    </label>
                </div>
            </div>
            <!-- /.col -->
            <div class="col-xs-4">
                <button type="submit" class="btn btn-primary btn-block btn-flat">Registrar</button>
            </div>
            <!-- /.col -->
        </div>
    </form>

    <!-- <div class="social-auth-links text-center">
      <p>- OR -</p>
      <a href="#" class="btn btn-block btn-social btn-facebook btn-flat"><i class="fa fa-facebook"></i> Sign up using
        Facebook</a>
      <a href="#" class="btn btn-block btn-social btn-google btn-flat"><i class="fa fa-google-plus"></i> Sign up using
        Google+</a>
    </div> -->

    <?php
    echo $this->Html->link(
        'Já possuo cadastro',
        array(
            'controller' => 'Users',
            'action' => 'login',
            //'ext' => 'html'
        ),
        array(
            'class' => 'btn btn-block btn-social btn-facebook btn-flat',
            'style' => 'text-align: center; padding-left: 15px;'
        )
    );
    ?>

</div>
