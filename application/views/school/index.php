<?php
echo $this->session->flashdata('saved');
echo form_open_multipart(current_url(), array('id' => 'schooldetails', 'class' => 'needs-validation', 'novalidate' => 'true'));
?>


<fieldset>

	<legend accesskey="I" tabindex="<?php echo tab_index(); ?>">Informação Escolar</legend>

	<div class="form-group row">
		<label for="schoolname" class="col-sm-2 col-form-label">Nome da escola</label>
		<div class="col-sm-4">
			<?php
			$value = set_value('schoolname', element('name', $settings), FALSE);
			echo form_input(array(
				'name' => 'schoolname',
				'id' => 'schoolname',
				'size' => '30',
				'maxlength' => '255',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, digite o nome do colégo.</div>
		</div>
	</div>
	<?php echo form_error('schoolname'); ?>

	<div class="form-group row">
		<label for="website" class="col-sm-2 col-form-label">Site da escola</label>
		<div class="col-sm-4">
			<?php
			$value = set_value('website', element('website', $settings), FALSE);
			echo form_input(array(
				'name' => 'website',
				'id' => 'website',
				'size' => '40',
				'maxlength' => '255',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control'
			));
			?>
		</div>
	</div>
	<?php echo form_error('website'); ?>

</fieldset>



<fieldset>

	<legend accesskey="L" tabindex="<?php echo tab_index() ?>">Logotipo da escola</legend>

	<spam class='bd-content-title'>Use esta seção para fazer o upload do logotipo da instituição.</spam><br>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Logotipo atual</label>
		<div class="col-sm-4" style="padding-top: 10px;">
			<?php
			$logo = element('logo', $settings);
			if (!empty($logo) && is_file(FCPATH . 'uploads/' . $logo)) {
				echo img('uploads/' . $logo, FALSE, "style='padding:1px; border:1px solid #ccc; max-width: 300px; width: auto; height: auto'");
			} else {
				echo "<span><em>Nenhum encontrado</em></span>";
			}
			?>
		</div>
	</div>


	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="userfile">Carregar imagem</label>
		<div class="col-sm-4" style="padding-top: 5px;">
			<?php
			echo form_upload(array(
				'name' => 'userfile',
				'id' => 'userfile',
				'size' => '25',
				'maxlength' => '255',
				'tabindex' => tab_index(),
				'value' => '',
				'class' => 'form-control-file'
			));
			?>
			<small class="form-text text-muted">Carregar um novo logotipo irá <strong>subistituir</strong> o atual.</small>
		</div>
	</div>

	<?php
	if ($this->session->flashdata('image_error') != '') {
		echo "<p class='hint error'><span>" . $this->session->flashdata('image_error') . "</span></p>";
	}
	?>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="logo_delete">Deletar logotipo?</label>
		<div class="col-sm-10" style="padding-top: 8px;">
			<?php
			echo form_hidden('logo_delete', '0');
			echo '<div class="custom-control custom-switch">';
			echo '<input name="logo_delete" type="checkbox" tabindex="' . tab_index() . '" value = "1" class="custom-control-input" id="logo_delete">';
			?>
			<label class="custom-control-label" for="logo_delete"></label>
		</div>
		<small class="form-text text-muted">Ative esta caixa para <strong>excluir</strong> o logotipo atual. Se você estiver enviando um novo logotipo, isso será feito automaticamente.</small>
	</div>
	</div>

</fieldset>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'controlpanel'),
));

echo form_close();
