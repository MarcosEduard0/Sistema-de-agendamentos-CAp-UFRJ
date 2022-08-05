<?php

echo $this->session->flashdata('saved');

echo '<h2>Início</h2>';

$i = 0;
$menu[$i]['text'] = 'Agendamentos';
$menu[$i]['href'] = site_url('bookings');
$menu[$i]['img'] = 'bookings.png';


$i++;
$menu[$i]['text'] = 'Perfil';
$menu[$i]['href'] = site_url('profile/edit');
$menu[$i]['img'] = 'profile.png';

echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
echo '<tbody>';
$row = 0;

foreach ($menu as $link) {
	if ($row == 0) {
		echo '<tr>';
	}
	echo '<td width="33%">';
	echo '<a href="' . $link['href'] . '">';
	echo '<section align="center">';
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

$this->load->view('dashboard/stats');

?>

<div class="block-group has-spacing">

	<?php $this->load->view('dashboard/user_bookings') ?>
	<?php $this->load->view('dashboard/room_bookings') ?>

</div>