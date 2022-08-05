<?php
echo $this->session->flashdata('saved');
echo isset($notice) ? $notice : '';
echo form_open_multipart(current_url(), array('class' => 'cssform', 'id' => 'user_import'));
echo form_hidden('action', 'import');
?>

<fieldset class="cssform-stacked">

	<legend accesskey="I" tabindex="<?= tab_index() ?>">Fonte de importação</legend>

	<p class="input-group">
		<label for="userfile" class="required">Arquivo CSV</label>
		<?php
		echo form_upload(array(
			'name' => 'userfile',
			'id' => 'userfile',
			'size' => '40',
			'maxlength' => '255',
			'tabindex' => tab_index(),
			'value' => '',
		));
		?>
	<p class="hint" style="padding-left:0px">Tamanho máximo do arquivo <strong><?php echo $max_size_human ?></strong>.</p>
	</p>


</fieldset>



<fieldset>

	<legend accesskey="F">Valores padrão</legend>

	<div class="forme-group" style="padding-left: 10px;">
		<div>Insira os valores padrão que serão aplicados a todos os usuários se não forem especificados no arquivo de importação.</div></br>

		<div class="form-group row">
			<label class="col-sm-3 col-form-label" style="margin-left: 0px" for="password">Senha</label>
			<div class="col-sm-8">
				<?php
				echo form_password(array(
					'name' => 'password',
					'id' => 'password',
					'size' => '20',
					'maxlength' => '40',
					'tabindex' => tab_index(),
					'value' => '',
					'class' => 'form-control',
				));
				?>
				<div class="invalid-feedback">Por favor, preencha este campo.</div>
			</div>
		</div>


		<div class="form-group row">
			<label class="col-sm-3 col-form-label" style="margin-left: 0px" for="authlevel">Tipo</label>
			<div class="col-sm-8">
				<?php
				$data = array('1' => 'ADMINISTRATOR', '2' => 'Professor');
				echo form_dropdown(
					'authlevel',
					$data,
					'2',
					' id="authlevel" tabindex="' . tab_index() . '" class="form-control"'
				);
				?>
				<div class="invalid-feedback">Por favor, preencha este campo.</div>
			</div>
		</div>


		<!-- <div class="form-group row">
			<label class="col-sm-3 col-form-label" style="margin-left: 0px" for="enabled">Habilitado</label>
			<div class="col-sm-8">
				<?php
				echo form_hidden('enabled', '0');
				echo form_checkbox(array(
					'name' => 'enabled',
					'id' => 'enabled',
					'value' => '1',
					'tabindex' => tab_index(),
					'checked' => true,
				));
				?>
				<div class="invalid-feedback">Por favor, preencha este campo.</div>
			</div>
		</div> -->

		<div class="form-group row">
			<label for="enabled" class="col-sm-3 col-form-label" style="margin-left:0px">Habilitado</label>
			<div class="col-sm-auto" style="padding-top: 8px;">
				<?php
				$checked = '';
				$value =  '1';
				echo form_hidden('enabled', '0');
				echo '<div class="custom-control custom-switch">';
				$checked = 'checked';
				echo '<input name="enabled" type="checkbox" tabindex="' . tab_index() . '" value = "1" class="custom-control-input" id="enabled" ' . $checked . '>';
				?>
				<label class="custom-control-label" for="enabled" style="margin-left:0px"></label>
			</div>
		</div>
	</div>
</fieldset>

<?php

$this->load->view('partials/submit', array(
	'submit' => array('Criar Contas', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'users'),
));

echo form_close();
