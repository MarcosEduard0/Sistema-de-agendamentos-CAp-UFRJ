<?php
setlocale(LC_ALL, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
// date_default_timezone_set('America/Sao_Paulo');

class Bookings_model extends CI_Model
{


	var $table_headings = '';
	var $table_rows = array();

	private $all_periods;
	private $periods_by_day_num;


	public function __construct()
	{
		parent::__construct();

		$this->load->model(array(
			'departments_model',
		));
	}




	function Get($booking_id)
	{
		$this->db->from('bookings');
		$this->db->where('booking_id', $booking_id);

		$query = $this->db->get();
		if ($query->num_rows() == 1) {
			return $query->row();
		} else {
			return FALSE;
		}
	}




	function GetByDate($date = NULL)
	{
		if ($date == NULL) {
			$date = date("Y-m-d");
		}

		$day_num = date('N', strtotime($date));
		$query_str = "SELECT * FROM bookings WHERE (`date`='$date' OR day_num=$day_num)";
		$query = $this->db->query($query_str);
		$result = $query->result_array();
		return $result;
	}


	function GetUnique($params = array())
	{
		$defaults = array(
			'booking_id' => NULL,
			'date' => NULL,
			'period_id' => 0,
			'room_id' => 0,
			'week_id' => 0,
			'day_num' => NULL,
		);

		$data = array_merge($defaults, $params);

		if (empty($data['week_id'])) {
			$week = $this->WeekObj(strtotime($data['date']));
			$week_id = ($week ? $week->week_id : 0);
		} else {
			$week_id = $data['week_id'];
		}

		if (!strlen($data['day_num'])) {
			$day_num = date('N', strtotime($data['date']));
		} else {
			$day_num = $data['day_num'];
		}

		$sql = "SELECT *
				FROM bookings
				WHERE period_id = ?
				AND room_id = ?";

		if (!empty($data['date'])) {
			$date_escaped = $this->db->escape($data['date']);
			$sql .= " AND (`date` = {$date_escaped} OR (day_num = {$day_num} AND week_id = {$week_id}))";
		} else {
			$sql .= " AND (day_num = {$day_num} AND week_id = {$week_id}) ";
		}

		if (!empty($data['booking_id'])) {
			$sql .= " AND booking_id != " . $this->db->escape($data['booking_id']);
		}

		$query = $this->db->query($sql, array(
			$data['period_id'],
			$data['room_id'],
		));

		return $query->result_array();
	}




	function TableAddColumn($td)
	{
		$this->table_headings .= $td;
	}




	function TableAddRow($data)
	{
		$this->table_rows[] = $data;
	}




	function Table()
	{
		$table = '<tr>' . $this->table_headings . '</tr>';
		/* foreach($this->table_rows as $row){
			$table .= '<tr>' . $row . '</tr>';
		} */
		return $table;
	}


	public function populate_periods()
	{
		$this->all_periods = $this->periods_model->GetBookable();

		foreach ($this->all_periods as $period) {
			foreach ($this->periods_model->days as $num => $name) {
				$field = "day_{$num}";
				if ($period->$field == 1) {
					$this->periods_by_day_num["{$num}"][] = $period;
				}
			}
		}
	}




	function BookingCell($data, $key, $rooms, $users, $room_id, $url, $booking_date_ymd = '', $holidays = array())
	{
		// Verifique se há agendamento
		if (isset($data[$key])) {
			//Variavel de controle para criar o model de cancelamento caso haja agendamento
			$cell['bookingModel'] = true;
			// Há um agendamento para este ID, definir variavel
			$booking = $data[$key];

			// Obtenha o ID do usuário atual
			$user_id = $this->userauth->user->user_id;

			if ($booking->date == NULL) {
				// Se nenhuma data for definida, então é um agendamento estática / cronograma / recorrente
				$cell['class'] = 'static';
				$cell['body'] = '';
				$cell['booking_id'] = '';
				$display_user_setting = setting('bookings_show_user_recurring');
			} else {
				// A data está definida, é um agendamento de equipe única
				$cell['class'] = 'staff';
				$cell['body'] = '';
				$cell['booking_id'] = '';
				$display_user_setting = setting('bookings_show_user_single');
			}

			$template = "{user}{department}{notes}{actions}";
			$vars = [
				'{user}' => '',
				'{department}' => '',
				'{notes}' => '',
				'{actions}' => '',
			];

			$actions = [];

			// Informação de usuário

			$user_is_admin = $this->userauth->is_level(ADMINISTRADOR);
			$user_is_booking_owner = ($booking->user_id && $booking->user_id == $user_id);

			$show_user = ($user_is_admin || $user_is_booking_owner || $display_user_setting);
			if (isset($users[$booking->user_id]) && $show_user) {
				$username = $users[$booking->user_id]->firstname;
				$displayname = trim($users[$booking->user_id]->displayname);
				if (strlen($displayname) < 2) {
					$displayname = $username;
				}
				$vars['{user}'] = '<div class="booking-cell-user">' . html_escape($displayname) . '</div>';
			}

			// Departamento
			$department = $this->departments_model->Get($booking->department_id);
			if ($department) {
				$vars['{department}'] .= '<div class="booking-cell-department">' . $department->name . '</div>';
			}


			// Descrição
			if ($booking->notes) {
				$notes = html_escape($booking->notes);
				$tooltip = '';
				if (strlen($notes) > 15) {
					$tooltip = 'up-tooltip="' . $notes . '"';
				}
				$vars['{notes}'] .= '<div class="booking-cell-notes"' . $tooltip . '>' . character_limiter($notes, 15) . '</div>';
			}

			// Editar se for ADM?
			//
			if ($this->userauth->is_level(ADMINISTRADOR)) {
				$edit_url = site_url('bookings/edit/' . $booking->booking_id);
				$actions[] = "<a class='booking-action' href='{$edit_url}' title='Editar este agendameto'>editar</a>";
			}

			// 'Cancelar 'ação se o usuário for um administrador, proprietário da sala ou proprietário do agendamento
			//
			if (
				($this->userauth->is_level(ADMINISTRADOR))
				or ($user_id == $booking->user_id)
				or (($user_id == $rooms[$room_id]->user_id) && ($booking->date != NULL))
			) {
				$cell['booking_id'] = $booking->booking_id;


				// $actions[] = "
				// 	<a type='button' name='cancel' class='button-empty booking-action' data-toggle='modal' data-target='#Modal$booking->booking_id'>cancelar</a>";
				$actions[] = "
					<a type='button' id='$booking->booking_id' name='cancel' class='button-empty booking-action' data-toggle='modal' data-target='#modalDelete' onclick='deleteModal(this.id)'>cancelar</a>";
			}

			if (!empty($actions)) {
				$vars['{actions}'] = '<div class="booking-cell-actions">' . implode(" ", $actions) . '</div>';
			}

			// Modelo de processo para itens
			$cell['body'] = strtr($template, $vars);
			// Remova as tags que não têm conteúdo
			$cell['body'] = str_replace(array_keys($vars), '', $cell['body']);
		} else {
			// Sem agendamento
			$cell['class'] = 'free';
			$cell['body'] = '';
			$cell['booking_id'] = '';
			$cell['bookingModel'] = false;


			$booking_status = $this->userauth->can_create_booking($booking_date_ymd);
			if ($booking_status->result === TRUE) {
				$book_url = site_url($url);
				//$cell['url'] = site_url($url);
				$cell['class'] = 'free';
				// $cell['body'] = '<a style="color:#000" href="' . $book_url . '"><img src="' . base_url('assets/images/ui/accept.png') . '" width="16" height="16"  alt="Agendar" title="Agendar" hspace="4" align="absmiddle" /></a>';
				// $cell['body'] = '<a href="' . $book_url . '" style="height:60px;"></a>';
				// if ($booking_status->is_admin) {
				// 	$cell['body'] .= '<input style="visibility: hidden;" id="multi_select_recurring" type="checkbox" name="recurring[]" value="' . $url . '" />';
				// }
				$cell['body'] = '<a href="' . $book_url . '" style="height:80px;">';

				if ($booking_status->is_admin) {
					$cell['body'] .= '<input style="visibility: hidden; margin: 25%;" id="multi_select_recurring" type="checkbox" name="recurring[]" value="' . $url . '" /></a>';
				} else {
					$cell['body'] .= '</a>';
				}
			} else {
				$cell['class'] = 'unavailable';
				$cell['body'] = '<a class="bookings-grid-button" tabindex="0" data-toggle="popover" data-trigger="focus" 
				data-content="A data do agendamento está no passado.">'
					. img([
						'role' => 'button',
						'src' => 'assets/images/ui/school_manage_weeks1.png',
						'alt' => 'Periodo',
					]) .
					'</a>';
			}
		}

		// If a holiday is applicable, display that instead.
		if (isset($holidays[$booking_date_ymd])) {
			$cell['class'] = 'holiday';
			// $cell['body'] = $holidays[$booking_date_ymd][0]->name;
			$cell['body'] = '<a class="bookings-grid-button" tabindex="0" data-toggle="popover" data-trigger="focus" 
				title="Feriado" data-content="' . $holidays[$booking_date_ymd][0]->name . '">'
				. img([
					'role' => 'button',
					'src' => 'assets/images/ui/school_manage_holidays.png',
					'alt' => 'Feriado',
				]) . '
				</a>';
			// print_r($holidays[$booking_date_ymd][0]);
		}
		#$cell['width'] =
		#return sprintf('<td class="%s" valign="middle" align="center">%s</td>', $cell['class'], $cell['body']);
		return $this->load->view('bookings/table/bookingcell', $cell, True);
	}


	/**
	 * Get the next date that has bookable periods based on the current date.
	 * Used by html() function to work out which date for Prev/Back links.
	 *
	 * @param string $current_date Current date.
	 * @param string $direction Either previous or next.
	 *
	 */
	private function get_nav_date($current_date, $direction)
	{
		$dt = new DateTime($current_date);
		$dt->setTime(0, 0, 0);

		switch ($direction) {
			case 'next':
				$modify_str = '+1 day';
				break;
			case 'previous':
				$modify_str = '-1 day';
				break;
		}

		if (empty($this->all_periods)) {
			return $dt->modify($modify_str)->format('Y-m-d');
		}

		$next_date = NULL;

		while ($next_date === NULL) {
			$dt->modify($modify_str);
			$day_num = $dt->format('N');
			if (array_key_exists("{$day_num}", $this->periods_by_day_num)) {
				$next_date = $dt->format('Y-m-d');
			}
		}

		return $next_date;
	}





	function html($params = array())
	{
		$this->populate_periods();

		$defaults = array(
			'school' => array(),		// dados carregados no controlador (usuários, dias)
			'query' => array(),		// entrada para onde o usuário está/o que deve ser carregado
		);

		$data = array_merge($defaults, $params);
		extract($data);

		// Formate a data para Ymd
		if (!isset($query['date'])) {
			$date = time();
			$date_ymd = date("Y-m-d", $date);
		} else {
			$date = strtotime($query['date']);
			$date_ymd = date("Y-m-d", $date);
		}

		// Número do dia da semana de hoje
		$day_num = date('N', $date);

		// Obter informações sobre a semana atual
		$this_week = $this->WeekObj($date);

		// Init HTML + variável Jscript
		$html = '';

		// Coloque os usuários na matriz com seu ID como a chave
		foreach ($school['users'] as $user) {
			$users[$user->user_id] = $user;
		}

		// Obter Salas
		$rooms = $this->Rooms();
		if ($rooms == FALSE) {
			$html .= msgbox('error', 'Não há salas disponíveis. Entre em contato com o seu administrador.');
			return $html;
		}

		// Descubra quais colunas exibir e qual tipo de visualização usamos
		$style = $this->BookingStyle();
		if (!$style or (empty($style['cols']) or empty($style['display']))) {
			$html = msgbox('error', 'Nenhum estilo de reserva foi configurado. Entre em contato com o seu administrador.');
			return $html;
		}
		$cols = $style['cols'];
		$display = $style['display'];

		// Selecione um quarto padrão se nenhum for fornecido (primeiro quarto)
		if (!isset($query['room'])) {
			$room_c = current($rooms);
			$query['room'] = $room_c->room_id;
		} else {
			// Check requested room is in the list of accessible rooms
			if (!array_key_exists($query['room'], $rooms)) {
				$html = msgbox('error', 'A sala selecionada não está acessível.');
				return $html;
			}
		}

		// Carregue a caixa de seleção apropriada dependendo do estilo de exibição
		switch ($display) {

			case 'room':
				$html .= $this->load->view('bookings/select_room', array(
					'rooms' => $rooms,
					'room_id' => $query['room'],
					'chosen_date' => $date_ymd,
				), TRUE);
				break;

			case 'day':
				$html .= $this->load->view('bookings/select_date', array(
					'chosen_date' => $date,
				), TRUE);
				break;

			default:
				$html .= msgbox('error', 'Erro de aplicativo: nenhum tipo de exibição definido.');
				return $html;
				break;
		}

		$weekdates = array();
		$week_bar = array();

		// Altere a barra da semana dependendo do tipo de visualização
		switch ($display) {

			case 'room':

				$week_bar['back_date'] = date("Y-m-d", strtotime("last Week", $date));
				$week_bar['back_text'] = '&larr; Semana anterior';
				$week_bar['back_link'] = 'bookings?' . http_build_query(array(
					'date' => $week_bar['back_date'],
					'room' => $query['room'],
					'direction' => 'back',
				));

				$week_bar['next_date'] = date("Y-m-d", strtotime("next Week", $date));
				$week_bar['next_text'] = 'Semana seguinte &rarr;';
				$week_bar['next_link'] = 'bookings?' . http_build_query(array(
					'date' => $week_bar['next_date'],
					'room' => $query['room'],
					'direction' => 'next',
				));

				break;

			case 'day':

				$week_bar['back_text'] = '&larr; Voltar';
				$week_bar['back_date'] = $this->get_nav_date($date_ymd, 'previous');
				$week_bar['back_link'] = 'bookings?' . http_build_query(array(
					'date' => $week_bar['back_date'],
					'direction' => 'back',
				));

				$week_bar['next_text'] = 'Avançar &rarr; ';
				$week_bar['next_date'] = $this->get_nav_date($date_ymd, 'next');
				$week_bar['next_link'] = 'bookings?' . http_build_query(array(
					'date' => $week_bar['next_date'],
					'direction' => 'next',
				));

				$week_bar['longdate'] = utf8_encode(strftime(setting('date_format_long'), $date));

				break;
		}

		// Temos alguma informação sobre o nome desta semana?
		if ($this_week) {

			// Sim, altere a barra de navegação da semana com os detalhes da semana

			$week_bar['week_name'] = $this_week->name;

			// Obter datas para cada dia da semana
			if ($display == 'room') {

				$this_date = strtotime("-1 day", strtotime($this_week->date));
				foreach ($school['days_list'] as $d_day_num => $d_day_name) {
					$weekdates[$d_day_num] = date("Y-m-d", strtotime("+1 day", $this_date));
					$this_date = strtotime("+1 day", $this_date);
				}
				// $week_bar['longdate'] = 'Semana começando em ' . utf8_encode(strftime(setting('date_format_long'), strtotime($this_week->date)));
				$week_bar['longdate'] = 'Semana começando em ' . strftime(setting('date_format_long'), strtotime($this_week->date));
			}

			$week_bar['style'] = sprintf('padding:6px 3px;font-weight:bold;background:#%s;color:#%s', $this_week->bgcol, $this_week->fgcol);

			$html .= $this->load->view('bookings/week_bar', $week_bar, TRUE);
		} else {

			// Sem semana - altere as propriedades para indicar que não há semana disponível
			$week_bar['longdate'] = 'Semana começando em ' . strftime(setting('date_format_long'), $date);
			// $week_bar['longdate'] = 'Semana começando em ' . utf8_encode(strftime(setting('date_format_long'), $date));
			$week_bar['week_name'] = 'Nenhum';
			$week_bar['style'] = sprintf('padding:6px 3px;font-weight:bold;background:#%s;color:#%s', 'dddddd', '000');
			$html .= $this->load->view('bookings/week_bar', $week_bar, TRUE);
			// Notificar o usuário que nenhuma semana de horário está disponível
			$html .= msgbox('error', 'Nenhuma semana de horário foi configurada para esta seleção.');
			// Erro de sinalização para interromper a saída antes da tabela
			$err = TRUE;
		}

		// Feriados
		//

		// Inicialize sql como null aqui, para que possamos se *não for* mais tarde.
		// Se não for nulo, temos SQL para feriados
		$sql = NULL;

		// Veja se nossa data selecionada está em um feriado
		if ($display === 'day') {
			// Se formos um dia de cada vez, é fácil!
			// = me dê quaisquer feriados em que este dia esteja em qualquer lugar
			$sql = "SELECT *
					FROM holidays
					WHERE date_start <= '{$date_ymd}'
					AND date_end >= '{$date_ymd}' ";
		} else {
			if ($this_week) {
				// Se formos salas/semana de cada vez, um pouco mais complexo
				$week_start = date('Y-m-d', strtotime($this_week->date));
				$week_end = date('Y-m-d', strtotime('+' . count($school['days_list']) . ' days', strtotime($this_week->date)));

				$sql = "SELECT *
						FROM holidays
						WHERE
						/* Começa antes desta semana, termina esta semana */
						(date_start <= '$week_start' AND date_end <= '$week_end')
						/* Começa esta semana, termina esta semana */
						OR (date_start >= '$week_start' AND date_end <= '$week_end')
						/* Começa esta semana, termina após esta semana */
						OR (date_start >= '$week_start' AND date_end >= '$week_end')
						";
			}
		}

		$holidays = array();
		$holiday_dates = array();
		$holiday_interval = new DateInterval('P1D');

		if (isset($sql)) {
			$holiday_query = $this->db->query($sql);
			$holidays = $holiday_query->result();
		}

		// Organize nossas férias por data
		foreach ($holidays as $holiday) {
			// Obter todas as datas entre date_start e date_end
			$start_dt = new DateTime($holiday->date_start);
			$end_dt = new DateTime($holiday->date_end);
			$end_dt->modify('+1 day');
			$range = new DatePeriod($start_dt, $holiday_interval, $end_dt);
			foreach ($range as $date) {
				$holiday_ymd = $date->format('Y-m-d');
				$holiday_dates[$holiday_ymd][] = $holiday;
			}
		}

		if ($display === 'day' && isset($holiday_dates[$date_ymd])) {

			// A data selecionada ESTÁ em um feriado - dê a eles uma bela mensagem dizendo isso.
			$holiday = $holiday_dates[$date_ymd][0];
			$msg = sprintf(
				'A data que você selecionou é durante um período sem aulas (%s, %s - %s).',
				$holiday->name,
				date("d/m/Y", strtotime($holiday->date_start)),
				date("d/m/Y", strtotime($holiday->date_end))
			);
			$html .= msgbox('exclamation', $msg);

			// Deixe-os escolher a data depois/antes
			// Se estiver navegando um dia de cada vez, vá apenas um dia.
			// Se estiver navegando em uma sala de cada vez, mova em uma semana
			if ($display === 'day') {
				$next_date = date("Y-m-d", strtotime("+1 day", strtotime($holiday->date_end)));
				$prev_date = date("Y-m-d", strtotime("-1 day", strtotime($holiday->date_start)));
			} elseif ($display === 'room') {
				$next_date = date("Y-m-d", strtotime("+1 week", strtotime($holiday->date_end)));
				$prev_date = date("Y-m-d", strtotime("-1 week", strtotime($holiday->date_start)));
			}

			if (!isset($query['direction'])) {
				$query['direction'] = 'forward';
			}

			switch ($query['direction']) {

				case 'forward':
					$query['date'] = $next_date;
					$uri = 'bookings?' . http_build_query($query);
					$link = anchor($uri, "Click here to view immediately after the holiday.");
					$html .= "<p><strong>{$link}</strong></p>";
					break;

				case 'back':
					$query['date'] = $prev_date;
					$uri = 'bookings?' . http_build_query($query);
					$link = anchor($uri, "Click here to view immediately before the holiday.");
					$html .= "<p><strong>{$link}</strong></p>";
					break;
			}

			$err = TRUE;
		}

		// Get periods
		if ($style['display'] == 'day') {
			if (array_key_exists($day_num, $this->periods_by_day_num)) {
				$periods = $this->periods_by_day_num[$day_num];
			} else {
				$periods = [];
			}
		} else {
			$periods = $this->all_periods;
		}

		if (empty($periods)) {
			$html .= msgbox('error', 'Não há períodos configurados ou disponíveis para este dia.');
			$err = TRUE;
		}

		if (isset($err) && $err == TRUE) {
			return $html;
		}

		$count = array(
			'periods' => count($periods),
			'rooms' => count($rooms),
			'days' => count(array_keys($this->periods_by_day_num)),	// count($school['days_list']),
		);

		$col_width = sprintf('%s%%', round(100 / ($count[$cols] + 1)));

		// abrindo do form
		$html .= form_open('bookings/action', array(
			'name' => 'bookings',
		));
		$html .= form_hidden('room_id', $query['room']);

		// Aqui estamos iniciando a tabela
		$html .= '<table border="0" bordercolor="#ffffff" cellpadding="2" cellspacing="2" class="bookings" width="100%">';

		//Adicionando o modal para deletar agendamentos
		if ($this->userauth->is_level(ADMINISTRADOR)) {
			$data['cancel_msg'] = '<h5 class="alert">Você tem certeza que deseja cancelar este agendamento?</p></br>
			<strong style="color: red;"> Por favor, tenha cuidado este agendamento nao é seu.</strong></h5>';
		} else {
			$data['cancel_msg'] = '<h4 class="alert">Você tem certeza que deseja cancelar este agendamento?</h4>';
		}
		$html .= $this->load->view('bookings/delete_modal', $data, TRUE);

		// COLUNAS !!
		$html .= '<tr><td>&nbsp;</td>';

		switch ($cols) {

			case 'periods':

				foreach ($periods as $period) {
					$period->width = $col_width;
					$html .= $this->load->view('bookings/table/cols_periods', $period, TRUE);
				}

				break;

			case 'days':

				foreach ($school['days_list'] as $day_num => $dayofweek) {
					// Skip days without periods
					if (!array_key_exists($day_num, $this->periods_by_day_num)) {
						continue;
					}
					$day['width'] = $col_width;
					$day['name'] = $dayofweek;
					$day['date'] = $weekdates[$day_num];
					$day['today'] = date('Y-m-d');
					$html .= $this->load->view('bookings/table/headings/days', $day, TRUE);
				}

				break;

			case 'rooms':

				foreach ($rooms as $room) {
					$room->width = $col_width;
					$html .= $this->load->view('bookings/table/cols_rooms', $room, TRUE);
				}

				break;
		}	// End switch for cols

		$bookings = array();

		// Here we go!
		switch ($display) {

			case 'room':

				// ONE ROOM AT A TIME - COLS ARE PERIODS OR DAY NAMES...

				switch ($cols) {

					case 'periods':

						/*
							    [P1] [P2] [P3] ...
							[Mo]
							[Tu]
							....
						*/

						// Columns are periods, so each row is a day name

						foreach ($school['days_list'] as $day_num => $day_name) {
							// Skip days without periods
							if (!array_key_exists($day_num, $this->periods_by_day_num)) {
								continue;
							}

							// Get booking
							// TODO: Need to get date("Y-m-d") of THIS weekday (Mon, Tue, Wed) for this week
							$bookings = array();

							$sql = "SELECT * FROM bookings
									WHERE room_id = ?
									AND ((day_num = ? AND week_id = ?) OR `date` = ?) ";

							$bookings_query = $this->db->query($sql, array(
								$query['room'],
								$day_num,
								$this_week->week_id,
								$weekdates[$day_num],
							));

							if ($bookings_query->num_rows() > 0) {
								$result = $bookings_query->result();
								foreach ($result as $row) {
									$bookings[$row->period_id] = $row;
								}
							}

							$bookings_query->free_result();

							$booking_date_ymd = $weekdates[$day_num];

							// Start row
							$html .= '<tr>';

							// First cell
							$day['width'] = $col_width;
							$day['name'] = $day_name;
							$day['date'] = $booking_date_ymd;
							$html .= $this->load->view('bookings/table/rowinfo/days', $day, TRUE);


							// Now all the other ones to fill in periods
							foreach ($periods as $period) {

								// URL
								$book_url_query = array(
									'period' => $period->period_id,
									'room' => $query['room'],
									'day_num' => $day_num,
									'week' => $this_week->week_id,
									'date' => $booking_date_ymd,
								);
								$url = 'bookings/book?' . http_build_query($book_url_query);

								// This period is bookable on this day?
								$key = "day_{$day_num}";
								if ($period->{$key} == '1') {
									// Bookable
									$html .= $this->BookingCell($bookings, $period->period_id, $rooms, $users, $query['room'], $url, $booking_date_ymd, $holiday_dates);
								} else {
									// Period not bookable on this day, do not show or allow any bookings
									$html .= '<td align="center">&nbsp;</td>';
								}
							}		// Done looping periods (cols)

							// This day row is finished
							$html .= '</tr>';
						}


						break;		// End $display 'room' $cols 'periods'

					case 'days':

						/*
								 [Mo] [Tu] [We] ...
							[P1]
							[P2]
							....
						*/

						// Columns are days, so each row is a period

						foreach ($periods as $period) {

							// Get bookings
							$bookings = array();
							$sql = "SELECT * FROM bookings
									WHERE room_id = ?
									AND period_id = ?
									AND ( week_id = ? OR (`date` >= ? AND `date` <= ?) )";
							#."AND ((day_num=$day_num AND week_id=$this_week->week_id) OR date='$date_ymd') ";

							$bookings_query = $this->db->query($sql, array(
								$query['room'],
								$period->period_id,
								$this_week->week_id,
								$weekdates[1],
								$weekdates[7],
							));

							$results = $bookings_query->result();
							if ($bookings_query->num_rows() > 0) {
								foreach ($results as $row) {
									if (!empty($row->date)) {
										// Static booking on date
										$this_daynum = date('N', strtotime($row->date));
										$bookings[$this_daynum] = $row;
									} else {
										// Recurring booking
										$bookings[$row->day_num] = $row;
									}
								}
							}
							$bookings_query->free_result();

							// Linha inicial
							$html .= '<tr>';

							// Primeira célula, informação
							$period->width = $col_width;
							$html .= $this->load->view('bookings/table/rows_periods', $period, TRUE);

							foreach ($school['days_list'] as $day_num => $day_name) {

								if (!array_key_exists($day_num, $this->periods_by_day_num)) {
									continue;
								}

								$booking_date_ymd = $weekdates[$day_num];

								// URL
								$book_url_query = array(
									'period' => $period->period_id,
									'room' => $query['room'],
									'day_num' => $day_num,
									'week' => $this_week->week_id,
									'date' => $booking_date_ymd,
								);
								$url = 'bookings/book?' . http_build_query($book_url_query);

								// $url = 'period/%s/room/%s/day/%s/week/%s/date/%s';
								// $url = sprintf($url, $period->period_id, $room_id, $day_num, $this_week->week_id, $booking_date_ymd);

								//Este período pode ser agendado neste dia?
								$key = "day_{$day_num}";
								if ($period->{$key} == '1') {
									// Pode ser agendado
									$html .= $this->BookingCell($bookings, $day_num, $rooms, $users, $query['room'], $url, $booking_date_ymd, $holiday_dates);
								} else {
									// Período não agendavel neste dia, não mostrar ou permitir qualquer agendamento
									$html .= '<td class="unavailable" align="center"><a class="bookings-grid-button" tabindex="0" data-toggle="popover" data-trigger="focus" 
									data-content="Este horário não está disponível para esse dia da semana.">'
										. img([
											'role' => 'button',
											'src' => 'assets/images/ui/clock.png',
											'alt' => 'periodo',
										]) .
										'</a></td>';
								}
							}

							// Esta linha de período terminou
							$html .= '</tr>';
						}

						break;		//Fim de $display 'room' $cols 'dias'

				}

				break;

			case 'day':

				// ONE DAY AT A TIME - COLS ARE DAY NAMES OR ROOMS

				switch ($cols) {

					case 'periods':

						/*
								[P1] [P2] [P3] ...
							[R1]
							[R2]
							....
						*/

						// Columns are periods, so each row is a room

						foreach ($rooms as $room) {

							$bookings = array();

							// See if there are any bookings for any period this room.
							// A booking will either have a date (teacher booking), or a day_num and week_id (static/timetabled)

							$sql = "SELECT *
									FROM bookings
									WHERE room_id = ?
									AND ((day_num = ? AND week_id = ?) OR `date` = ?)";

							$bookings_query = $this->db->query($sql, array(
								$room->room_id,
								$day_num,
								$this_week->week_id,
								$date_ymd,
							));

							if ($bookings_query->num_rows() > 0) {
								$result = $bookings_query->result();
								foreach ($result as $row) {
									$bookings[$row->period_id] = $row;
								}
							}
							$bookings_query->free_result();

							// Start row
							$html .= '<tr>';

							$room->width = $col_width;
							$html .= $this->load->view('bookings/table/rows_rooms', $room, TRUE);

							foreach ($periods as $period) {

								// URL
								$book_url_query = array(
									'period' => $period->period_id,
									'room' => $room->room_id,
									'day_num' => $day_num,
									'week' => $this_week->week_id,
									'date' => $date_ymd,
								);
								$url = 'bookings/book?' . http_build_query($book_url_query);

								$key = "day_{$day_num}";
								if ($period->{$key} == '1') {
									// Bookable
									$html .= $this->BookingCell($bookings, $period->period_id, $rooms, $users, $room->room_id, $url, $date_ymd, $holiday_dates);
								} else {
									// Period not bookable on this day, do not show or allow any bookings
									$html .= '<td align="center">&nbsp;</td>';
								}
							}

							// End row
							$html .= '</tr>';
						}

						break;		// End $display 'day' $cols 'periods'

					case 'rooms':

						/*
							[R1] [R2] [R3] ...
						[P1]
						[P2]
						*/

						// Columns are rooms, so each row is a period

						foreach ($periods as $period) {

							$bookings = array();

							// See if there are any bookings for any period this room.
							// A booking will either have a date (teacher booking), or a day_num and week_id (static/timetabled)
							$sql = "SELECT * FROM bookings
									WHERE period_id = ?
									AND ((day_num = ? AND week_id = ?) OR `date` = ?) ";

							$bookings_query = $this->db->query($sql, array(
								$period->period_id,
								$day_num,
								$this_week->week_id,
								$date_ymd,
							));

							if ($bookings_query->num_rows() > 0) {
								$result = $bookings_query->result();
								foreach ($result as $row) {
									$bookings[$row->room_id] = $row;
								}
							}

							$bookings_query->free_result();

							// Start period row
							$html .= '<tr>';

							// First cell, info
							$period->width = $col_width;
							$html .= $this->load->view('bookings/table/rows_periods', $period, TRUE);

							foreach ($rooms as $room) {

								// URL
								$book_url_query = array(
									'period' => $period->period_id,
									'room' => $room->room_id,
									'day_num' => $day_num,
									'week' => $this_week->week_id,
									'date' => $date_ymd,
								);
								$url = 'bookings/book?' . http_build_query($book_url_query);

								// $url = 'period/%s/room/%s/day/%s/week/%s/date/%s';
								// $url = sprintf($url, $period->period_id, $room->room_id, $day_num, $this_week->week_id, $date_ymd);

								// Bookable on this day?
								$key = "day_{$day_num}";
								if ($period->{$key} == '1') {
									// Bookable
									$html .= $this->BookingCell($bookings, $room->room_id, $rooms, $users, $room->room_id, $url, $date_ymd, $holiday_dates);
								} else {
									// Period not bookable on this day, do not show or allow any bookings
									$html .= '<td align="center">&nbsp;</td>';
								}
							}

							// End period row
							$html .= '</tr>';
						}

						break;		// End $display 'day' $cols 'rooms'

				}

				break;
		}


		$html .= $this->Table();

		// Finish table
		$html .= '</table>';

		// Visual key
		$html .= $this->load->view('bookings/key', NULL, TRUE);

		// Show link to making a booking for admins
		if ($this->userauth->is_level(ADMINISTRADOR)) {
			$html .= $this->load->view('bookings/make_recurring', array('users' => $school['users']), TRUE);
		}

		$html .= form_close();

		// Finaly return the HTML variable so the controller can then pass it to the view.
		return $html;
	}




	public function Cancel($booking_id)
	{
		$sql = "DELETE FROM bookings
				WHERE booking_id = ?
				LIMIT 1";

		$query = $this->db->query($sql, array($booking_id));
		return ($query && $this->db->affected_rows() == 1);
	}




	function BookingStyle()
	{
		$out = array(
			'cols' => setting('d_columns'),
			'display' => setting('displaytype'),
		);

		if (empty($out['cols']) || empty($out['display'])) {
			return FALSE;
		}

		return $out;
	}




	/**
	 * Get rooms and their users
	 *
	 */
	function Rooms()
	{
		$room_filter = '';

		if ($this->userauth->is_level(PROFESSOR)) {
			$user_id = $this->userauth->user->user_id;
			$view_permisson = Access_control_model::ACCESS_VIEW;
			$room_ids = $this->access_control_model->get_accessible_rooms($user_id, $view_permisson);
			if (empty($room_ids)) {
				// Force non-match if no room IDs available
				$room_filter = ' AND 1=2 ';
			} else {
				// Filter to only room IDs that are accessible
				$id_string = implode(',', $room_ids);
				$room_filter = "AND (room_id IN ({$id_string}))";
			}
		}

		$sql = "SELECT rooms.*, users.user_id, users.username, users.displayname
				FROM rooms
				LEFT JOIN users ON users.user_id=rooms.user_id
				WHERE rooms.bookable = 1
				{$room_filter}
				ORDER BY name asc";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			$result = $query->result();
			// Put all room data into an array where the key is the room_id
			foreach ($result as $room) {
				$rooms[$room->room_id] = $room;
			}
			return $rooms;
		}

		return FALSE;
	}




	/**
	 * Returns an object containing the week information for a given date
	 *
	 */
	public function WeekObj($date)
	{
		// First find the monday date of the week that $date is in
		if (date("N", $date) == 1) {
			$nextdate = date("Y-m-d", $date);
		} else {
			$nextdate = date("Y-m-d", strtotime("last Monday", $date));
		}

		// Get week info that this date falls into
		$sql = "SELECT * FROM weeks, weekdates
				WHERE weeks.week_id = weekdates.week_id
				AND weekdates.date = '$nextdate'
				LIMIT 1";

		$query = $this->db->query($sql);

		if ($query->num_rows() == 1) {
			$row = $query->row();
		} else {
			$row = false;
		}

		return $row;
	}




	/**
	 * Adicionar um agendamento
	 *
	 */
	function Add($data = array())
	{
		// Execute a consulta para inserir uma linha em branco
		$this->db->insert('bookings', array('booking_id' => NULL));
		// Obter id do registro inserido
		$booking_id = $this->db->insert_id();
		// Agora chame a função de edição para atualizar os dados reais para esta nova linha agora que temos o ID
		return $this->Edit($booking_id, $data);
	}




	function Edit($booking_id, $data)
	{
		$this->db->where('booking_id', $booking_id);
		$result = $this->db->update('bookings', $data);
		// Retornar bool em caso de sucesso
		if ($result) {
			return $booking_id;
		} else {
			return false;
		}
	}




	function ByRoomOwner($user_id = 0)
	{
		$maxdate = date("Y-m-d", strtotime("+14 days", Now()));
		$today = date("Y-m-d");
		$sql = "SELECT rooms.*, bookings.*, users.username, users.displayname, users.user_id, periods.name as periodname
				FROM bookings
				JOIN rooms ON rooms.room_id=bookings.room_id
				JOIN users ON users.user_id=bookings.user_id
				JOIN periods ON periods.period_id=bookings.period_id
				WHERE rooms.user_id='$user_id' AND bookings.cancelled=0
				AND bookings.date IS NOT NULL
				AND bookings.date <= '$maxdate'
				AND bookings.date >= '$today'
				ORDER BY bookings.date, rooms.name ";

		$query = $this->db->query($sql);

		if ($query->num_rows() > 0) {
			// We have some bookings
			return $query->result();
		}

		return FALSE;
	}




	function ByUser($user_id)
	{
		$maxdate = date("Y-m-d", strtotime("+14 days", Now()));
		$today = date("Y-m-d");
		// All current bookings for this user between today and 2 weeks' time
		$sql = "SELECT rooms.*, bookings.*, periods.name as periodname, periods.time_start, periods.time_end
				FROM bookings
				JOIN rooms ON rooms.room_id=bookings.room_id
				JOIN periods ON periods.period_id=bookings.period_id
				WHERE bookings.user_id='$user_id' AND bookings.cancelled=0
				AND bookings.date IS NOT NULL
				AND bookings.date <= '$maxdate'
				AND bookings.date >= '$today'
				ORDER BY bookings.date asc, periods.time_start asc";

		$query = $this->db->query($sql);
		if ($query->num_rows() > 0) {
			return $query->result();
		} else {
			return false;
		}
	}


	public function CountScheduledByUser($user_id)
	{
		$today = date("Y-m-d");
		$time = date('H:i');

		$sql = 'SELECT COUNT(booking_id) AS total
				FROM bookings
				JOIN periods ON periods.period_id = bookings.period_id
				WHERE bookings.user_id = ?
				AND bookings.cancelled = 0
				AND bookings.date IS NOT NULL
				AND (
					(bookings.date > ?)	/* depois de hoje  */
					OR
					(bookings.date = ? AND periods.time_start > ?) /* hoje, mas depois da hora*/
				)';

		$query = $this->db->query($sql, [
			$user_id,
			$today,
			$today,
			$time
		]);

		$row = $query->row_array();
		return (int) $row['total'];
	}

	public function CountScheduledAll()
	{
		$today = date("Y-m-d");
		$time = date('H:i');

		$sql = 'SELECT COUNT(booking_id) AS total
				FROM bookings
				JOIN periods ON periods.period_id = bookings.period_id
				WHERE bookings.cancelled = 0
				AND bookings.date IS NOT NULL
				AND (
					(bookings.date > ?)	/* depois de hoje */
					OR
					(bookings.date = ? AND periods.time_start > ?) /* hoje, mas depois da hora */
				)';

		$query = $this->db->query($sql, [
			$today,
			$today,
			$time
		]);

		$row = $query->row_array();
		return (int) $row['total'];
	}

	function TotalNum($user_id = 0)
	{
		$today = date("Y-m-d");

		// Total de agendamento feito por todos os usuários!
		$sql = "SELECT COUNT(booking_id) AS total
				FROM bookings;";
		$query = $this->db->query($sql);
		$row = $query->row_array();
		$total['all'] = $row['total'];

		// Total de agendamento feitospelo usuário!
		$sql = "SELECT COUNT(booking_id) AS total
				FROM bookings
				WHERE user_id = ?";
		$query = $this->db->query($sql, [$user_id]);
		$row = $query->row_array();
		$total['singleuser'] = $row['total'];

		// Todas os agendamentos por usuário, para este ano letivo, até e incluindo hoje
		$sql = "SELECT COUNT(booking_id) AS total
				FROM bookings
				JOIN academicyears ON bookings.date >= academicyears.date_start
				WHERE bookings.user_id = ? ";
		$query = $this->db->query($sql, [$user_id]);
		$row = $query->row_array();
		$total['yeartodate'] = $row['total'];

		// Todas os agendamentos, para este ano letivo, até e incluindo hoje
		$sql = "SELECT COUNT(booking_id) AS total
				FROM bookings
				JOIN academicyears ON bookings.date >= academicyears.date_start";
		$query = $this->db->query($sql, [$user_id]);
		$row = $query->row_array();
		$total['allyeartodate'] = $row['total'];


		// Todas as reservas até e incluindo hoje
		$sql = "SELECT COUNT(booking_id) AS total
				FROM bookings
				WHERE bookings.user_id = ?
				AND bookings.date <= ?";
		$query = $this->db->query($sql, [$user_id, $today]);
		$row = $query->row_array();
		$total['todate'] = $row['total'];

		$total['active'] = $this->CountScheduledByUser($user_id);
		$total['allactive'] = $this->CountScheduledAll();


		return $total;
	}
}
