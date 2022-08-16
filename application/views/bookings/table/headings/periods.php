<td align="center" width="<?php echo $width ?>">
	<strong><?php echo html_escape($name) ?></strong><br />
	<span style="font-size:90%">
		<?php echo utf8_encode(strftime('%H:%M', strtotime($time_start))) . '-' . utf8_encode(strftime('%H:%M', strtotime($time_end))); ?>
	</span>
</td>