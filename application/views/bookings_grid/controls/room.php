<?php
echo form_open($form_action, ['method' => 'get', 'id' => 'bookings_controls_room'], $query_params);
?>

<table>
	<tr>
		<td valign="middle">
			<label>
				<?php
				$url = "rooms/info/{$room->room_id}";
				$name = 'Sala:';
				$link = anchor($url, $name, [
					'up-layer' => 'new drawer',
					'up-position' => 'left',
					'up-target' => '.room-info',
					'up-preload',
				]);
				echo "<strong>{$link}</strong>";
				?>
			</label>
		</td>
		<td valign="middle">
			<?php
			echo form_dropdown([
				'name' => 'room',
				'id' => 'room_id',
				'options' => $rooms,
				'selected' => $room->room_id,
				'class' => 'form-control',
			]);
			?>
		</td>
		<td> &nbsp; <button type="submit" class="btn btn-primary">Carregar</button></td>
	</tr>
</table>

<?= form_close() ?>

<br />