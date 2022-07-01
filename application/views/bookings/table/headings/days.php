<td align="center" width="<?php echo $width ?>">
	<?php
	$class = '';
	if ($date == $today) {
		$class = 'bookings-grid-header-cell-is-today';
	}
	echo '<strong class="' . $class . '">' . html_escape($name) . '</strong>';

	$date_fmt = setting('date_format_weekday');
	if (strlen($date_fmt)) {
		echo "<br>";
		echo sprintf("<span class='" . $class . "' style='font-size:90%%'>%s</span>", utf8_encode(strftime($date_fmt, strtotime($date))));
	}
	?>
</td>