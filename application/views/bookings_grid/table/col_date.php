<?php
$classes = [
	'bookings-grid-header-cell',
	'bookings-grid-header-cell-day',
];

if ($date->date == $today->format('Y-m-d')) {
	$classes[] = 'bookings-grid-header-cell-is-today';
}

?>

<th class="<?= implode(' ', $classes) ?>" width="<?= $width ?>">
	<strong>
		<?php
		echo isset($day_names[$date->weekday])
			? $day_names[$date->weekday]
			: '';
		?>
	</strong>
	<?php

	$date_fmt = setting('date_format_weekday');

	if (strlen($date_fmt)) {
		$dt = datetime_from_string($date->date);
		$long_date = dateFormatter(setting('date_format_weekday'), $dt);

		echo "<br>";
		echo "<span style='font-size: 90%'>{$long_date}</span>";
	}
	?>
</th>