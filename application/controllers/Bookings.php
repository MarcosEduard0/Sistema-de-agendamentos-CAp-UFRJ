<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Bookings extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();

		$this->require_logged_in();

		$this->lang->load('bookings');

		$this->load->model(array(
			'crud_model',
			'rooms_model',
			'departments_model',
			'periods_model',
			'weeks_model',
			'users_model',
			'holidays_model',
			'bookings_model',
			'access_control_model',
		));

		$this->school = array(
			'users' => $this->users_model->Get(NULL, NULL, NULL),
			'days_list' => $this->periods_model->days,
		);

		if ($this->userauth->is_level(PROFESSOR) && setting('maintenance_mode')) {
			$this->data['title'] = 'Agendamentos';
			$this->data['showtitle'] = 'Manutenção';
			$this->data['body'] = 'Estamos em manutenção.';
			$this->render();
			$this->output->_display();
			exit();
		}
	}



	private function _store_query($data = array())
	{
		$_SESSION['query'] = $data;
	}


	private function _get_query()
	{
		if (array_key_exists('query', $_SESSION)) {
			return $_SESSION['query'];
		}

		return array();
	}




	function index()
	{
		$query = $this->input->get();

		$user_id = $this->userauth->user->user_id;

		if (!isset($query['date'])) {
			$query['date'] = date("Y-m-d");
			// Número do dia da data escolhida
			$day_num = date('N', strtotime($query['date']));
		}

		$room_of_user = $this->rooms_model->GetByUser($user_id);

		if (!isset($query['room'])) {
			if (!empty($room_of_user)) {
				$query['room'] = $room_of_user->room_id;
			} else {
				$query['room'] = NULL;
			}
		}

		if (!isset($query['direction'])) {
			$query['direction'] = 'forward';
		}

		$this->_store_query($query);

		$body['html'] = $this->bookings_model->html(array(
			'school' => $this->school,
			'query' => $query,
		));

		$this->data['title'] = 'Agendamentos';
		$this->data['showtitle'] = '';
		$this->data['body'] = $this->session->flashdata('saved');
		$this->data['body'] .= $body['html'];

		return $this->render();
	}




	/**
	 * Esta função pega a data que foi POSTADA e carrega a view ()
	 */
	function load()
	{
		$style = $this->bookings_model->BookingStyle();

		$this->load->library('form_validation');
		$this->form_validation->set_rules('chosen_date', 'Date', 'max_length[10]|callback_valid_date');
		$this->form_validation->set_rules('room_id', 'Room', 'integer');
		$this->form_validation->set_rules('direction', 'Diretion', '');

		if ($this->form_validation->run() == FALSE) {
			show_error("Desculpe, os detalhes solicitados não podem ser carregados.");
		}

		$query = array(
			'direction' => $this->input->post('direction'),
			'date' => $this->input->post('chosen_date'),
		);

		switch ($style['display']) {

			case 'day':

				// O tipo de exibição é um dia de cada vez - todas as salas/períodos
				if ($this->input->post('chosen_date')) {
					$datearr = explode('-', $this->input->post('chosen_date'));

					if (count($datearr) != 3) {
						show_error('Data escolhida é invalida.');
					}
					$query['date'] = date("Y-m-d", mktime(0, 0, 0, $datearr[1], $datearr[2], $datearr[0]));
				} else {
					show_error('Sem data escolhida');
				}

				break;

			case 'room':

				if ($this->input->post('room_id')) {
					$query['room'] = $this->input->post('room_id');
				} else {
					show_error('Nenhum dia selecionado');
				}

				break;
		}

		$uri = 'bookings/index?' . http_build_query($query);
		redirect($uri);
	}





	function book()
	{
		$query = $this->input->get();
		$query['department'] = 0;
		$this->data['title'] = 'Agendar uma sala';
		$this->data['showtitle'] = $this->data['title'];

		// Nenhum URI ou todas as informações de URI especificadas

		$this->data['hidden'] = new StdClass();

		if (isset($query['period']) && isset($query['room']) && isset($query['date']) && isset($query['department'])) {

			// Criar dados do agendamento
			$booking = new StdClass();
			$booking->booking_id = NULL;
			$booking->period_id = $query['period'];
			$booking->room_id = $query['room'];
			$booking->department_id = $query['department'];
			$booking->date = $query['date'];
			$booking->notes = '';
			$booking->user_id = $this->userauth->user->user_id;

			if ($this->userauth->is_level(ADMINISTRADOR)) {
				$booking->day_num = isset($query['day']) ? $query['day'] : NULL;
				$booking->week_id = isset($query['week']) ? $query['week'] : NULL;

				if (empty($booking->day_num)) {
					$booking->day_num = date('N', strtotime($query['date']));
				}
			}

			$this->data['booking'] = $booking;
			$this->data['hidden'] = (array) $booking;
		}
		// Pesquisas que precisamos para um usuário 
		$this->data['departments'] = $this->departments_model->Get();
		$this->data['days'] = $this->periods_model->days;
		$this->data['periods'] = $this->periods_model->Get();
		$this->data['weeks'] = $this->weeks_model->Get();
		$this->data['rooms'] = $this->rooms_model->Get();

		// Pesquisas que precisamos para um administrador
		if ($this->userauth->is_level(ADMINISTRADOR)) {
			$this->data['users'] = $this->school['users'];
		}

		$prev_query = $this->_get_query();
		$this->data['query_string'] = http_build_query($prev_query);
		$this->data['cancel_uri'] = 'bookings?' . http_build_query($prev_query);
		$this->data['body'] = $this->load->view('bookings/bookings_book', $this->data, TRUE);

		// Se tivermos uma data e o usuário for um professor, faça algumas verificações extras

		if (isset($query['date']) && $this->userauth->is_level(PROFESSOR)) {

			$booking_status = $this->userauth->can_create_booking($query['date']);

			if ($booking_status->result === FALSE) {

				$messages = [];

				if (!$booking_status->in_quota) {
					$msg = "Você atingiu o número máximo de reservas ativas (%d).";
					$msg = sprintf($msg, setting('num_max_bookings'));
					$messages[] = msgbox('error', $msg);
				}

				if (!$booking_status->is_future_date) {
					$msg = "A data escolhida é antiga.";
					$messages[] = msgbox('error', $msg);
				}

				if (!$booking_status->date_in_range) {
					$msg = "A data escolhida deve ter peloemnos %d dias de antecedência.";
					$msg = sprintf($msg, setting('bia'));
					$messages[] = msgbox('error', $msg);
				}

				$this->data['body'] = implode("\n", $messages);
			}
		}

		return $this->render();
	}



	/**
	 * Processe uma ação de formulário da tabela de reservas
	 *
	 */
	public function action()
	{
		if ($this->input->post('cancel')) {
			return $this->process_cancel();
		}

		if ($this->input->post('recurring')) {
			return $this->process_recurring();
		}
	}




	private function process_recurring()
	{
		$bookings = array();

		foreach ($this->input->post('recurring') as $booking) {
			list($uri, $params) = explode('?', $booking);
			parse_str($params, $data);
			$bookings[] = $data;
		}

		$errcount = 0;

		foreach ($bookings as $booking) {
			$booking_data = array(
				'user_id' => $this->input->post('user_id'),
				'period_id' => $booking['period'],
				'room_id' => $booking['room'],
				'notes' => $this->input->post('notes'),
				'week_id' => $booking['week'],
				'day_num' => $booking['day_num'],
			);

			if (!$this->bookings_model->Add($booking_data)) {
				$errcount++;
			}
		}

		if ($errcount > 0) {
			$flashmsg = msgbox('error', 'Uma ou mais agendamentos não puderam ser feitas.');
		} else {
			$flashmsg = msgbox('info', 'As agendamentos foram criados com sucesso.');
		}

		$this->session->set_userdata('notes', $booking_data['notes']);

		// Volta para o index
		$this->session->set_flashdata('saved', $flashmsg);

		$query = $this->_get_query();
		$uri = 'bookings/index?' . http_build_query($query);
		redirect($uri);
	}




	private function process_cancel()
	{
		$id = $this->input->post('cancel');
		$booking = $this->bookings_model->Get($id);
		$user_id = $this->userauth->user->user_id;
		$room = $this->rooms_model->Get($booking->room_id);

		$query = $this->_get_query();
		$uri = 'bookings/index?' . http_build_query($query);

		$can_delete = (($this->userauth->is_level(ADMINISTRADOR))
			or ($user_id == $booking->user_id)
			or (($user_id == $room->user_id) && ($booking->date != NULL)));

		if (!$can_delete) {
			$this->session->set_flashdata('saved', msgbox('error', "Você não tem os privilégios corretos para cancelar este agendamento."));
			return redirect($uri);
		}

		if ($this->bookings_model->Cancel($id)) {
			$msg = msgbox('info', 'O agendamento foi cancelado.');
		} else {
			$msg = msgbox('error', 'Ocorreu um erro ao cancelar o agendamento.');
		}

		$this->session->set_flashdata('saved', $msg);
		redirect($uri);
	}




	function edit($booking_id)
	{
		$booking = $this->bookings_model->Get($booking_id);

		$query = $this->_get_query();
		$uri = 'bookings?' . http_build_query($query);

		$can_edit = ($this->userauth->is_level(ADMINISTRADOR) or ($this->userauth->user->user_id == $booking->user_id));

		if (!$can_edit) {
			$this->session->set_flashdata('saved', msgbox('error', "Você não tem os privilégios corretos para cancelar este agendamento."));
			return redirect($uri);
		}

		$this->data['title'] = 'Editar agendamento';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['cancel_uri'] = 'bookings?' . http_build_query($query);

		// Dados para um usuário administrador
		if ($this->userauth->is_level(ADMINISTRADOR)) {
			$this->data['days'] = $this->periods_model->days;
			$this->data['rooms'] = $this->rooms_model->Get();
			$this->data['periods'] = $this->periods_model->Get();
			$this->data['weeks'] = $this->weeks_model->Get();
			$this->data['users'] = $this->school['users'];
		}
		$this->data['departments'] = $this->departments_model->Get();
		$this->data['booking'] = $booking;
		$this->data['hidden'] = (array) $booking;

		$this->data['body'] = $this->load->view('bookings/bookings_book', $this->data, TRUE);

		return $this->render();
	}





	function save()
	{
		// Obter ID do formulário
		$booking_id = $this->input->post('booking_id');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('booking_id', 'Booking ID', 'integer');
		$this->form_validation->set_rules('date', 'Date', 'max_length[10]');
		$this->form_validation->set_rules('use', 'Notes', 'max_length[100]');
		$this->form_validation->set_rules('period_id', 'Period', 'integer');
		$this->form_validation->set_rules('user_id', 'User', 'integer');
		$this->form_validation->set_rules('room_id', 'Room', 'integer');
		$this->form_validation->set_rules('department_id', 'Department', 'integer');
		$this->form_validation->set_rules('week_id', 'Week', 'integer');
		$this->form_validation->set_rules('day_num', 'Day of week', 'integer');

		if (!$this->input->post('day_num')) {
			$this->form_validation->set_rules('date', 'Date', 'max_length[10]|callback_valid_date');
		}

		if ($this->form_validation->run() == FALSE) {
			return (empty($booking_id) ? $this->book() : $this->edit($booking_id));
		}

		$booking_data = array(
			'user_id' => $this->input->post('user_id'),
			'period_id' => $this->input->post('period_id'),
			'room_id' => $this->input->post('room_id'),
			'department_id' => $this->input->post('department_id'),
			'notes' => $this->input->post('notes'),
			'booking_id' => $this->input->post('booking_id'),
		);

		//Determine se esta reserva é recorrente ou estática.
		if ($this->input->post('date')) {
			$date_arr = explode('-', $this->input->post('date'));
			$booking_data['date'] = date("Y-m-d", mktime(0, 0, 0, $date_arr[1], $date_arr[2], $date_arr[0]));
			$booking_data['day_num'] = NULL;
			$booking_data['week_id'] = NULL;
		}

		if ($this->input->post('recurring') && $this->input->post('week_id') && $this->input->post('day_num')) {
			$booking_data['date'] = NULL;
			$booking_data['day_num'] = $this->input->post('day_num');
			$booking_data['week_id'] = $this->input->post('week_id');
		}

		if ($this->_check_unique_booking($booking_data)) {
			$this->_persist_booking($booking_id, $booking_data);
		} else {
			$flashmsg = msgbox('exclamation', "Já existe um agendamento para essa data, período e sala.");
			$this->data['notice'] = $flashmsg;
			// $this->session->set_flashdata('saved', $flashmsg);
			return (empty($booking_id) ? $this->book() : $this->edit($booking_id));
		}

		$query = $this->_get_query();
		$uri = 'bookings/index?' . http_build_query($query);
		redirect($uri);
	}




	public function valid_date($date)
	{
		if (strpos($date, '/') !== FALSE) {
			$datearr = explode('/', $date);
			$valid = checkdate($datearr[1], $datearr[0], $datearr[2]);
		} elseif (strpos($date, '-') !== FALSE) {
			$datearr = explode('-', $date);
			$valid = checkdate($datearr[1], $datearr[2], $datearr[0]);
		} else {
			$this->form_validation->set_message('valid_date', 'Data inválida');
			return FALSE;
		}

		if ($valid) {
			return TRUE;
		}

		$this->form_validation->set_message('valid_date', 'Data inválida');
		return FALSE;
	}



	private function _check_unique_booking($data)
	{
		$bookings = $this->bookings_model->GetUnique(array(
			'date' => $data['date'],
			'period_id' => $data['period_id'],
			'room_id' => $data['room_id'],
			'booking_id' => $data['booking_id'],
			'week_id' => $data['week_id'],
			'day_num' => $data['day_num'],
		));

		return count($bookings) == 0;
	}



	private function _persist_booking($booking_id = NULL, $booking_data = array())
	{
		if (empty($booking_id)) {

			unset($booking_data['booking_id']);

			$booking_id = $this->bookings_model->Add($booking_data);

			if ($booking_id) {
				$flashmsg = msgbox('info', "Agendamento realizado com sucesso.");
			} else {
				$line = sprintf($this->lang->line('crbs_action_dberror'), 'adicionando');
				$flashmsg = msgbox('error', $line);
			}
		} else {

			if ($this->bookings_model->Edit($booking_id, $booking_data)) {
				$flashmsg = msgbox('info', "O agendamento foi atualizado.");
			} else {
				$line = sprintf($this->lang->line('crbs_action_dberror'), 'editando');
				$flashmsg = msgbox('error', $line);
			}
		}

		$this->session->set_flashdata('saved', $flashmsg);
	}
}
