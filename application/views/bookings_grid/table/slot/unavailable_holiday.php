<td class="<?= $class ?>">
	<a href="#" class="bookings-grid-button" up-layer="new popup" up-align="bottom" up-size="medium" up-class="booking-choices-holiday" up-content="<p><?= html_escape($slot->label) ?>
	<br><button up-dismiss type='button' class='btn btn-outline-info btn-sm'>Ok, entendi.</button>">
		<?php
		echo img([
			'role' => 'button',
			'src' => 'assets/images/ui/school_manage_holidays.png',
			'alt' => 'Holiday',
		]);
		?>
	</a>
</td>