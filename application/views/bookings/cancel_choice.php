<?php

if ($booking->user_id && $current_user->user_id != $booking->user_id) {
	echo msgbox('exclamation', 'Isso não é seu.');
	echo "<br>";
}


$cls = '';

if ($booking->repeat_id) {

	$heading = '<strong>Cancelar agendamento recorrente:</strong><br><br>';

	$cls = 'is-repeat';

	$buttons = [];

	$buttons[] = form_button([
		'type' => 'submit',
		'name' => 'cancel',
		'value' => '1',
		'content' => 'Apenas este agendamento',
	]);

	$buttons[] = form_button([
		'type' => 'submit',
		'name' => 'cancel',
		'value' => 'future',
		'content' => 'Este e futuros agendamentos em série',
	]);

	$buttons[] = form_button([
		'type' => 'submit',
		'name' => 'cancel',
		'value' => 'all',
		'content' => 'Todos os agendamentos em série',
	]);

	$cancel = "<a href='#' up-dismiss>No, keep it</a>";

	$content = implode("\n", $buttons) . $cancel;
} else {

	$heading = '<strong>Cancelar este agendamento?</strong><br><br>';

	$submit = form_button([
		'type' => 'submit',
		'name' => 'cancel',
		'value' => '1',
		'content' => 'Sim, cancelar agendamentos',
		'autofocus' => true,
	]);

	$cancel = "<a href='#' up-dismiss>Não, mantenha-o</a>";

	$content = "{$submit} &nbsp; {$cancel}";
}


$uri = sprintf('bookings/cancel/%d?%s', $booking->booking_id, http_build_query(['params' => $params]));
echo form_open($uri, ['class' => 'booking-choices']);
echo $heading;
echo "<div class='submit' style='border-top:0px;'>{$content}</div>";
echo form_close();
