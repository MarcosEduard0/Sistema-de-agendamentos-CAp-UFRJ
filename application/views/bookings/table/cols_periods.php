<td align="center" width="<?php echo $width ?>">
	<strong><?php echo html_escape($name) ?></strong><br />
	<span style="font-size:90%">
		<?php
		$time_fmt = setting('time_format_period');
		// $time_fmt = 'd/m';
		if (strlen($time_fmt)) {
			$start = strftime($time_fmt, strtotime($time_start));
			$end = strftime($time_fmt, strtotime($time_end));
			echo sprintf('%s - %s', $start, $end);
		}
		?>
	</span>
</td>