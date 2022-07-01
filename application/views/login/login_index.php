<div class="limiter">
	<div class="container-login100">
		<div class="wrap-login100">
			<div class="login100-pic js-tilt" data-tilt>
				<?= img($logo, FALSE) ?>
			</div>
			<?php
			echo form_open('login/submit', array('id' => 'login', 'class' => 'login100-form validate-form'), array('page' => $this->uri->uri_string()));
			?>
			<div class="container" style="padding: 70px 0 50px 0; text-align: center;">
				<div class="row">
					<div class="col-sm-12">
						<p class="title-login"><?= $title ?></p>
						<?= validation_errors() ?>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-12" style="padding-bottom: 15px;">
						<?php echo $this->session->flashdata('auth') ?>
					</div>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Usuário é obrigatorio">
					<?php
					$value = set_value('username', '', FALSE);
					echo form_input(array(
						'name' => 'username',
						'id' => 'username',
						'size' => '20',
						'maxlength' => '20',
						'placeholder' => " Usuário",
						'class' => "input100",
						'tabindex' => tab_index(),
						'value' => $value,
					));
					?>
					<span class="focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-user" aria-hidden="true"></i>
					</span>
				</div>

				<div class="wrap-input100 validate-input" data-validate="Senha é obrigatoria">
					<?php
					echo form_password(array(
						'name' => 'password',
						'id' => 'password',
						'size' => '20',
						'placeholder' => "Senha",
						'class' => "input100",
						'tabindex' => tab_index(),
						'maxlength' => '20',
					));
					?>
					<span class=" focus-input100"></span>
					<span class="symbol-input100">
						<i class="fa fa-lock" aria-hidden="true"></i>
					</span>
				</div>

				<div class="container-login100-form-btn">
					<button type="submit" class="login100-form-btn">
						Entrar
					</button>
					<?php
					$this->load->view('partials/submit');
					?>

					<div class="text-center p-t-12">
						<span class="txt1">
							Não possui
						</span>
						<a tabindex="0" class="txt2" role="button" data-toggle="popover" data-trigger="focus" title="Cadastro ou redefinir senha" data-content="
						Para realizar um cadastro ou redefir sua senha, procure um bolsista do LiG.">Usuário?</a>
					</div>
					<?php
					echo form_close();
					?>
				</div>

			</div>
			<div class="container" style="padding: 100px 20px 20px; text-align: center;">
				<div class="row align-items-center">
					<div class="col-sm-2"></div>
					<div class="col-sm-8">
						Adptado de <a href="https://www.classroombookings.com/" target="_blank">classroombookings</a> por
						<t up-tooltip="marcos.eduardo22@gmail.com">Marcos Eduardo de Souza</t>.
						<br />Versão <?= VERSION ?>.&copy; <?= date('Y') ?>
					</div>
					<div class="col-sm-2"></div>
				</div>
			</div>
		</div>