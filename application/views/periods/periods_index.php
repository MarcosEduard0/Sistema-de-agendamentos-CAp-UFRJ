<?php

echo $this->session->flashdata('saved');

$iconbar = iconbar(array(
	array('periods/add', 'Novo Periodo', 'add.png'),
));

echo $iconbar;

?>

<table width="100%" cellpadding="2" cellspacing="2" border="0" class="sort-table" id="jsst-periods">
	<col /><col /><col /><col />
	<thead>
	<tr class="heading">
		<td class="h" title="N">&nbsp;</td>
		<td class="h" title="Nome">Nome</td>
		<td class="h" title="Início">Horário de início</td>
		<td class="h" title="Termino">Horário de termino</td>
		<td class="h" title="Duração">Duração</td>
		<td class="h" title="Dias">Dias da semana</td>
		<td class="n" title="X"></td>
	</tr>
	</thead>
	<tbody>
	<?php
	$i=0;
	if ($periods) {
	foreach ($periods as $period) {
		// Get UNIX timestamp of times to do calculations on
		$time_start = strtotime($period->time_start);
		$time_end = strtotime($period->time_end);
	?>
	<tr class="tr<?php echo ($i & 1) ?>">
		<?php
		// $now = timestamp to do calculations with for "current" period
		$now = now();
		// $dayofweek = numeric day of week (1=monday) to get "current" period for periods on this day of the week
		$dayofweek = date('N', $now);
		$key = "day_{$dayofweek}";

		if ( ($now >= $time_start) && ($now < $time_end) && ($period->{$key} == '1') ) {
			$now_img = img('assets/images/ui/clock.png', 'width="16" height="16" alt="Now"');
		} else {
			$now_img = '';
		}
		?>
		<td width="20" align="center"><?php echo $now_img ?></td>
		<td><?php echo html_escape($period->name) ?></td>
		<td><?php echo strftime('%H:%M', $time_start) ?></td>
		<td><?php echo strftime('%H:%M', $time_end) ?></td>
		<td><?php echo timespan($time_start, $time_end) ?></td>
		<td><?php
		
		foreach ($days_list as $day_num => $day_name) {
			$day_name = preg_split("/(?<!^)(?!$)/u", $day_name);//correção para caracteres multibytes
			$key = "day_{$day_num}";
			$letter = "{$day_name[0]}{$day_name[1]}";
			if ($period->{$key} == '1') {
				echo "$letter ";
			} else {		
				echo "<span style='color:#ccc'>{$letter}</span> ";
			}
		}
		?></td>
		<td width="45" class="n"><?php
			$actions['edit'] = 'periods/edit/'.$period->period_id;
			$actions['delete'] = 'periods/delete/'.$period->period_id;
			$this->load->view('partials/editdelete', $actions);
			?>
		</td>
	</tr>
	<?php $i++; }
	} else {
		echo '<td colspan="7" align="center" style="padding:16px 0">No periods exist!</td>';
	}
	?>
	</tbody>
</table>

<?php

echo $iconbar;

$jsst['name'] = 'st1';
$jsst['id'] = 'jsst-periods';
$jsst['cols'] = array("None", "Nome", "Início", "Término", "Duração", "Dias", "None");
$this->load->view('partials/js-sorttable', $jsst);
