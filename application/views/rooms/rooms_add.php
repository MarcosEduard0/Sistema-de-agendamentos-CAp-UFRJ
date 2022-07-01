<?php
$room_id = NULL;
if (isset($room) && is_object($room)) {
	$room_id = set_value('room_id', $room->room_id);
}

echo form_open_multipart('rooms/save', array('class' => 'needs-validation', 'id' => 'rooms_add', 'novalidate'=> 'true'), array('room_id' => $room_id) );

?>

<fieldset>

	<legend accesskey="R" tabindex="<?php echo tab_index() ?>">Detalhes da Sala</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'name';
			$value = set_value($field, isset($room) ? $room->name : '', FALSE);
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
			<div class="invalid-feedback">Por favor, digite o nome da sala.</div>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="location" class="col-sm-2 col-form-label">Localização</label>
		<div class="col-sm-4">
			<?php
			$field = 'location';
			$value = set_value($field, isset($room) ? $room->location : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '30',
				'maxlength' => '40',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="user_id" class="col-sm-2 col-form-label">Profesor</label>
		<div class="col-sm-4">
			<?php
			$userlist = array('' => '(Nenhum)');
			foreach ($users as $user) {
				$label = empty($user->displayname) ? $user->username : $user->displayname;
				$userlist[ $user->user_id ] = html_escape($label);
			}
			$field = 'user_id';
			$value = set_value($field, isset($room) ? $room->user_id : '', FALSE);
			echo form_dropdown($field, $userlist, $value, 'tabindex="'.tab_index().'" class= "form-control"');
			?>
		</div>
		</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="notes" class="col-sm-2 col-form-label">Descrição</label>
		<div class="col-sm-8">
			<?php
			$field = 'notes';
			$value = set_value($field, isset($room) ? $room->notes : '', FALSE);
			echo form_textarea(array(
				'name' => $field,
				'id' => $field,
				'rows' => '5',
				'cols' => '30',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
			));
			?>
		</div>
	</div>
	<?php echo form_error($field) ?>

	<div class="form-group row">
		<label for="bookable" class="col-sm-2 col-form-label">Agendável</label>
		<div class="col-sm-10" style="padding-top: 8px;">
		<?php
		$field = 'bookable';
		$value = isset($room) ? $room->bookable : '1';
		$checked = set_checkbox($field, '1', $value == '1');
		echo form_hidden($field, '0');
		echo form_checkbox(array(
			'name' => $field,
			'id' => $field,
			'value' => '1',
			'tabindex' => tab_index(),
			'checked' => $checked,
		));
		?>
		<small class="form-text text-muted">Marque esta caixa para permitir que os agendamentos sejam feitos nesta sala.</small>
		</div>
	</div>

</fieldset>


<fieldset>

	<legend accesskey="P" tabindex="7">Foto</legend>

	<spam class="bd-content-title">Adicione uma foto da sala que os usuários poderão ver.</spam>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label">Foto atual</label>
		<div class="col-sm-4" style="padding-top: 8px;">
		<?php
		if (isset($room) && isset($room->photo) && ! empty($room->photo)) {
			$path = "uploads/{$room->photo}";
			if (file_exists(FCPATH . $path)) {
				$url = base_url($path);
				$img = img($path, FALSE, "width='200' style='width:200px;height:auto;max-width:200px;padding:1px;border:1px solid #ccc'");
				echo anchor($url, $img);
			} else {
				echo '<em>Nenhuma</em>';
			}
		} else {
			echo '<em>Nenhuma</em>';
		}
		?>
		</div>
	</div>

	<div class="form-group row">
		<label for="userfile" class="col-sm-2 col-form-label">Carregar imagem</label>
		<div class="col-sm-8" style="padding-top: 8px;">
			<?php
			echo form_upload(array(
				'name' => 'userfile',
				'id' => 'userfile',
				'size' => '30',
				'maxlength' => '255',
				'tabindex' =>tab_index(),
				'value' => '',
			));
			?>
		<small class="form-text text-muted">Tamanho máximo do arquivo <strong><?php echo $max_size_human ?></strong>.</small>
		<small class="form-text text-muted">Carregar uma nova foto irá <strong>substituir</strong> a atual.</small>
		</div>
	</div>

	<?php
	if ($this->session->flashdata('image_error') != '' ) {
		$err = $this->session->flashdata('image_error');
		echo "<p class='hint error'><span>{$err}</span></p>";
	}
	?>

	<?php if (isset($room) && ! empty($room->photo)): ?>

		<div class="form-group row">
		<label class="col-sm-2 col-form-label"  for="photo_delete">Deletar logotipo?</label>
		<div class="col-sm-10" style="padding-top: 8px;">
			<?php
				echo form_hidden('photo_delete', '0');
				echo '<div class="custom-control custom-switch">';
				echo '<input name="photo_delete" type="checkbox" tabindex="'.tab_index().'" value = "1" class="custom-control-input" id="photo_delete">';
				?>
				<label class="custom-control-label" for="photo_delete" ></label>
				</div>
		<small class="form-text text-muted">Ative esta caixa para <strong>excluir</strong> o logotipo atual. Se você estiver enviando um novo logotipo, isso será feito automaticamente.</small>		
		</div>
	</div>

	

	<?php endif; ?>

</fieldset>


<?php if (isset($fields) && is_array($fields)): ?>

<fieldset>

	<legend accesskey="F" tabindex="<?php echo tab_index() ?>">Campos</legend>

	<?php

	foreach ($fields as $field) {

		echo '<div class="form-group row">';
		echo '<label class="col-sm-2 col-form-label">' . $field->name . '</label>';
		echo '<div class="col-sm-5" style="padding-top: 7px;">';

		switch ($field->type) {

			case Rooms_model::FIELD_TEXT:

				$input = "f{$field->field_id}";
				$value = set_value($input, element($field->field_id, $fieldvalues), FALSE);
				echo form_input(array(
					'name' => $input,
					'id' => $input,
					'size' => '30',
					'maxlength' => '255',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control',
				));

			break;


			case Rooms_model::FIELD_SELECT:

				$input = "f{$field->field_id}";
				$value = set_value($input, element($field->field_id, $fieldvalues), FALSE);
				$options = $field->options;
				$opts = array();
				foreach ($options as $option) {
					$opts[$option->option_id] = html_escape($option->value);
				}
				echo form_dropdown($input, $opts, $value, 'tabindex="'.tab_index().'"');

			break;


			case Rooms_model::FIELD_CHECKBOX:

				$input = "f{$field->field_id}";
				$value = set_checkbox($input, '1', element($field->field_id, $fieldvalues) == '1');
				echo form_hidden($input, '0');
				echo '<div class="custom-control custom-switch">';
				echo '<input name="'.$input.'" type="checkbox" tabindex="'.tab_index().'" value = "1" class="custom-control-input" id="'.$input.'" '.$value.'>';
				echo "<label for='{$input}' class='custom-control-label'></label></div>";

			break;

		}
		echo '</div>';
		echo '</div>';

	}

	?>

</fieldset>

<?php endif; ?>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'rooms'),
));

echo form_close();
