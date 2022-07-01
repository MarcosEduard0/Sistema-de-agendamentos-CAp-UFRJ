<?php
$period_id = NULL;
if (isset($period) && is_object($period)) {
	$period_id = set_value('period_id', $period->period_id);
}

echo form_open('periods/save', array('class' => 'needs-validation', 'id' => 'schoolday_add', 'novalidate'=> 'true'), array('period_id' => $period_id) );

?>

<fieldset>

	<legend accesskey="R" tabindex="<?php echo tab_index() ?>">Detalhes do período</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
				$field = 'name';
				$value = set_value($field, isset($period) ? $period->name : '', FALSE);
				echo form_input(array(
					'name' => $field,
					'id' => $field,
					'size' => '25',
					'maxlength' => '30',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control',
					'required' => ''
				));
			?>
			<div class="invalid-feedback">Por favor, digite um nome.</div>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="time_start" class="col-sm-2 col-form-label">Horário de Início</label>
		<div class="col-sm-auto">
			<?php
				$field = 'time_start';
				$value = set_value($field, isset($period) ? $period->time_start : '', FALSE);
				$value = strftime('%H:%M', strtotime($value));
				echo form_input(array(
					'name' => $field,
					'id' => $field,
					'size' => '5',
					'maxlength' => '5',
					'type'=> 'time',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control'
				));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>


	<div class="form-group row">
		<label for="time_end" class="col-sm-2 col-form-label">Horário de Término</label>
		<div class="col-sm-auto">
			<?php
				$field = 'time_end';
				$value = set_value($field, isset($period) ? $period->time_end : '', FALSE);
				$value = strftime('%H:%M', strtotime($value));
				echo form_input(array(
					'name' => $field,
					'id' => $field,
					'size' => '5',
					'maxlength' => '5',
					'type'=> 'time',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control'
				));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="days" >Dias da semana</label>
		<div class="col-sm-3" style="padding-top: 8px">
		<?php
			$default_value = array();

			foreach ($days_list as $day_num => $day_name) {
				$field = "day_{$day_num}";
				$checked = '';
				$value = set_value($field, isset($period) ? $period->$field : ($day_num < 6));
				echo form_hidden($field, '0');
				echo '<div class="custom-control custom-switch">';
				if($value){$checked = 'checked';}
				echo '<input name="'.$field.'" type="checkbox" tabindex="'.tab_index().'" value = "1" class="custom-control-input" id="'.$field.'" '.$checked.'>';
				echo "<label for='{$field}' class='custom-control-label'>{$day_name}</label></div>";
			}
			?>
		</div>
	</div>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="bookable">Agendável</label>
		<div class="col-sm-3" style="padding-top: 8px">
			<?php
			$field = 'bookable';
			echo form_hidden($field, '0');
			echo form_checkbox(array(
				'name' => 'bookable',
				'id' => 'bookable',
				'value' => '1',
				'tabindex' => tab_index(),
				'checked' => set_value($field, isset($period) ? $period->bookable : 1, TRUE),
			));
			?>
		</div>
		<div class="hit">Marque esta caixa para permitir agendamentos para este período</div>
	</div>

</fieldset>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'periods'),
));

echo form_close();
