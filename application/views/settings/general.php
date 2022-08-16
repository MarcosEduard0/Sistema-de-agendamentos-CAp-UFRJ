<?php
echo $this->session->flashdata('saved');
echo form_open(current_url(), array('id' => 'settings', 'class' => 'needs-validation', 'novalidate' => 'true'));
?>


<fieldset>

	<legend accesskey="S" tabindex="<?php echo tab_index() ?>">Agendamentos</legend>
	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="validity">Validade das Contas</label>
		<div class="col-sm-10">
			<?php
			$value = (int) set_value('validity', element('validity', $settings), FALSE);
			echo form_input(array(
				'name' => 'validity',
				'id' => 'validity',
				'size' => '5',
				'maxlength' => '3',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'style' => 'width: 8%; text-align: center;',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, preencha este campo.</div>
			<small class="form-text text-muted">Quantidade de meses para uma conta de usuário ser desativada. Insira <strong>0</strong> para nunca.</small>
		</div>
	</div>
	<?php echo form_error('bia') ?>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="bia">Agendamento com antecedência</label>
		<div class="col-sm-10">
			<?php
			$value = (int) set_value('bia', element('bia', $settings), FALSE);
			echo form_input(array(
				'name' => 'bia',
				'id' => 'bia',
				'size' => '5',
				'maxlength' => '3',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'style' => 'width: 8%; text-align: center;',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, preencha este campo.</div>
			<small class="form-text text-muted">Quantos dias no futuro os usuários podem fazer seus próprios agendamentos. Insira <strong>0</strong> para nenhuma restrição.</small>
		</div>
	</div>
	<?php echo form_error('bia') ?>

	<div class="form-group row">
		<label class="col-sm-2 col-form-label" for="num_max_bookings">Máximo de agend. ativos</label>
		<div class="col-sm-10">
			<?php
			$value = (int) set_value('num_max_bookings', element('num_max_bookings', $settings), FALSE);
			echo form_input(array(
				'name' => 'num_max_bookings',
				'id' => 'num_max_bookings',
				'size' => '5',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'style' => 'width: 8%; text-align: center;',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, preencha este campo.</div>
			<small class="form-text text-muted">Número máximo de agendamentos únicos ativos para um usuário. Insira <strong>0</strong> para ilimitado.</small>
			<small class="form-text text-muted">'Ativo' é qualquer agendamento único para uma data e hora que ainda irá acontecer.</small>
		</div>
	</div>
	<?php echo form_error('num_max_bookings') ?>

	<hr size="1" />

	<div class="form-group row" id="settings_displaytype">
		<label for="displaytype" class="col-sm-2 col-form-label">Tipo de Exibição</label>
		<div class="col-sm-8">
			<div class="col-sm-4" style="padding: 8px 0 0 0;">
				<?php

				$field = "displaytype";
				$value = set_value($field, element($field, $settings), FALSE);

				$options = [
					['value' => 'day', 'label' => 'Um dia de cada vez', 'enable' => 'd_columns_rooms'],
					['value' => 'room', 'label' => 'Uma sala de cada vez', 'enable' => 'd_columns_days'],
				];

				foreach ($options as $opt) {
					$id = "{$field}_{$opt['value']}";
					$input = form_radio(array(
						'name' => $field,
						'id' => $id,
						'value' => $opt['value'],
						'checked' => ($value == $opt['value']),
						'tabindex' => tab_index(),
						'up-switch' => '.d_columns_target',
					));
					echo "<label for='{$id}' class='ni'>{$input}{$opt['label']}</label>";
				}

				?>
			</div>
			<small class="form-text text-muted">Especifique o foco principal da página de agendamentos.<br />
				<strong><strong>Um dia de cada vez</strong></strong> - todos os períodos e salas são mostrados para a data selecionada.<br />
				<strong><strong>Uma sala de cada vez</strong></strong> - todos os períodos e dias da semana são mostrados para a sala selecionada.
			</small>
		</div>
	</div>
	<?php echo form_error('displaytype'); ?>

	<div class="form-group row" id="settings_columns">
		<label for="columns" class="col-sm-2 col-form-label">Colunas</label>
		<div class="col-sm-8">
			<div class="col-sm-2" style="padding: 8px 0 0 0;">
				<?php

				$field = 'd_columns';
				$value = set_value($field, element($field, $settings), FALSE);

				$options = [
					['value' => 'periods', 'label' => 'Periodos', 'for' => ''],
					['value' => 'rooms', 'label' => 'Salas', 'for' => 'day'],
					['value' => 'days', 'label' => 'Dias', 'for' => 'room'],
				];

				foreach ($options as $opt) {
					$id = "{$field}_{$opt['value']}";
					$input = form_radio(array(
						'name' => $field,
						'id' => $id,
						'value' => $opt['value'],
						'checked' => ($value == $opt['value']),
						'tabindex' => tab_index(),
					));
					echo "<label for='{$id}' class='d_columns_target ni' up-show-for='{$opt['for']}'>{$input}{$opt['label']}</label>";
				}
				?>
			</div>
			<small class="form-text text-muted">Selecione quais detalhes você deseja exibir na parte superior da página de agendamentos.</small>
		</div>
	</div>
	<?php echo form_error('d_columns') ?>

	<hr size="1" />

	<div class="form-group row">
		<label for="<?= $field ?>" class="col-sm-2 col-form-label">Detalhes do usuário</label>
		<div class="col-sm-8">
			<div class="col-sm-6" style="padding: 8px 0 0 0;">
				<?php

				$field = 'bookings_show_user_recurring';
				$value = set_value($field, element($field, $settings, '0'), FALSE);
				echo form_hidden($field, '0');
				$input = form_checkbox(array(
					'name' => $field,
					'id' => $field,
					'value' => '1',
					'tabindex' => tab_index(),
					'checked' => ($value == '1')
				));
				echo "<label for='{$field}' class='ni'>{$input} Mostrar usuários de agendamentos recorrentes</label>";

				$field = 'bookings_show_user_single';
				$value = set_value($field, element($field, $settings, '0'), FALSE);
				echo form_hidden($field, '0');
				$input = form_checkbox(array(
					'name' => $field,
					'id' => $field,
					'value' => '1',
					'tabindex' => tab_index(),
					'checked' => ($value == '1')
				));
				echo "<label for='{$field}' class='ni'>{$input} Mostrar usuários de agendamentos únicas</label>";
				?>
			</div>
			<small class="form-text text-muted">Esta configuração controla a visibilidade do nome do usuário de um agendamento na página agendamentos.</small>
			<small class="form-text text-muted">Os detalhes do usuário são sempre exibidos aos ADMINISTRATORes e nos agendamentos do próprio usuário.</small>
		</div>
	</div>

</fieldset>


<fieldset>

	<legend accesskey="D" tabindex="<?php echo tab_index() ?>">Formatos de data</legend>

	<div style="padding: 0 0 20px 10px;">
		As datas seguem o formato PHP - <a href="https://unicode-org.github.io/icu/userguide/format_parse/datetime/" target="_blank">ver documentação</a>.
	</div>

	<div class="form-group row">
		<label for="timezone" class="col-sm-2 col-form-label">Fuso horário</label>
		<div class="col-sm-3">
			<div class="col-sm-3" style="padding: 8px 0 0 0;">
				<?php
				$value = set_value('timezone', element('timezone', $settings, date_default_timezone_get()), FALSE);
				$input = form_dropdown([
					'name' => 'timezone',
					'id' => 'timezone',
					'options' => $timezones,
					'selected' => $value,
					'class' => 'form-control',
					'tabindex' => tab_index(),
				]);
				echo $input;
				?>
			</div>
		</div>
	</div>

	<div class="form-group row">
		<label for="date_format_long" class="col-sm-2 col-form-label">Formato de datas longas</label>
		<div class="col-sm-8">
			<div class="col-sm-6" style="padding: 8px 0 0 0;">
				<?php
				$value = set_value('date_format_long', element('date_format_long', $settings), FALSE);
				echo form_input(array(
					'name' => 'date_format_long',
					'id' => 'date_format_long',
					'size' => '20',
					'maxlength' => '20',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control',
					'style' => 'width: 70%; text-align: center;',
				));
				?>
			</div>
			<small class="form-text text-muted">Formato de data longo exibido na parte superior da página de agendamento.</small>
		</div>
	</div>
	<?php echo form_error('date_format_long') ?>

	<div class="form-group row">
		<label for="date_format_weekday" class="col-sm-2 col-form-label">Formato de dia da semana</label>
		<div class="col-sm-8">
			<div class="col-sm-6" style="padding: 8px 0 0 0;">
				<?php
				$value = set_value('date_format_weekday', element('date_format_weekday', $settings), FALSE);
				echo form_input(array(
					'name' => 'date_format_weekday',
					'id' => 'date_format_weekday',
					'size' => '15',
					'maxlength' => '10',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control',
					'style' => 'width: auto;',
					'style' => 'width: 40%; text-align: center;',
				));
				?>
			</div>
			<small class="form-text text-muted">Formato de data abreviada para um dia da semana específico.</small>
		</div>
	</div>
	<?php echo form_error('date_format_weekday') ?>

	<div class="form-group row">
		<label for="time_format_period" class="col-sm-2 col-form-label">Formato de período</label>
		<div class="col-sm-8">
			<div class="col-sm-6" style="padding: 8px 0 0 0;">
				<?php
				$value = set_value('time_format_period', element('time_format_period', $settings), FALSE);
				echo form_input(array(
					'name' => 'time_format_period',
					'id' => 'time_format_period',
					'size' => '15',
					'maxlength' => '10',
					'tabindex' => tab_index(),
					'value' => $value,
					'class' => 'form-control',
					'style' => 'width: auto; text-align: center;',
				));
				?>
				<small class="form-text text-muted">Formato de hora para períodos.</small>
			</div>
		</div>
		<?php echo form_error('time_format_period') ?>


</fieldset>


<fieldset>

	<legend accesskey="L" tabindex="<?php echo tab_index() ?>">Mensagem de Login</legend>

	<div style="padding: 0 0 20px 10px;">Exibir uma mensagem personalizada para os usuários na página de login.</div>

	<?php
	$value = set_value('login_message_enabled', element('login_message_enabled', $settings, '0'), FALSE);
	?>
	<div class="form-group row">
		<label for="login_message_enabled" class="col-sm-2 col-form-label">Habilitar</label>
		<div class="col-sm-8" style="padding-top: 8px">
			<?php
			$checked = '';
			$value = set_value('login_message_enabled', element('login_message_enabled', $settings, '0'), FALSE);
			echo form_hidden('login_message_enabled', '0');
			echo '<div class="custom-control custom-switch">';
			if ($value == 1) {
				$checked = 'checked';
			}
			echo '<input name="login_message_enabled" type="checkbox" tabindex="' . tab_index() . '" value = "1" class="custom-control-input" id="login_message_enabled" ' . $checked . '>';
			?>
			<label class="custom-control-label" for="login_message_enabled"></label>
		</div>
	</div>
	</div>


	<?php
	$field = 'login_message_text';
	$value = set_value($field, element($field, $settings, ''), FALSE);
	?>
	<div class="form-group row">
		<label for="<?= $field ?>" class="col-sm-2 col-form-label">Mensagem</label>
		<div class="col-sm-8">
			<?php
			echo form_textarea(array(
				'name' => $field,
				'id' => $field,
				'rows' => '5',
				'cols' => '60',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'style' => 'width: auto;',
			));
			?>
			<small class="form-text text-muted">Esta é a mensagem que será quando o usuário entrar no sitema.</small>
		</div>
	</div>
	<?php echo form_error($field) ?>

</fieldset>

<fieldset>

	<legend accesskey="M" tabindex="<?php echo tab_index() ?>">Modo de Manutenção</legend>

	<div style="padding: 0 0 20px 10px;">A ativação do Modo de manutenção impede que as contas de usuário do Professor visualizem e façam agendamentos. Todos os usuários ainda podem fazer login para fazer alterações em suas próprias contas ou alterar suas senhas.</div>

	<div class="form-group row">
		<label for="maintenance_mode" class="col-sm-2 col-form-label">Habilitar</label>

		<div class="col-sm-8" style="padding-top: 8px">
			<?php
			$checked = '';
			$value = set_value('maintenance_mode', element('maintenance_mode', $settings, '0'), FALSE);
			echo form_hidden('maintenance_mode', '0');
			echo '<div class="custom-control custom-switch">';
			if ($value == 1) {
				$checked = 'checked';
			}
			echo '<input name="maintenance_mode" type="checkbox" tabindex="' . tab_index() . '" value = "1" class="custom-control-input" id="maintenance_mode" ' . $checked . '>';
			?>
			<label class="custom-control-label" for="maintenance_mode"></label>
		</div>
	</div>
	</div>


	<div class="form-group row">
		<label for="maintenance_mode_message" class="col-sm-2 col-form-label">Mensagem</label>
		<div class="col-sm-8">
			<?php
			$field = 'maintenance_mode_message';
			$value = set_value($field, element($field, $settings, ''), FALSE);
			echo form_textarea(array(
				'name' => $field,
				'id' => $field,
				'rows' => '5',
				'cols' => '60',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'style' => 'width: auto;',
			));
			?>
			<small class="form-text text-muted">Esta é a mensagem que será exibida durante o modo de manutenção.</small>
		</div>
	</div>
	<?php echo form_error($field) ?>

</fieldset>



<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'controlpanel'),
));

echo form_close();
