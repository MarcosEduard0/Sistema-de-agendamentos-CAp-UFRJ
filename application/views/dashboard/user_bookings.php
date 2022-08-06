<?php
$date_format = setting('date_format_long');
$time_format = setting('time_format_period');
$formatter = new IntlDateFormatter(
	'pt_BR',
	IntlDateFormatter::FULL,
	IntlDateFormatter::NONE,
	'America/Sao_Paulo',
	IntlDateFormatter::GREGORIAN
);
?>

<?php if ($user_bookings) : ?>

	<div class="block b-50">

		<div class="box">

			<h3 style="margin: 0 0 16px 0">Agendamentos Ativos</h3>
			<ul class="dash-booking-list">

				<?php
				$formatter->setPattern($date_format);

				foreach ($user_bookings as $booking) {
					$date_str = $booking->date->format("d/m/Y");
					// $time_str = $booking->date->format("H:i");
					$period_name = html_escape($booking->period->name);
					$room_name = html_escape($booking->room->name);
					$time_str = (new \DateTime($booking->period->time_start))->format("H:i");
					$time = "<span class='dash-booking-time'>({$time_str})</span>";

					$title_html = "<div class='dash-booking-title'>{$date_str}</div>";
					$room_url = "rooms/info/{$booking->room->room_id}";
					$room_link = anchor($room_url, $room_name, [
						'up-layer' => 'new drawer',
						'up-position' => 'left',
						'up-target' => '.room-info',
						'up-preload',
					]);
					$room_html = "<div class='dash-booking-subtitle'>{$period_name} {$time} &middot; {$room_link}</div>";

					$notes_html = strlen($booking->notes)
						? '<span class="dash-booking-notes">' . html_escape($booking->notes) . '</span>'
						: '';

					echo "<li>{$title_html}{$room_html}{$notes_html}</li>";
				}
				?>
			</ul>

		</div>

	</div>

<?php endif; ?>