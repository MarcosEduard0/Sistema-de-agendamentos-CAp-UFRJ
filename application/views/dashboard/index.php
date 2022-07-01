<?php
echo $this->session->flashdata('saved');


// Menu para todos os usuários
$i = 0;
$menu[$i]['text'] = 'Agendamentos';
$menu[$i]['icon'] = 'fa fa-book';
$menu[$i]['href'] = site_url('bookings');
$menu[$i]['img'] = 'bookings.png';


$i++;
$menu[$i]['text'] = 'Perfil';
$menu[$i]['icon'] = ($this->userauth->is_level(ADMINISTRADOR)) ? 'fa fa-user-circle' : 'fa fa-user-circle-o';
$menu[$i]['href'] = site_url('profile/edit');
$menu[$i]['img'] = 'profile.png';

// $i++;
// $menu[$i]['text'] = 'Solicitações';
// $menu[$i]['icon'] = 'blank.png';
// $menu[$i]['href'] = '';
// $menu[$i]['img'] = 'request.png';

$i++;
$menu[$i]['text'] = '';
$menu[$i]['icon'] = 'blank.png';
$menu[$i]['href'] = '';
$menu[$i]['img'] = 'blank.png';




// Itens de menu para administradores

$i = 0;
$school[$i]['text'] = 'Detalhes da Escola';
$school[$i]['icon'] = 'fa fa-graduation-cap';
$school[$i]['href'] = site_url('school');
$school[$i]['img'] = 'school.png';

$i++;
$school[$i]['text'] = 'Horário das aulas';
$school[$i]['icon'] = 'fa fa-clock-o';
$school[$i]['href'] = site_url('periods');
$school[$i]['img'] = 'periods.png';

$i++;
$school[$i]['text'] = 'Calendário Escolar';
$school[$i]['icon'] = 'fa fa-calendar-o';
$school[$i]['href'] = site_url('weeks');
$school[$i]['img'] = 'schedule.png';


$i++;
$school[$i]['text'] = 'Feriados';
$school[$i]['icon'] = 'fa fa-bicycle';
$school[$i]['href'] = site_url('holidays');
$school[$i]['img'] = 'holiday.png';

$i++;
$school[$i]['text'] = 'Salas';
$school[$i]['icon'] = 'fa fa-building';
$school[$i]['href'] = site_url('rooms');
$school[$i]['img'] = 'rooms.png';

$i++;
$school[$i]['text'] = 'Departamentos';
$school[$i]['icon'] = 'fa fa-university';
$school[$i]['href'] = site_url('departments');
$school[$i]['img'] = 'departments.png';


$i = 0;


$i++;
$admin[$i]['text'] = 'Usuários';
$admin[$i]['icon'] = 'fa fa-users';
$admin[$i]['href'] = site_url('users');
$admin[$i]['img'] = 'users.png';


$i++;
$admin[$i]['text'] = 'Configurações';
$admin[$i]['icon'] = 'fa fa-cogs';
$admin[$i]['href'] = site_url('settings');
$admin[$i]['img'] = 'settings.png';

$i++;
$admin[$i]['text'] = 'Relatórios (Em Breve)';
$admin[$i]['icon'] = 'fa fa-archive';
$admin[$i]['href'] = site_url('reports');
$admin[$i]['img'] = 'reports.png';

/*
$i++;
$admin[$i]['text'] = 'Autenricação(beta)';
$admin[$i]['icon'] = 'lock.png';
$admin[$i]['href'] = site_url('settings/authentication/ldap');
*/


// Comece o menu do administrador
$i = 0;


// Menu normal
if ($this->userauth->is_level(PROFESSOR)) {
	echo '<h2>Início</h2>';
	dotable($menu);
}
// Verifique se o usuário é administrador
if ($this->userauth->is_level(ADMINISTRADOR)) {
	echo '<h2>Configurações da escola</h2>';
	dotable($school);
	echo '<h2>Administração</h2>';
	dotable($admin);
}

function dotable($array)
{

	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tbody>';
	$row = 0;

	foreach ($array as $link) {
		if ($row == 0) {
			echo '<tr>';
		}
		echo '<td width="33%">';

		echo '<a href="' . $link['href'] . '">';
		echo '<section align="center">';
		// echo '<span class="pennant"><span class="'.$link['icon'].'"></span></span>';
		echo img('assets/images/ui/' . $link['img'], FALSE, 'style="max-width: 70px;"');
		echo	'<h3 class="home" style="margin-top: 5px;">' . $link['text'] . '</h3>';
		echo '</section>';
		echo '</a>';


		echo '</td>';
		echo "\n";
		if ($row == 2) {
			echo '</tr>' . "\n\n";
			$row = -1;
		}
		$row++;
	}

	echo '</tbody>';
	echo '</table>' . "\n\n";
}
$userMensage = 'hideModal';
if (setting('login_message_enabled')) {
	$mensage = html_escape(setting('login_message_text'));
	$userMensage = 'showModal';
}
?>
<?php if ($this->userauth->is_level(PROFESSOR)) : ?>
	<div style="margin-top:24px">
		<div class="stat-item">
			<dl>
				<dd>Total de Agendamentos realizados</dd>
				<dt>
					<?php echo $total['singleuser'] ?>
				</dt>
			</dl>
		</div>
		<div class="stat-item">
			<dl>
				<dd>Total de agendamentos ativos</dd>
				<dt><?php echo $total['active'] ?></dt>
			</dl>
		</div>
		<div class="stat-item">
			<dl>
				<dd>Total de agendamentos realizado este ano</dd>
				<dt><?php echo $total['yeartodate'] ?></dt>
			</dl>
		</div>
	</div>
<?php endif; ?>

<div class="modal fade" id="<?php echo $userMensage; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-dialog-centered">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Mensagem do sistema</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<?php echo $mensage; ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
			</div>
		</div>
	</div>
</div>