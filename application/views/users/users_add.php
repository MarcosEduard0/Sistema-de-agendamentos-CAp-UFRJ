<?php
$user_id = NULL;
if (isset($user) && is_object($user)) {
	$user_id = set_value('user_id', $user->user_id);
}
echo form_open_multipart('users/save', array('class' => 'needs-validation', 'id' => 'users_add', 'novalidate' => 'true'), array('user_id' => $user_id));

?>

<fieldset>

	<legend accesskey="U" tabindex="<?php echo tab_index() ?>">Detalhes do usuários</legend>
	<div class="form-group row">
		<label for="username" class="col-sm-3 col-form-label">Usuário</label>
		<div class="col-sm-4">
			<?php
			if (!isset($user)) {
				$required = 'required';
			} else {
				$required = '';
			}

			$username = form_error('username');
			$password = form_error('password2');
			if (isset($username) and !$password == '') {
				$valid = 'is-valid';
			} else {
				$valid = '';
			}

			$field = 'username';
			if (form_error($field)) {
				$valid = 'is-invalid';
			}

			$value = set_value($field, isset($user) ? $user->username : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $value,
				'aria-describedby' => 'inputGroupPrepend',
				$required => $required,
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
		<label for="authlevel" class="col-sm-3 col-form-label"> Tipo</label>
		<div class="col-sm-auto">
			<?php
			$authlevel = form_error('authlevel');
			$password = form_error('password2');
			if (isset($authlevel) and !$password == '') {
				$valid = 'is-valid';
			}
			$field = 'authlevel';
			$value = set_value($field, isset($user) ? $user->authlevel : '2', FALSE);
			$options = array('1' => 'ADMINISTRATOR', '2' => 'Professor');
			echo form_dropdown(
				$field,
				$options,
				$value,
				' id="authlevel" class="form-control ' . $valid . '" tabindex="' . tab_index() . '"'
			);
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="enabled" class="col-sm-3 col-form-label">Habilitado</label>
		<div class="col-sm-auto" style="padding-top: 8px;">
			<?php
			$checked = '';
			$value = isset($user) ? $user->enabled : '1';
			echo form_hidden('enabled', '0');
			echo '<div class="custom-control custom-switch">';
			if ($value == 1) {
				$checked = 'checked';
			}
			echo '<input name="enabled" type="checkbox" tabindex="' . tab_index() . '" value = "1" class="custom-control-input" id="enabled" ' . $checked . '>';
			?>
			<label class="custom-control-label" for="enabled"></label>
		</div>
	</div>
	</div>

	<div class="form-group row">
		<label for="email" class="col-sm-3 col-form-label">E-mail</label>
		<div class="col-sm-6">
			<?php
			$field = 'email';
			$value = set_value($field, isset($user) ? $user->email : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '35',
				'maxlength' => '255',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $value,
				'aria-describedby' => 'inputGroupPrepend',
				'type' => 'email',
			));
			?>
			<div class="invalid-feedback">Por favor, digite um e-mail.</div>
		</div>
	</div>
	<?php echo form_error($field); ?>


</fieldset>


<fieldset>

	<legend accesskey="P" tabindex="<?php echo tab_index() ?>">Senha</legend>

	<?php
	if (!isset($user)) {
		$required = 'required';
	} else {
		$required = '';
	}
	?>

	<div class="form-group row">
		<label for="password1" class="col-sm-3 col-form-label">Senha</label>
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
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => '',
				'aria-describedby' => 'inputGroupPrepend',
				$required => $required,
			));
			if (form_error($field)) {
				echo form_error($field);
			} else {
				echo '<div class="invalid-feedback">Por favor, digite uma senha.</div>';
			}
			?>
		</div>
	</div>


	<div class="form-group row">
		<label for="password2" class="col-sm-3 col-form-label">Senha (novamente)</label>
		<div class="col-sm-4">
			<?php
			$field = 'password2';
			if ($valid == 'is-invalid') {
				$valid = 'is-valid';
			} else {
				$valid = '';
			}
			echo form_password(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => '',
				'aria-describedby' => 'inputGroupPrepend',
				$required => $required,
			));
			if (form_error($field)) {
				echo form_error($field);
			} else {
				echo '<div class="invalid-feedback">Por favor, digite a senha novamente.</div>';
			}
			?>
		</div>
	</div>


</fieldset>


<fieldset>

	<legend accesskey="P" tabindex="<?php echo tab_index() ?>">Detalhes Pessoais</legend>

	<div class="form-group row">
		<label for="firstname" class="col-sm-3 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'firstname';
			$value = set_value($field, isset($user) ? $user->firstname : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $value,
				'aria-describedby' => 'inputGroupPrepend',
				'required' => 'true',
			));
			?>
			<div class="invalid-feedback">Por favor, digite o nome.</div>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="lastname" class="col-sm-3 col-form-label">Sobrenome</label>
		<div class="col-sm-4">
			<?php
			$field = 'lastname';
			$value = set_value($field, isset($user) ? $user->lastname : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $value,
				'aria-describedby' => 'inputGroupPrepend',
				'required' => 'true',
			));
			?>
			<div class="invalid-feedback">Por favor, digite o sobrenome.</div>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="displayname" class="col-sm-3 col-form-label">Nome de exibição</label>
		<div class="col-sm-4">
			<?php
			$field = 'displayname';
			$value = set_value($field, isset($user) ? $user->displayname : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'class' => 'form-control ' . $valid,
				'tabindex' => tab_index(),
				'value' => $value,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="department" class="col-sm-3 col-form-label">Departamento</label>
		<div class="col-md-auto">
			<?php
			$options = array('' => '(Nenhum)');
			if ($departments) {
				foreach ($departments as $department) {
					$options[$department->department_id] = html_escape($department->name);
				}
			}

			$value = set_value($field, isset($user) ? $user->department_id : '', FALSE);
			$field = 'department_id';
			echo form_dropdown(
				'department_id',
				$options,
				$value,
				'class="form-control ' . $valid . '" tabindex="' . tab_index() . '"'
			);
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="ext" class="col-sm-3 col-form-label">Telefone</label>
		<div class="col-sm-3">
			<?php
			$field = 'ext';
			$value = set_value($field, isset($user) ? $user->ext : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '13',
				'maxlength' => '15',
				'class' => 'form-control ' . $valid,
				'onkeypress' => "$(this).mask('(00) 0000-00000')",
				'tabindex' => tab_index(),
				'value' => $value,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

</fieldset>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'users'),
));

echo form_close();
