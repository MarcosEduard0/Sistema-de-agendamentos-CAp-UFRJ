<?php
echo form_open($form_action, ['method' => 'get', 'id' => 'bookings_controls_day'], $query_params);
?>

<table>
	<tr>
		<td valign="middle"><label for="chosen_date"><strong>Date:</strong></label></td>
		<td valign="middle">
			<?php
			echo form_input(array(
				'class' => 'form-control',
				'name' => 'date',
				'id' => 'date',
				'size' => '10',
				'maxlength' => '10',
				'tabindex' => tab_index(),
				'type' => 'date',
				'value' => $datetime ? $datetime->format('Y-m-d') : $this->input->get('date'),
			));
			?>
		</td>

		<td> &nbsp; <button type="submit" class="btn btn-primary">Carregar</button></td>
	</tr>
</table>

<?= form_close() ?>

<br />