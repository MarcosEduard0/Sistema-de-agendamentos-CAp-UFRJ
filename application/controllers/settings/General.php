<?php
defined('BASEPATH') or exit('No direct script access allowed');

class General extends MY_Controller
{


	private $tzlist;


	public function __construct()
	{
		parent::__construct();
		$this->require_auth_level(ADMINISTRATOR);

		$this->tzlist = DateTimeZone::listIdentifiers(DateTimeZone::ALL);
	}


	/**
	 * Página de configurações
	 *
	 */
	function index()
	{
		$this->data['settings'] = $this->settings_model->get_all('crbs');

		if ($this->input->post()) {
			$this->save_settings();
		}


		$zones = [];
		foreach ($this->tzlist as $tz) {
			$zones[$tz] = $tz;
		}
		$this->data['timezones'] = $zones;

		$this->data['title'] = 'Configurações';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('settings/general', $this->data, TRUE);

		return $this->render();
	}



	/**
	 * Função do controlador para lidar com o formulário enviado
	 *
	 */
	private function save_settings()
	{
		// Analise a entrada de dados da visualização e execute a ação apropriada.

		// Carregar biblioteca de manipulação de imagens
		$this->load->library('image_lib');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('validity', 'Validade da conta', 'max_length[3]|numeric');
		$this->form_validation->set_rules('bia', 'Booking in advance', 'max_length[3]|numeric');
		$this->form_validation->set_rules('num_max_bookings', 'Maximum number of bookings', 'max_length[3]|numeric');
		$this->form_validation->set_rules('displaytype', 'Display type', 'required');
		$this->form_validation->set_rules('d_columns', 'Display columns', 'callback__valid_columns');
		$this->form_validation->set_rules('timezone', 'Timezone', 'required');
		$this->form_validation->set_rules('date_format_long', 'Long date format', 'max_length[30]');
		$this->form_validation->set_rules('date_format_weekday', 'Weekday date format', 'max_length[30]');
		$this->form_validation->set_rules('time_format_period', 'Period time format', 'max_length[30]');
		$this->form_validation->set_rules('bookings_show_user_single', 'User display (single)', 'is_natural');
		$this->form_validation->set_rules('bookings_show_user_recurring', 'User display (recurring)', 'is_natural');
		$this->form_validation->set_rules('login_message_enabled', 'Login message', 'is_natural');
		$this->form_validation->set_rules('login_message_text', 'Login message text', 'max_length[1024]');
		$this->form_validation->set_rules('maintenance_mode', 'Maintenance mode', 'is_natural');
		$this->form_validation->set_rules('maintenance_mode_message', 'Maintenance mode message', 'max_length[1024]');

		if ($this->form_validation->run() == FALSE) {
			return FALSE;
		}

		$settings = array(
			'validity' => (int) $this->input->post('validity'),
			'bia' => (int) $this->input->post('bia'),
			'num_max_bookings' => (int) $this->input->post('num_max_bookings'),
			'displaytype' => $this->input->post('displaytype'),
			'd_columns' => $this->input->post('d_columns'),
			'timezone' => $this->input->post('timezone'),
			'date_format_long' => $this->input->post('date_format_long'),
			'date_format_weekday' => $this->input->post('date_format_weekday'),
			'time_format_period' => $this->input->post('time_format_period'),
			'bookings_show_user_single' => $this->input->post('bookings_show_user_single'),
			'bookings_show_user_recurring' => $this->input->post('bookings_show_user_recurring'),
			'login_message_enabled' => $this->input->post('login_message_enabled'),
			'login_message_text' => $this->input->post('login_message_text'),
			'maintenance_mode' => $this->input->post('maintenance_mode'),
			'maintenance_mode_message' => $this->input->post('maintenance_mode_message'),
		);

		$settings['colour'] = '468ED8';

		// Definir valor de data padrão se vazio
		$date_format_long = trim($settings['date_format_long']);
		if (!strlen($date_format_long)) {
			$settings['date_format_long'] = "EEEE, dd 'de' MMMM 'de' y";
		}
		$date_format_weekday = trim($settings['date_format_weekday']);
		if (!strlen($date_format_weekday)) {
			$settings['date_format_weekday'] = "dd MMM";
		}
		$time_format_period = trim($settings['time_format_period']);
		if (!strlen($time_format_period)) {
			$settings['time_format_period'] = "H:i";
		}


		$this->settings_model->set($settings);

		$this->session->set_flashdata('saved', msgbox('info', 'As configurações foram atualizadas.'));

		redirect('settings/general');
	}


	function _valid_columns($cols)
	{
		// Dia: Períodos / Sala
		// Sala: Períodos / Dias
		$valid['day'] = array('periods', 'rooms');
		$valid['room'] = array('periods', 'days');

		$displaytype = $this->input->post('displaytype');

		switch ($displaytype) {

			case 'day':
				if (in_array($cols, $valid['day'])) {
					$ret = TRUE;
				} else {
					$ret = FALSE;
				}
				break;

			case 'room':
				if (in_array($cols, $valid['room'])) {
					$ret = TRUE;
				} else {
					$ret = FALSE;
				}
				break;
		}

		if ($ret == FALSE) {
			$this->form_validation->set_message('_valid_columns', 'A coluna que você selecionou é incompatível com o tipo de exibição.');
		}

		return $ret;
	}
}
