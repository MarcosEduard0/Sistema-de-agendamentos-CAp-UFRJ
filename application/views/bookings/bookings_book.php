<div style="float:left;width:70%" class="column">
	<div class="c" id="c1">
		<?php
		$booking_id = NULL;
		if (isset($booking) && is_object($booking)) {
			$booking_id = set_value('booking_id', $booking->booking_id);
		}

		echo isset($notice) ? $notice : '';

		echo $this->session->flashdata('saved');

		echo form_open('bookings/save?' . http_build_query($this->input->get()), array('id' => 'bookings_book', 'class' => 'needs-validation', 'novalidate' => 'true'), $hidden);

		// Produza o valor da data no formato Y / m / d - pois este é o formato esperado da parte de processamento do formulário
		if (isset($booking) && !empty($booking->date)) {
			echo form_hidden('date', date('Y-m-d', strtotime($booking->date)));
		}

		?>

		<fieldset>
			<legend accesskey="I" tabindex="<?php echo tab_index() ?>">Informações do Agendamento</legend>
			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Descrição:</label>
				<div class="col-sm-auto">
					<?php
					$field = 'notes';
					$value = set_value($field, isset($booking) ? $booking->notes : '', FALSE);
					echo form_textarea(array(
						'name' => $field,
						'id' => $field,
						'size' => '50',
						'maxlength' => '100',
						'class' => 'form-control',
						'tabindex' => tab_index(),
						'value' => $value,
					));
					?>
				</div>
			</div>
			<?php echo form_error($field); ?>

			<div class="form-group row">
				<label class="col-sm-2 col-form-label">Data:</label>
				<div class="col-sm-auto">
					<?php
					$field = 'date';
					$default = '';
					if (!empty($booking->date)) {
						$default = date('Y-m-d', strtotime($booking->date));
					}
					$value = set_value($field, isset($booking) ? $default : '', FALSE);
					$disabled = 'disabled';
					if ($this->userauth->is_level(ADMINISTRATOR))
						$disabled = '';

					echo form_input(array(
						'name' => $field,
						'id' => $field,
						'size' => '10',
						'maxlength' => '10',
						'class' => 'form-control',
						'tabindex' => tab_index(),
						'value' => $value,
						'type' => 'date',
						$disabled => '',
					));
					?>
				</div>
			</div>
			<?php echo form_error($field); ?>

			<div class="form-group row">
				<label for="period_id" class="col-sm-2 col-form-label">Periodo:</label>
				<div class="col-sm-auto">
					<?php
					$time_fmt = setting('time_format_period');
					$period_options = array();
					foreach ($periods as $period) {
						$label = sprintf(
							"%s (%s - %s)",
							$period->name,
							strftime($time_fmt, strtotime($period->time_start)),
							strftime($time_fmt, strtotime($period->time_end))
						);
						$period_options[$period->period_id] = html_escape($label);
					}
					$field = 'period_id';
					$value = set_value($field, isset($booking) ? $booking->period_id : '', FALSE);
					$disabled = 'disabled';
					if ($this->userauth->is_level(ADMINISTRATOR))
						$disabled = '';
					echo form_dropdown('period_id', $period_options, $value, 'tabindex="' . tab_index() . '"class="form-control"' . $disabled);
					?>
				</div>
			</div>
			<?php echo form_error($field) ?>

			<div class="form-group row">
				<label for="room_id" class="col-sm-2 col-form-label">Sala:</label>
				<div class="col-sm-auto">
					<?php
					$room_options = array();
					foreach ($rooms as $room) {
						$room_options[$room->room_id] = html_escape($room->name);
					}
					$field = 'room_id';
					$value = set_value($field, isset($booking) ? $booking->room_id : '', FALSE);
					echo form_dropdown('room_id', $room_options, $value, 'tabindex="' . tab_index() . '" class="form-control"');
					?>
				</div>
			</div>
			<?php echo form_error($field) ?>


			<?php if ($this->userauth->is_level(ADMINISTRATOR)) : ?>
				<div class="form-group row">
					<label for="department_id" class="col-sm-2 col-form-label">Departamento:</label>
					<div class="col-sm-4">
						<div class="input-group">
							<?php
							$department_options = array('' => '(Nenhuma)');
							foreach ($departments as $department) {
								$department_options[$department->department_id] = html_escape($department->name);
							}
							if (isset($booking)) {
								if (!isset($booking->booking_id))
									$value = $this->userauth->user->department_id;
								else
									$value = $booking->department_id;
							} else $value = '';
							$field = 'department_id';
							$value = set_value($field, $value, FALSE);
							echo form_dropdown('department_id', $department_options, $value, 'tabindex="' . tab_index() . '" class="form-control" ');
							?>
							<div class="invalid-feedback">
								<div class="row">
									<div class="col-sm-12" style="font-size: 11px;">Departamento é obrigatório.</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php echo form_error($field) ?>

				<div class="form-group row">
					<label for="user_id" class="col-sm-2 col-form-label">Usuário:</label>
					<div class="col-sm-auto">
						<?php
						$user_options = array('' => '(Nenhum)');
						foreach ($users as $user) {
							$label = ($user->displayname ? $user->displayname : $user->username);
							$user_options[$user->user_id] = html_escape($label);
						}
						$field = 'user_id';
						$value = set_value($field, isset($booking) ? $booking->user_id : $this->userauth->user->user_id, FALSE);
						echo form_dropdown('user_id', $user_options, $value, 'id="user_id" tabindex="' . tab_index() . '"class="form-control"');
						?>
					</div>
				</div>
				<?php echo form_error($field) ?>

			<?php endif; ?>

		</fieldset>

		<?php if ($this->userauth->is_level(ADMINISTRATOR)) : ?>

			<fieldset>

				<legend accesskey="R" tabindex="<?php echo tab_index() ?>">Opções de recorrencia</legend>

				<div class="form-group row">
					<label class="col-sm-2 col-form-label" for="recurring">Recorrente?</label>
					<div class="col-sm-auto">
						<?php
						$field = 'recurring';
						$value = ($booking->week_id == NULL && $booking->day_num == NULL || $booking_id == NULL) ? '0' : '1';
						echo form_hidden($field, '0');
						echo form_checkbox(array(
							'name' => $field,
							'id' => $field,
							'value' => '1',
							'tabindex' => tab_index(),
							'checked' => $value,
							'up-switch' => '.recurring_fields',
						));
						?>
					</div>
				</div>
				<?php echo form_error($field) ?>

				<div class="recurring_fields" up-show-for=":checked">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" for="week_id">Seamana:</label>
						<div class="col-sm-auto">
							<?php
							$week_options = array('' => '(Nenhuma)');
							foreach ($weeks as $week) {
								$week_options[$week->week_id] = html_escape($week->name);
							}
							$field = 'week_id';
							$value = set_value($field, isset($booking) ? $booking->week_id : '', FALSE);
							echo form_dropdown('week_id', $week_options, $value, 'id="week_id" tabindex="' . tab_index() . '"class="form-control"');
							?>
						</div>
					</div>
				</div>
				<?php echo form_error($field) ?>

				<div class="recurring_fields" up-show-for=":checked">
					<div class="form-group row">
						<label class="col-sm-2 col-form-label" for="day_num">Dia:</label>
						<div class="col-sm-auto">
							<?php
							$day_options = array('' => '(Nenhum)');
							$day_options += $days;
							$field = 'day_num';
							$value = set_value($field, isset($booking) ? $booking->day_num : '', FALSE);
							echo form_dropdown('day_num', $day_options, $value, 'id="day_num" tabindex="' . tab_index() . '"class="form-control"');
							?>
						</div>
					</div>
				</div>
				<?php echo form_error($field) ?>

			</fieldset>

		<?php endif; ?>



		<?php
		$save_label = empty($booking_id) ? 'Agendar' : 'Salvar';
		$this->load->view('partials/submit', array(
			'submit' => array($save_label, tab_index()),
			'cancel' => array('Cancelar', tab_index(), $cancel_uri),
		));

		echo form_close();
		?>
	</div>
</div>

<div style="float:right;width:30%" class="column">
	<div class="c" id="c2">
		<div class="bd-callout bd-callout-info">
			<h6>Sugestão de descrição</h6>
			<dd>Informe a atividade que será realizada ou qualquer outra informação que seja relevante ao agendamento.
			</dd>
		</div>

	</div>
</div>