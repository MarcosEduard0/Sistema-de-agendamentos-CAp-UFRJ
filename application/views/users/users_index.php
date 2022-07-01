<?php

echo $this->session->flashdata('saved');

$iconbar = iconbar(array(
	array('users/add', 'Novo usuário', 'add.png'),
	array('users/import', 'Importar Usuários', 'user_import.png'),
));

echo $iconbar;

$sort_cols = ["Tipo", "Habilitado", "Usuário", "Nome", "Última Conexão", "Ações"];

?>

<table id="jsst-users" class="table table-striped table-bordered" style="width:100%">
	<thead>
		<tr class="heading">
			<td class="" title="Tipo">Tipo</td>
			<td class="" title="Habilitado">Habilitado</td>
			<td class="" title="Usuário">Usuário</td>
			<td class="" title="Nome">Nome</td>
			<td class="" title="Última Conexão">Última Conexão</td>
			<td class="" title="X"></td>
		</tr>
	</thead>
	<tbody>
		<?php
		$i = 0;
		if ($users) {
			foreach ($users as $user) { ?>
				<tr>
					<?php
					$img_type = ($user->authlevel == ADMINISTRADOR ? 'user_administrator.png' : 'user_teacher.png');
					$data_type_tooltip = ($user->authlevel == ADMINISTRADOR ? 'Administrador' : 'Usuário');
					$data_type_text = ($user->authlevel == ADMINISTRADOR ? 'A' : 'U');
					$img_enabled = ($user->enabled == 1) ? 'enabled.png' : 'no.png';
					$data_enabled_tooltip = ($user->enabled == 1) ? 'Sim' : 'Não';
					$data_enabled_text = ($user->enabled == 1) ? 'S' : 'N';


					?>
					<td width="40" align="center"><img src="<?= base_url("assets/images/ui/{$img_type}") ?>" width="16" height="16" up-tooltip="<?php echo $data_type_tooltip ?>" style="position: absolute;" alt="<?php echo $data_type_tooltip ?>"><small style="visibility: collapse;"><?php echo $data_type_text ?></small></img></td>

					<td width="50" align="center"><img src="<?= base_url("assets/images/ui/{$img_enabled}") ?>" width="16" height="16" up-tooltip="<?php echo $data_enabled_tooltip ?>" style="position: absolute;" alt="<?php echo $data_enabled_tooltip ?>"><small style="visibility: collapse;"><?php echo $data_enabled_text ?></small></img></td>

					<td><?php echo html_escape($user->username) ?></td>
					<td><?php
						if ($user->displayname == '') {
							$user->displayname = $user->username;
						}
						echo html_escape($user->displayname);
						?>
					</td>
					<td>
						<?php
						if ($user->lastlogin == '0000-00-00 00:00:00' || empty($user->lastlogin)) {
							$lastlogin = 'Nunca';
						} else {
							$lastlogin = utf8_encode(strftime("%d/%m/%Y, %H:%M", strtotime($user->lastlogin)));
						}
						echo $lastlogin;
						?>
					</td>
					<td width="45" class="n"><?php
												$actions['edit'] = 'users/edit/' . $user->user_id;
												$actions['delete'] = 'users/delete/' . $user->user_id;
												$this->load->view('partials/editdelete', $actions);
												?>
					</td>
				</tr>
		<?php $i++;
			}
		} ?>
	</tbody>
	<!-- <tfoot>
		<tr class="">
		<td class="" title="Tipo">Tipo</td>
		<td class="" title="Habilitado">Habilitado</td>
		<td class="" title="Usuário">Usuário</td>
		<td class="" title="Nome">Nome</td>
		<td class="" title="Última Conexão">Última Conexão</td>
		<td class="" title="X"></td>
	</tr>
        </tfoot>  -->
</table>
<?php

echo $pagelinks;

echo $iconbar;
