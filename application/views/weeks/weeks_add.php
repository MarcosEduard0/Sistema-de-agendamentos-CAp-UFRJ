<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
// date_default_timezone_set('America/Sao_Paulo');

$week_id = NULL;
if (isset($week) && is_object($week)) {
	$week_id = set_value('week_id', $week->week_id);
}

echo form_open('weeks/save', array('class' => 'needs-validation', 'id' => 'week_add', 'novalidate' => 'true'), array('week_id' => $week_id));

?>


<fieldset>

	<legend accesskey="W" tabindex="<?= tab_index() ?>">Informações da Semana</legend>

	<div class="form-group row">
		<label for="name" class="col-sm-2 col-form-label">Nome</label>
		<div class="col-sm-4">
			<?php
			$field = 'name';
			$value = set_value($field, isset($week) ? $week->name : '', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '20',
				'maxlength' => '20',
				'tabindex' => tab_index(),
				'value' => $value,
				'class' => 'form-control',
				'required' => '',
			));
			?>
			<div class="invalid-feedback">Por favor, digite um nome.</div>
		</div>
	</div>
	<?php echo form_error($field) ?>

	<div class="form-group row">
		<label for="bgcol" class="col-sm-2 col-form-label">Cor de fundo</label>
		<div class="col-sm-1">
			<?php
			$field = 'bgcol';
			$value = set_value($field, isset($week) ? $week->bgcol : '00008B', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '7',
				'maxlength' => '7',
				'tabindex' => tab_index(),
				'value' => '#' . $value,
				'onchange' => '$(\'sample\').style.backgroundColor = this.value;',
				'class' => 'form-control-color',
				'type' => 'color'
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

	<div class="form-group row">
		<label for="fgcol" class="col-sm-2 col-form-label">Cor do texto</label>
		<div class="col-sm-1">
			<?php
			$field = 'fgcol';
			$value = set_value($field, isset($week) ? $week->fgcol : 'FFFFFF', FALSE);
			echo form_input(array(
				'name' => $field,
				'id' => $field,
				'size' => '7',
				'maxlength' => '7',
				'tabindex' => tab_index(),
				'value' => '#' . $value,
				'onchange' => '$(\'sample\').style.color = this.value;',
				'class' => 'form-control-color',
				'type' => 'color'
			));
			?>
		</div>
	</div>
	<?php echo form_error($field); ?>

</fieldset>


<fieldset>

	<legend accesskey="D" tabindex="6">Datas da semana</legend>

	<div>Selecione as datas de início da semana (segunda-feira) dentro do ano letivo atual ao qual esta semana se aplica.</div>

	<?php

	echo '<table width="100%" cellpadding="0" cellspacing="10">';
	echo '<tbody>';
	$weekscount = ($weekscount == 0 ? 1 : $weekscount);

	$checked = 0;
	foreach ($mondays as $monday) {
		$value = isset($week) ? $week->week_id : NULL;
		if (isset($monday['week_id']) && ($monday['week_id'] == $value && !empty($value))) {
			$checked += 1;
		}
	}

	if (count($mondays) == $checked) {
		$checked = 'checked="checked"';
	}

	echo '<td style="padding:4px;" width="' . round(100 / $weekscount) . '%">';
	echo '<input type="checkbox" class="check" id="checkAll" ' . $checked . '> Selecionar tudo';
	echo '</label>';
	echo '</td>';

	$row = 0;

	if ($weeks) {
		foreach ($weeks as $oneweek) {
			$weekdata[$oneweek->week_id]['fgcol'] = $oneweek->fgcol;
			$weekdata[$oneweek->week_id]['bgcol'] = $oneweek->bgcol;
		}
	}

	foreach ($mondays as $monday) {
		$checked = '';
		if (isset($monday['holiday']) && $monday['holiday'] == true) {
			$checkbox_disabled = '';	//' disabled="disabled" ';
			$cell_style = 'border:1px solid #888;';
		} else {
			$checkbox_disabled = '';
			$cell_style = '';
		}
		$fgcol = '#000';
		if (isset($monday['week_id']) && $monday['week_id'] != NULL) {
			$cell_style = "background:#{$weekdata[$monday['week_id']]['bgcol']};";
			$fgcol = '#' . $weekdata[$monday['week_id']]['fgcol'];
		}

		if ($row == 0) {
			echo '<tr>';
		}

		$value = isset($week) ? $week->week_id : NULL;
		if (isset($monday['week_id']) && ($monday['week_id'] == $value && !empty($value))) {
			$checked = 'checked="checked"';
		} else {
			$checked = '';
		}

		echo '<td style="' . $cell_style . 'padding:4px;" width="' . round(100 / $weekscount) . '%">';
		$input = '<input type="checkbox" class="check" name="dates[]" value="' . $monday['date'] . '" id="' . $monday['date'] . '" ' . $checkbox_disabled . ' ' . $checked . ' /> ';
		echo '<label class="week" for="' . $monday['date'] . '" style="color:' . $fgcol . '">';
		echo $input;
		echo utf8_encode(strftime("%d %b %Y", strtotime($monday['date'])));
		echo '</label>';
		echo '</td>';
		echo "\n";
		if ($row == $weekscount - 1) {
			echo "</tr>\n\n";
			$row = -1;
		}
		$row++;
	}

	echo '</tbody>';
	echo '</table>';

	?>

</fieldset>


<?php

$this->load->view('partials/submit', array(
	'submit' => array('Salvar', tab_index()),
	'cancel' => array('Voltar', tab_index(), 'weeks'),
));

echo form_close();
