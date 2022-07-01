<?php
echo $this->session->flashdata('saved');


// Menu para todos os usuários
$i = 0;
$menu[$i]['text'] = 'Agendamentos';
$menu[$i]['icon'] = 'school_manage_bookings.png';
$menu[$i]['href'] = site_url('bookings');

$i++;
$menu[$i]['text'] = 'Meu Perfil';
$menu[$i]['icon'] = ($this->userauth->is_level(ADMINISTRATOR)) ? 'user_administrator.png' : 'user_teacher.png';
$menu[$i]['href'] = site_url('profile');

$i++;
$menu[$i]['text'] = '';
$menu[$i]['icon'] = 'blank.png';
$menu[$i]['href'] = '';




// Itens de menu para administradores

$i = 0;
$school[$i]['text'] = 'Detalhes da Escola';
$school[$i]['icon'] = 'school_manage_details.png';
$school[$i]['href'] = site_url('school');

$i++;
$school[$i]['text'] = 'Horário das aulas';
$school[$i]['icon'] = 'school_manage_times.png';
$school[$i]['href'] = site_url('periods');

$i++;
$school[$i]['text'] = 'Calendário Escolar';
$school[$i]['icon'] = 'school_manage_weeks.png';
$school[$i]['href'] = site_url('weeks');

$i++;
$school[$i]['text'] = 'Feriados';
$school[$i]['icon'] = 'school_manage_holidays.png';
$school[$i]['href'] = site_url('holidays');

$i++;
$school[$i]['text'] = 'Salas';
$school[$i]['icon'] = 'school_manage_rooms.png';
$school[$i]['href'] = site_url('rooms');

$i++;
$school[$i]['text'] = 'Departamentos';
$school[$i]['icon'] = 'school_manage_departments.png';
$school[$i]['href'] = site_url('departments');


$i = 0;


$i++;
$admin[$i]['text'] = 'Usuários';
$admin[$i]['icon'] = 'school_manage_users.png';
$admin[$i]['href'] = site_url('users');


$i++;
$admin[$i]['text'] = 'Configurações';
$admin[$i]['icon'] = 'school_manage_settings.png';
$admin[$i]['href'] = site_url('settings');


$i++;
$admin[$i]['text'] = 'Relatórios (Em Breve)';
$admin[$i]['icon'] = 'school_manage_reports.png';
$admin[$i]['href'] = site_url('reports');

/*
$i++;
$admin[$i]['text'] = 'Autenricação(beta)';
$admin[$i]['icon'] = 'lock.png';
$admin[$i]['href'] = site_url('settings/authentication/ldap');
*/


// Comece o menu do administrador
$i = 0;


// Menu normal
dotable($menu);



// Verifique se o usuário é administrador
if ($this->userauth->is_level(ADMINISTRATOR)) {
	echo '<h2>Configurações da escola</h2>';
	dotable($school);
	echo '<h2>Administração</h2>';
	dotable($admin);
}




function dotable($array){

	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tbody>';
	$row = 0;

	foreach($array as $link){
		if($row == 0){ echo '<tr>'; }
		echo '<td width="33%">';
		echo '<h5 style="margin:14px 0px">';
		echo '<a href="'.$link['href'].'">';
		echo '<img src="' . base_url('assets/images/ui/'.$link['icon']) . '" alt="'.$link['text'].'" hspace="4" align="top" width="16" height="16" />';
		echo $link['text'];
		echo '</a>';
		echo '</h5>';
		echo '</td>';
		echo "\n";
		if($row == 2){ echo '</tr>'."\n\n"; $row = -1; }
		$row++;
	}

	echo '</tbody>';
	echo '</table>'."\n\n";
}
?>
