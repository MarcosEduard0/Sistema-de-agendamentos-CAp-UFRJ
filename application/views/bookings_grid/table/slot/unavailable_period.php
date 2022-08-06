<td class="<?= $class ?>">
	<a href="#" class="bookings-grid-button" up-layer="new popup" up-align="top" up-size="medium" up-class="booking-choices-holiday" up-content="<p><?= html_escape($slot->label) ?>
	</p><br><button up-dismiss type='button' class='btn btn-outline-info btn-sm'>Ok, entendi.</button>">
		<?php
		echo img([
			'role' => 'button',
			'src' => 'assets/images/ui/clock.png',
			'alt' => 'Period not available',
		]);
		?>
	</a>
</td>