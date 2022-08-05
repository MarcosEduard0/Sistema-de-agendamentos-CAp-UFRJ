<?php

function import_status($key)
{

	$labels = array(
		'username_empty' => 'Usuário vazio',
		'password_empty' => 'Nenhuma senha definida',
		'username_exists' => 'Usuário existe',
		'Success' => 'Sucesso',
		'db_error' => 'Erro',
		'invalid' => 'Falha na validação',
	);

	if (array_key_exists($key, $labels)) {
		return $labels[$key];
	}

	return 'Unknown';
}

?>

<?php if (is_array($result)) : ?>

	<table cellpadding="2" cellspacing="2" width="100%">

		<thead>
			<tr class="heading">
				<td class="h">Linha</td>
				<td class="h">Usuário</td>
				<td class="h">Criado</td>
				<td class="h">Status</td>
			</tr>
		</thead>

		<tbody class="has-border">

			<?php
			foreach ($result as $row) {

				//$colour = ($row->status == 'Success') ? 'darkgreen' : 'darkred';
				$colour = ($row->status == 'Success') ? 'label label-success' : 'label label-danger';

				echo '<tr>';
				echo "<td>#{$row->line}</td>";
				//echo '<td>' . html_escape($row->user->username) . '</td>';
				echo '<td style="width: 50%">' . html_escape($row->user->username) . '</td>';
				echo '<td>' . ($row->status == 'Success' ? 'Sim' : 'Não') . '</td>';
				//echo "<td style='font-weight:bold;color:{$colour}'>" . import_status($row->status) . "</td>";
				echo "<td><span class='{$colour}'>" . import_status($row->status) . "</span>";
				echo '</tr>';
			}
			?>
		</tbody>

	</table>

<?php endif; ?>

<?php

$iconbar = iconbar(array(
	array('users', 'Todos Usuários', 'school_manage_users.png'),
	array('users/import', 'Importar Mais Usuários', 'user_import.png'),
));

echo $iconbar;
