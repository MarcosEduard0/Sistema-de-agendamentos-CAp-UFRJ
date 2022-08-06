<?php

use app\components\bookings\agent\UpdateAgent;


// Form
//
$attrs = [
	'id' => 'bookings_edit',
	'class' => 'cssform',
	'up-layer' => 'current root',
	'up-target' => '.bookings-edit',
];

$hidden = [
	'booking_id' => $booking->booking_id,
	'edit' => $edit_mode,
];

if ($message) {
	echo msgbox('error', $message);
}

echo validation_errors();

echo form_open(current_url(), $attrs, $hidden);

if ($booking->repeat_id) {

	$msg = '';

	switch ($edit_mode) {
		case UpdateAgent::EDIT_ONE:
			$msg = 'As alterações que você fizer abaixo serão aplicadas apenas ao agendamento selecionado.';
			break;
		case UpdateAgent::EDIT_FUTURE:
			$msg = 'As alterações feitas abaixo serão aplicadas ao agendamento selecionado e a todas as entradas futuras da série.';
			break;
		case UpdateAgent::EDIT_ALL:
			$msg = 'As alterações feitas abaixo serão aplicadas a todos os agendamentos da série.';
			break;
	}

	echo "<div style='margin-bottom:16px'>{$msg}</div>";
}

echo "<fieldset style='border:0'>";

$datetime = datetime_from_string($booking->date);

// Date
//
$field = 'booking_date';
$label = form_label('Data', $field);
if ($features[UpdateAgent::FEATURE_DATE]) {
	$input = form_input(array(
		'class' => 'up-datepicker-input',
		'name' => $field,
		'id' => $field,
		'size' => '10',
		'maxlength' => '10',
		'tabindex' => tab_index(),
		'value' => set_value($field, $datetime ? $datetime->format('d/m/Y') : '', FALSE),
		'class' => 'form-control',
	));
	$input .= img([
		'style' => 'cursor:pointer',
		'align' => 'top',
		'src' => base_url('assets/images/ui/cal_day.png'),
		'width' => 16,
		'height' => 16,
		'title' => 'Choose date',
		'class' => 'up-datepicker',
		'up-data' => html_escape(json_encode(['input' => $field])),
	]);
} else {
	$input = sprintf('%s (%s)', $datetime->format('d/m/Y'), html_escape($booking->week->name));
	if ($edit_mode != UpdateAgent::EDIT_ONE) {
		$input .= ' (+ others)';
	}
}
echo "<p>{$label}{$input}</p>";


// Period
//
$field = 'period_id';
$label = form_label('Período', $field);

$time_fmt = setting('time_format_period');

if ($features[UpdateAgent::FEATURE_PERIOD]) {
	$options = results_to_assoc($all_periods, 'period_id', function ($period) use ($time_fmt) {
		$start = date($time_fmt, strtotime($period->time_start));
		$end = date($time_fmt, strtotime($period->time_end));
		return sprintf('%s (%s - %s)', $period->name, $start, $end);
	});
	$value = set_value($field, $booking->period_id, FALSE);
	$input = form_dropdown([
		'name' => $field,
		'id' => $field,
		'options' => $options,
		'selected' => $value,
		'class' => 'form-control',
	]);
} else {
	$input = html_escape($booking->period->name);
	if (strlen($time_fmt)) {
		$start = date($time_fmt, strtotime($booking->period->time_start));
		$end = date($time_fmt, strtotime($booking->period->time_end));
		$input .= sprintf(' <span style="font-size:90%%;color:#aaa;background:transparent">(%s - %s)</span>', $start, $end);
	}
}
echo "<p>{$label}{$input}</p>";


// Room
//
$field = 'room_id';
$label = form_label('Sala', $field);
if ($features[UpdateAgent::FEATURE_ROOM]) {
	$options = results_to_assoc($all_rooms, 'room_id', 'name');
	$value = set_value($field, $booking->room_id, FALSE);
	$input = form_dropdown([
		'name' => $field,
		'id' => $field,
		'options' => $options,
		'selected' => $value,
		'class' => 'form-control',
	]);
} else {
	$input = html_escape($booking->room->name);
}
echo "<p>{$label}{$input}</p>";


// Department
//
$field = 'department_id';
$label = form_label('Departamento', $field);
$show_department = FALSE;
if ($features[UpdateAgent::FEATURE_DEPARTMENT]) {
	$show_department = TRUE;
	$options = results_to_assoc($all_departments, 'department_id', 'name', '(None)');
	$value = set_value($field, $booking->department_id, FALSE);
	$input = form_dropdown([
		'name' => $field,
		'id' => $field,
		'options' => $options,
		'selected' => $value,
		'class' => 'form-control',
	]);
} else {
	if ($booking->department_id) {
		$show_department = TRUE;
		$input = html_escape($booking->department->name);
	}
}
echo ($show_department)
	? "<p>{$label}{$input}</p>"
	: '';

// Who
//
$field = 'user_id';
$label = form_label('Usuário', $field);
if ($is_admin) {
	$options = results_to_assoc($all_users, 'user_id', function ($user) {
		return strlen($user->displayname)
			? $user->displayname
			: $user->username;
	}, '(Nenhum)');
	$value = set_value($field, $booking->user_id, FALSE);
	$input = form_dropdown([
		'name' => $field,
		'id' => $field,
		'options' => $options,
		'selected' => $value,
		'class' => 'form-control',
	]);
} else {
	$input = strlen($booking->user->displayname)
		? $booking->user->displayname
		: $booking->user->username;
}
echo "<p>{$label}{$input}</p>";


// Notes
//
$field = 'notes';
$value = set_value($field, $booking->notes, FALSE);
$label = form_label('Descrição', 'notes');
if ($features[UpdateAgent::FEATURE_NOTES]) {
	$input = form_textarea([
		'name' => $field,
		'id' => $field,
		'rows' => '3',
		'cols' => '50',
		'tabindex' => tab_index(),
		'value' => $value,
		'class' => 'form-control',
	]);
} else {
	$input = '<span>' . html_escape($booking->notes) . '</span>';
}
echo sprintf("<p>%s%s</p>%s", $label, $input, form_error($field));



echo "</fieldset>";

// Actions
//
$submit = form_button([
	'type' => 'submit',
	'name' => 'action',
	'value' => 'update',
	'content' => 'Atualizar',
	'class' => "btn btn-primary btn-sm",
]);

$cancel = anchor($return_uri, 'Cancel', ['up-dismiss' => '']);

echo "<div class='submit' style='border-top:0px;'>{$submit} &nbsp; {$cancel}</div>";


// End
echo form_close();
