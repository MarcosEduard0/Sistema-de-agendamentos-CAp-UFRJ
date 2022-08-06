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
	'content' => 'Este agendamento apenas',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
	'up-mode' => 'modal',
]);

$uri = sprintf('bookings/edit/%d?%s', $booking->booking_id, http_build_query(['params' => $params, 'edit' => 'future']));
$buttons[] = form_button([
	'type' => 'button',
	'content' => 'Este e futuros agendamentos em série',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
]);

$uri = sprintf('bookings/edit/%d?%s', $booking->booking_id, http_build_query(['params' => $params, 'edit' => 'all']));
$buttons[] = form_button([
	'type' => 'button',
	'content' => 'Todos os agendamentos em série.',
	'up-href' => site_url($uri),
	'up-target' => '.bookings-edit',
	'up-layer' => 'new modal',
]);

$cancel = "<a href='#' up-dismiss>Cancelar</a>";

$content = implode("\n", $buttons) . $cancel;

echo "<div class='booking-choices'>";
echo $heading;
echo "<div class='submit' style='border-top:0px;'>{$content}</div>";
echo "</div>";
