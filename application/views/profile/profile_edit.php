<?php

echo form_open('profile/save', array('class' => 'needs-validation', 'id' => 'profile_edit', 'novalidate' => 'true'));

?>


<fieldset>

	<legend accesskey="U" tabindex="<?php tab_index() ?>">Informação do usuário</legend>

	<div class="form-group row">
		<label for="email" class="col-sm-3 col-form-label">E-mail</label>
		<div class="col-sm-5">
			<?php
			$email = form_error('email');
			$password = form_error('password1');
			if (isset($email) and !$password == '') {
				$valid = 'is-valid';
			} else {
				$valid = '';
			}
			$field = 'email';
			$email = set_value($field, $user->email, FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '35',
				'maxlength' => '255',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $email,
			));
			?>
		</div>
	</div>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="password1">Senha</label>
		<div class="col-sm-4">
			<?php
			$field = 'password1';
			if (form_error($field)) {
				$valid = 'is-invalid';
			} else {
				$valid = '';
			}
			echo form_password(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '40',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => '',
			));
			if (form_error($field)) {
				echo form_error($field);
			} else {
				echo '<div class="invalid-feedback">Por favor, digite um usuário.</div>';
			}

			if ($valid == 'is-invalid') {
				$valid = 'is-valid';
			} else {
				$valid = '';
			}
			?>
		</div>
	</div>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="password2">Senha (novamente)</label>
		<div class="col-sm-4">
			<?php
			$field = 'password2';
			if (form_error($field)) {
				$valid = 'is-invalid';
			} else {
				$valid = '';
			}
			echo form_password(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '40',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => '',
			));
			if ($valid == 'is-invalid') {
				$valid = 'is-valid';
			} else {
				$valid = '';
			}
			?>
		</div>
	</div>
	<!-- <?php echo form_error($field); ?> -->


</fieldset>


<fieldset>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="firstname">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'firstname';
			$firstname = set_value($field, $user->firstname, FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $firstname,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="lastname">Sobrenome</label>
		<div class="col-sm-4">
			<?php
			$field = 'lastname';
			$lastname = set_value($field, $user->lastname, FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $lastname,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="displayname">Nome de exibição</label>
		<div class="col-sm-4">
			<?php
			$field = 'displayname';
			$displayname = set_value($field, $user->displayname, FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $displayname,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="department">Departamento</label>
		<div class="col-sm-4">
			<?php
			if (isset($department)) {
				$options = html_escape($department);
			} else {
				$options = '(nenhum)';
			}
			$field = 'department_id';
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $options,
				'disabled' => ''
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


	<div class="form-group row">
		<label class="col-sm-3 col-form-label" for="ext">Telefone</label>
		<div class="col-sm-4">
			<?php
			$field = 'ext';
			$ext = set_value($field, $user->ext, FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '13',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'onkeypress' => "$(this).mask('(00) 0000-00000')",
				'tabindex' => tab_index(),
				'value' => $ext,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


</fieldset>


<?php
$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Cancelar', tab_index(), '/'),
));

echo form_close();
?>