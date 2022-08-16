<?php
defined('BASEPATH') or exit('No direct script access allowed');
ini_set('display_errors', 1);

class Login extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->require_logged_out();
	}


	function index()
	{
		$this->data['title'] = 'Sistema de Agendamentos CAp UFRJ';
		if (setting('login_message_enabled')) {
			$this->data['message'] = html_escape(setting('login_message_text'));
		}
		// if (strlen(setting('logo')) && file_exists(FCPATH . $logo)) 
		$this->data['logo'] = 'uploads/' . setting('logo');

		$body = $this->load->view('login/login_index', $this->data, TRUE);

		$this->data['body'] =  $body;

		return $this->render();
	}


	function submit()
	{
		log_message('debug', 'login submit');

		$this->load->library('form_validation');
		$this->form_validation->set_rules('username', 'Username', 'required');
		$this->form_validation->set_rules('password', 'Password', 'required');

		// Run validation
		if ($this->form_validation->run() == FALSE) {
			// Validation failed, load login page again
			return $this->index();
		}

		// Form validation for length etc. passed, now see if the credentials are OK in the DB
		// Post values
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		// Now see if we can login
		if ($this->userauth->log_in($username, $password)) {
			// Success! Redirect to control panel
			redirect('');
		} else {
			$this->session->set_flashdata('auth', msgbox('error', 'Usuário e/ou senha incorreto.'));
			return $this->index();
		}
	}
}
