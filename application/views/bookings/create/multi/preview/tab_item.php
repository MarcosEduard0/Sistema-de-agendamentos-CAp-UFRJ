<?php

use app\components\Calendar;

$day_name = Calendar::get_day_name($slot->datetime->format('N'));
$day_name = Calendar::traslate_2_portuguese($day_name);

$period = $slot->period->name;

if ($slot->conflict_count === 0) {
	$icon_name = 'tick.png';
	$title = 'Sem conflitos';
} else {
	$icon_name = 'i_error2.png';
	$title = sprintf('%d %s', $slot->conflict_count, ($slot->conflict_count === 1 ? 'conflito' : 'conflitos'));
}

$img = img([
	'src' => base_url('assets/images/ui/' . $icon_name),
	'alt' => $title,
	'title' => $title,
	'style' => 'display:inline-block;margin-top:4px;',
]);


echo "<div style='float:right;text-align:right'><div>{$period}</div>{$img}</div>";

echo "<div><strong>{$day_name}</strong></div>";

$room = $slot->room->name;
echo "<div style='margin-top:4px;'>{$room}</div>";
