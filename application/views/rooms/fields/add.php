<?php
$field_id = NULL;
if (isset($field) && is_object($field)) {
	$field_id = set_value('field_id', $field->field_id);
}

echo "<!-- $field_id -->";

if ( ! empty($field_id)) {
	echo msgbox('exclamation', 'Você não pode alterar o tipo de um campo. Em vez disso, exclua o campo e crie um novo.');
}

echo form_open('rooms/save_field', array('class' => 'needs-validation', 'id' => 'fields_add', 'novalidate'=> 'true'), array('field_id' => $field_id));
?>

<br />

<fieldset>

	<legend accesskey="F" tabindex="<?= tab_index() ?>">Detalhes do Campo</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$input_name = 'name';
			$value = set_value($input_name, isset($field) ? $field->name : '', FALSE);
			echo form_input(array(
				'name' => $input_name,
				'id' => $input_name,
				'size' => '30',
				'maxlength' => '64',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, digite o nome do campo.</div>
		</div>
	</div>
	<?php echo form_error($input_name); ?>

	<?php if ( ! isset($field)): ?>

	<div class="form-group row">
		<label for="type"  class="col-sm-2 col-form-label">Tipo</label>
		<div class="col-sm-3" style="padding-top: 8px;">
			<?php

			$input_name = 'type';
			$value = set_value($input_name, isset($field) ? $field->type : '', FALSE);

			foreach ($options_list as $k => $v) {
				$id = "{$input_name}_{$k}";
				$input = form_radio(array(
					'name' => $input_name,
					'id' => $id,
					'value' => $k,
					'checked' => ($value == $k),
					'tabindex' => tab_index(),
					'up-switch' => '.dropdown_options',
				));
				echo "<label for='{$id}' class='ni'>{$input}{$v}</label>";
			}
		?>
		</div>
	</div>
	<?php echo form_error($input_name); ?>

	<?php else: ?>

	<?php
	$input_name = 'type';
	$value = set_value($input_name, isset($field) ? $field->type : '');
	echo form_input(array(
		'type' => 'hidden',
		'name' => $input_name,
		'id' => $input_name,
		'value' => $value,
	));
	?>

	<?php endif; ?>

	<?php
	$options_attrs = '';
	if ( ! isset($field)) {
		$options_attrs .= ' up-show-for="SELECT" ';
	} elseif (isset($field) && $field->type != 'SELECT') {
		$options_attrs .= 'style="display:none"';
	}
	?>

	<div class="dropdown_options" <?= $options_attrs ?>>
		<div class="form-group row">
			<label for="items"  class="col-sm-2 col-form-label">Itens</label>
			<div class="col-sm-8" style="padding-top: 8px;">
				<?php
				$input_name = 'options';
				$options_str = '';
				if (isset($field) && is_array($field->options)) {
					$option_values = array();
					foreach ($field->options as $option) {
						$option_values[] = html_escape($option->value);
					}
					$options_str = implode("\n", $option_values);
				}
				$value = set_value($input_name, $options_str, FALSE);
				echo form_textarea(array(
					'name' => $input_name,
					'id' => $input_name,
					'rows' => '10',
					'cols' => '40',
					'tabindex' => tab_index(),
					'value' => $options_str,
					'class' => 'form-control',
				));
				?><small class="form-text text-muted">Insira as opções selecionáveis para a lista suspensa aqui; um em cada linha.</small>
				</div>
		</div>
		<?php echo form_error($input_name); ?>
	</div>

</fieldset>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'rooms/fields'),
));

echo form_close();
