<?php
$messages = $this->session->flashdata('saved');
echo "<div class='messages'>{$messages}</div>";


echo iconbar([
	['sessions/add', 'Adicionar Sessão', 'add.png'],
]);


$sort_cols = ["Nome", "Data de início", "Data de fim", "Recorrente?", "Agendavel?"];

echo "<h3>Sessões atuais e futuras</h3>";
$this->load->view('sessions/table', ['items' => $active, 'id' => 'sessions_active', 'sort_cols' => $sort_cols]);

if (!empty($past)) {
	echo "<br><br><h3>Sessões anteriores</h3>";
	$this->load->view('sessions/table', ['items' => $past, 'id' => 'sessions_past', 'sort_cols' => $sort_cols]);
}
