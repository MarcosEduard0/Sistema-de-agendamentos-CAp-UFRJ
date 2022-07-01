<?php

$roomlist = array();

foreach ($rooms as $room) {
	$roomlist[$room->room_id] = html_escape($room->name);
}

?>

<?= form_open('bookings/load', [], ['chosen_date' => $chosen_date]) ?>

<table>
	<tr>
		<td valign="middle">
			<label for="room_id">
				<?php
				$url = site_url("rooms/info/{$room_id}");
				$name = 'Salas:';
				$link = "<a href='{$url}' up-position='left' up-drawer='.room-info' up-history='false' up-preload>{$name}</a>";
				echo "<strong>{$link}</strong>";
				?>
			</label>
		</td>

		<td valign="middle">
			<div style="padding:0 5px 0 5px;">
				<?php
				echo form_dropdown(
					'room_id',
					$roomlist,
					$room_id,
					'onchange="this.form.submit()" onmouseup="this.form.submit" class="form-control"',
				);

				?>
			</div>
			<!-- Possivel agendamentod e equipamentos -->
			<!-- <select name="room_id" onchange="this.form.submit()" onmouseup="this.form.submit" class="form-control" >

			<?php foreach ($rooms as $room) : ?>

				<?php if ($room->type_id == 20) : ?>
					<optgroup  label="Equipamentos">
						<option  <?php if ($room_id == $room->room_id) {
										echo 'selected="selected"';
									} ?>  value="<?php echo $room->room_id ?>" ><?php echo $room->name ?> </option>	
					</optgroup>
				<?php endif ?>
				
				<?php if ($room->type_id == 10) : ?>
					<optgroup  label="Salas">
						<option  <?php if ($room_id == $room->room_id) {
										echo 'selected="selected"';
									} ?>  value="<?php echo $room->room_id ?>" ><?php echo $room->name ?> </option>	
					</optgroup>
				<?php endif ?>
			<?php endforeach; ?>


			</select> -->
		</td>


		<td><button type="submit" class="btn btn-primary">Carregar</button></td>

		<!-- <td valign="middle" style="padding: 0 0 0 180px;">
			<label for="room_id" align-content= "right">
				<?php
				$url = site_url("rooms/info/{$room_id}");
				$name = 'Clique aqui para mais informações sobre a sala.';
				$link = "<a href='{$url}' up-position='left' up-drawer='.room-info' up-history='false' up-preload>{$name}</a>";
				echo "<strong style='text-align:right'>{$link}</strong>";
				?>
			</label>
		</td> -->
	</tr>
</table>


<?= form_close() ?>


<br />