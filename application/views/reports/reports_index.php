<?php
echo $this->session->flashdata('saved');
?>

<h3>Total de Agendamentos no geral</h3>
<ul>
	<li>Número total de agendamentos realizados no sistema : <?php echo $total['all'] ?></li>
	<li>Número total de agendamentos atualmente ativos: <?php echo $total['allactive'] ?></li>
	<li>Número total de agendamentos realizados deste ano: <?php echo $total['allyeartodate'] ?></li>
</ul>