<table width="100%" cellpadding="4" cellspacing="2" border="0" class="border-table table-align-vat" up-data='<?= json_encode($sort_cols) ?>' id="<?= $id ?>">
	<col />
	<col />
	<col />
	<col />
	<thead>
		<tr class="heading">
			<td class="h" width="20%" title="Nome">Nome</td>
			<td class="h" width="10%" title="Recorrente?">Recorrente?</td>
			<td class="h" width="10%" title="Agendavel?">Agendavel?</td>
			<td class="h" width="25%" title="Data de Início">Data de Início</td>
			<td class="h" width="25%" title="Data de Fim">Data de Fim</td>
			<td class="h" width="10%" title="Ações"></td>
		</tr>
	</thead>

	<?php if (empty($items)) : ?>

		<tbody>
			<tr>
				<td colspan="6" align="center" style="padding:16px 0; color: #666">Sem sessões.</td>
			</tr>
		</tbody>

	<?php else : ?>

		<tbody>
			<?php

			$dateFormat = setting('date_format_long');
			$formatter = new IntlDateFormatter(
				'pt_BR',
				IntlDateFormatter::FULL,
				IntlDateFormatter::NONE,
				'America/Sao_Paulo',
				IntlDateFormatter::GREGORIAN
			);
			$formatter->setPattern($dateFormat);

			foreach ($items as $session) {

				echo "<tr>";

				$name = html_escape($session->name);
				$link = anchor("sessions/view/{$session->session_id}", $name);
				echo "<td>{$link}</td>";

				// Recorrente
				$img = '';
				if ($session->is_current == 1) {
					$img = img(['src' => 'assets/images/ui/enabled.png', 'width' => '16', 'height' => '16', 'alt' => 'Current session']);
				}
				echo "<td>{$img}</td>";

				// Agebdavel
				$img = '';
				if ($session->is_selectable == 1) {
					$img = img(['src' => 'assets/images/ui/enabled.png', 'width' => '16', 'height' => '16', 'alt' => 'Selectable']);
				}
				echo "<td>{$img}</td>";

				$start = $session->date_start ? $formatter->format($session->date_start) : '';
				// $start = $session->date_start ? $session->date_start->format($dateFormat) : '';
				echo "<td>{$start}</td>";

				$end = $session->date_end ? $formatter->format($session->date_end) : '';
				// $end = $session->date_end ? $session->date_end->format($dateFormat) : '';
				echo "<td>{$end}</td>";

				echo "<td>";
				$actions['edit'] = 'sessions/edit/' . $session->session_id;
				$actions['delete'] = 'sessions/delete/' . $session->session_id;
				$this->load->view('partials/editdelete', $actions);
				echo "</td>";

				echo "</tr>";
			}

			?>
		</tbody>

	<?php endif; ?>

</table>