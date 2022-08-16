<?php

if ($booking->user_id && $current_user->user_id != $booking->user_id) {
	echo msgbox('exclamation', 'Isso não é seu.');
	echo "<br>";
}

$cls = '';

$heading = '<strong>Editar agendamento recorrente:</strong><br><br>';

$cls = 'is-repeat';


$buttons = [];

$uri = sprintf('bookings/edit/%d?%s', $booking->booking_id, http_build_query(['params' => $params, 'edit' => '1']));
$buttons[] = form_button([
	'type' => 'button',
	'content' => 'Este agendamento apenas.',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
	'up-mode' => 'modal',
	'class' => 'btn btn-outline-info btn-sm',
]);

$uri = sprintf('bookings/edit/%d?%s', $booking->booking_id, http_build_query(['params' => $params, 'edit' => 'future']));
$buttons[] = form_button([
	'type' => 'button',
	'content' => 'Este e os demais agendamentos em sequência.',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
	'class' => 'btn btn-outline-info btn-sm',
]);

$uri = sprintf('bookings/edit/%d?%s', $booking->booking_id, http_build_query(['params' => $params, 'edit' => 'all']));
$buttons[] = form_button([
	'type' => 'button',
	'content' => 'Todos os agendamentos.',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
	'class' => 'btn btn-outline-info btn-sm',
]);

$cancel = "<a href='#' up-dismiss>Cancelar</a>";

$content = implode("\n", $buttons) . $cancel;

echo "<div class='booking-choices'>";
echo $heading;
echo "<div class='submit' style='border-top:0px;'>{$content}</div>";
echo "</div>";
