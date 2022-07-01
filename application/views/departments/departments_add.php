<?php
$department_id = NULL;
if (isset($department) && is_object($department)) {
	$department_id = set_value('department_id', $department->department_id);
}

echo form_open('departments/save', array('class' => 'needs-validation', 'id' => 'department_add', 'novalidate'=> 'true'), array('department_id' => $department_id) );
?>

<fieldset>

	<legend accesskey="D" tabindex="<?= tab_index() ?>">Detalhes do departamento</legend>

	<div class="form-group row">
		<label for="name"class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'name';
			if(form_error($field)){$valid = 'is-invalid';}
			else{$valid = '';}

			$value = set_value($field, isset($department) ? $department->name : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '50',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control '.$valid,
				'required' => '',
			));
			if(form_error($field)){echo '<div class="invalid-feedback" style="display: block;">Departamento já existente.</div>';}
			else{echo '<div class="invalid-feedback">Por favor, digite o nome do departamento.</div>';}

			if($valid == 'is-invalid'){$valid = 'is-valid';} 
			else{$valid = '';}
			?>
		</div>
	</div>

	<div class="form-group row">
		<label for="description" class="col-sm-2 col-form-label">Descrição</label>
		<div class="col-sm-4">
			<?php
			$field = 'description';
			$value = set_value($field, isset($department) ? $department->description : '', FALSE);
			echo form_textarea(array(
				'name' => $field,
				'id' => $field,
				'columns' => '50',
				'rows' => '3',
				'maxlength' => '255',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control '.$valid,
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

</fieldset>

<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'departments'),
));

echo form_close();
