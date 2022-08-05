<?php

echo $this->session->flashdata('saved');

echo '<h2>Configurações da escola</h2>';
dotable($school_menu);

echo '<h2>Administração</h2>';
dotable($manage_menu);


function dotable($array)
{

	echo '<table width="100%" cellpadding="0" cellspacing="0" border="0">';
	echo '<tbody>';
	$row = 0;

	foreach ($array as $link) {
		if ($row == 0) {
			echo '<tr>';
		}
		echo '<td width="33%" style="padding: 10px 0 10px 0;">';
		echo '<a href="' . $link['url'] . '">';
		echo '<section align="center">';
		echo img('assets/images/ui/' . $link['img'], FALSE, 'style="max-width: 70px;"');
		echo	'<h3 class="home" style="margin-top: 5px;">' . $link['label'] . '</h3>';
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
