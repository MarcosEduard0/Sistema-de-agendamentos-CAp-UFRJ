<?php
defined('BASEPATH') or exit('No direct script access allowed');

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
		$this->form_validation->set_rules('username', 'Usuário', 'required');
		$this->form_validation->set_rules('password', 'Senha', 'required');

		// Executar validação
		if ($this->form_validation->run() == FALSE) {
			// A validação falhou, carregue a página de login novamente
			return $this->index();
		}

		// A validação de preenchimento passou, agora veja se as credenciais estão no banco de dados
		// Pegar os valores
		$username = $this->input->post('username');
		$password = $this->input->post('password');

		// Agora veja se podemos entrar
		if ($this->userauth->log_in($username, $password)) {
			// Sucesso! Redirecionar para o painel inicial
			redirect('');
		} else {
			$this->session->set_flashdata('auth', msgbox('error', 'Usuário e/ou senha incorretos.'));
			return $this->index();
		}
	}
}
