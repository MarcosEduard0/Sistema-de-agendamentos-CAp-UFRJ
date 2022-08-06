<?php
$holiday_id = NULL;
if (isset($holiday) && is_object($holiday)) {
	$holiday_id = set_value('holiday_id', $holiday->holiday_id);
}

echo form_open(current_url(), array('class' => 'needs-validation', 'id' => 'holiday_add', 'novalidate' => 'true'), array('holiday_id' => $holiday_id));

?>

<fieldset>

	<legend accesskey="H" tabindex="<?= tab_index() ?>">Informações do feriado</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'name';
			$value = set_value($field, isset($holiday) ? $holiday->name : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '30',
				'maxlength' => '40',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, digite o nome do feriado.</div>
		</div>
	</div>
	<?php echo form_error($field) ?>

	<div class="form-group row">
		<label for="date_start" class="col-sm-2 col-form-label">Data de Início</label>
		<div class="col-sm-4">
			<?php
			$field = 'date_start';
			$value = set_value('date_end', isset($holiday) ? $holiday->date_start->format('Y-m-d') : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '10',
				'maxlength' => '10',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'type' => 'date',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, informe a data de início.</div>

		</div>
		<!-- <img style="cursor:pointer" align="top" src="<?= base_url('assets/images/ui/cal_day.png') ?>" width="16" height="16" title="Choose date" onclick="displayDatePicker('date_start', false);" /> -->
	</div>
	<?php echo form_error($field) ?>


	<div class="form-group row">
		<label for="date_start" class="col-sm-2 col-form-label">Data de término</label>
		<div class="col-sm-4">
			<?php
			$field = 'date_end';
			$value = set_value('date_end', isset($holiday) ? $holiday->date_end->format('Y-m-d') : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '10',
				'maxlength' => '10',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'type' => 'date',
				'required' => '',
			));
			?>

			<div class="invalid-feedback">Por favor, informe a data de término.</div>
			<!-- <img style="cursor:pointer" align="top" src="<?= base_url('assets/images/ui/cal_day.png') ?>" width="16" height="16" title="Choose date" onclick="displayDatePicker('date_end', false);" /> -->
		</div>
	</div>
	<?php echo form_error($field) ?>


</fieldset>

<?php


$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Cancelar', tab_index(), 'holidays/session/' . $session->session_id),
));

echo form_close();
