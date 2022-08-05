<?php

$week_id = NULL;

if (isset($week) && is_object($week)) {
	$week_id = set_value('week_id', $week->week_id);
}

echo form_open(current_url(), ['class' => 'needs-validation', 'id' => 'week_add', 'novalidate' => 'true'], ['week_id' => $week_id]);

?>

<fieldset>

	<legend accesskey="W" tabindex="<?= tab_index() ?>">Semana</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'name';
			$value = set_value($field, isset($week) ? $week->name : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, digite um nome.</div>
		</div>
	</div>
	<?php echo form_error($field) ?>

	<div class="form-group row">
		<label for="bgcol" class="col-sm-2 col-form-label">Cor de fundo</label>
		<div class="col-sm-1">
			<?php
			$field = 'bgcol';
			$value = set_value($field, isset($week) ? $week->bgcol : '', FALSE);

			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '7',
				'maxlength' => '7',
				'tabindex' => tab_index(),
				'value' => $value,
				'onchange' => '$(\'sample\').style.backgroundColor = this.value;',
				'class' => 'form-control-color',
				'type' => 'color'
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


</fieldset>

<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Cancelar', tab_index(), 'weeks'),
));

echo form_close();
