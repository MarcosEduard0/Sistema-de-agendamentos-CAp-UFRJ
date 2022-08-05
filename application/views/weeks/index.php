<?php

echo $this->session->flashdata('saved');

$iconbar = iconbar(array(
	array('weeks/add', 'Nova Semana', 'add.png'),
));

echo $iconbar;

$sort_cols = ["Name", "Colour", "None"];

?>

<table width="100%" cellpadding="2" cellspacing="2" border="0" class="zebra-table sort-table" id="jsst-weeks" up-data='<?= json_encode($sort_cols) ?>'>
	<col />
	<col />
	<col />
	<thead>
		<tr class="heading">
			<td class="h" title="Colour"></td>
			<td class="h" title="Name">Nome</td>
			<td class="n" title="X">&nbsp;</td>
		</tr>
	</thead>

	<?php if (empty($weeks)) : ?>

		<tbody>
			<tr>
				<td colspan="2" align="center" style="padding:16px 0; color: #666">Nenhuma semana definida!</td>
			</tr>
		</tbody>

	<?php else : ?>
		<tbody>
			<?php
			foreach ($weeks as $week) {
			?>
				<tr>
					<td width="6%" style="text-align:center">
						<?php
						$field = 'bgcol';
						$value = set_value($field, isset($week) ? $week->bgcol : '00008B', FALSE);
						echo '<span class="dot dot-week dot-size-md" style="background-color:' . $value . '"></span>';
						?>
					</td>
					<td><?php echo html_escape($week->name) ?></td>
					<td width="45" class="n">
						<?php
						$actions['edit'] = 'weeks/edit/' . $week->week_id;
						$actions['delete'] = 'weeks/delete/' . $week->week_id;
						$this->load->view('partials/editdelete', $actions);
						?>
					</td>
				</tr>
			<?php
			} ?>
		</tbody>
	<?php endif; ?>
</table>

<?php

echo $iconbar;
