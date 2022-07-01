<?php
echo $this->session->flashdata('saved');

echo iconbar(array(
	array('profile/edit', 'Editar minhas informações', 'user_edit.png'),
));

?>

<?php if ($myroom) { ?>
	<h3>Agendamentos nas minhas salas:</h3>
	<ul>
		<?php
		foreach ($myroom as $booking) {
			$string = '<li>A sala %s está agendado para o dia %s por %s para o %s. %s</li>';
			if ($booking->notes) {
				$booking->notes = '(' . $booking->notes . ')';
			}
			if (!$booking->displayname) {
				$booking->displayname = $booking->username;
			}
			echo sprintf($string, html_escape($booking->name), date("d/m/Y", strtotime($booking->date)), html_escape($booking->displayname), html_escape($booking->periodname), html_escape($booking->notes));
		}
		?>
	</ul>
<?php } ?>



<?php if ($mybookings) { ?>
	<h3>Meus Agendamentos:</h3>
	<ul>
		<?php
		foreach ($mybookings as $booking) {
			$string = '<li>A sala %s está agendado para o dia %s no %s.</li>';
			$notes = '';
			if ($booking->notes) {
				$notes = '(' . $booking->notes . ')';
			}
			echo sprintf($string, html_escape($booking->name), date("d/m/Y", strtotime($booking->date)), html_escape($booking->periodname), html_escape($notes));
		}
		?>
	</ul>
<?php } ?>


<h3>Total de Agendamentos:</h3>
<ul>
	<li>Número de agendamentos já realizadas: <?php echo $total['singleuser'] ?></li>
	<li>Número de agendamentos do começo do ano até agora: <?php echo $total['yeartodate'] ?></li>
	<li>Número de agendamentos atualmente ativos: <?php echo $total['active'] ?></li>
</ul>