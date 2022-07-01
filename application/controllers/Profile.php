<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();

		$this->require_logged_in();

		// Bibliotecas e modelos necessários
		$this->load->library('email');
		$this->load->model('crud_model');
		$this->load->model('bookings_model');
		$this->load->model('users_model');
		$this->load->model('departments_model');
	}


	function index()
	{
		// Pegar ID do usuário
		$user_id = $this->userauth->user->user_id;

		// Obtenha o agendamento de uma sala, se este usuário possuir um
		$this->data['myroom'] = $this->bookings_model->ByRoomOwner($user_id);
		// Obtenha todas os agendamentos feitos por este usuário (apenas as da equipe)
		$this->data['mybookings'] = $this->bookings_model->ByUser($user_id);
		// Obtenha os totais de agendamentos
		$this->data['total'] = $this->bookings_model->TotalNum($user_id);

		$this->data['title'] = 'Meu Perfil';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('profile/profile_index', $this->data, TRUE);

		return $this->render();
	}


	function edit()
	{
		// Pegar ID do usuário
		$user_id = $this->userauth->user->user_id;
		$department_id = $this->userauth->user->department_id;

		$this->data['user'] = $this->users_model->Get($user_id);
		$this->data['department'] = $this->departments_model->Get($department_id);

		$columns = array(
			'c1' => array(
				'width' => '70%',
				'content' => $this->load->view('profile/profile_edit', $this->data, TRUE),
			),
			'c2' => array(
				'width' => '30%',
				'content' => $this->load->view('profile/profile_edit_side', $this->data, TRUE),
			),
		);

		$this->data['title'] = 'Editar Perfil';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('columns', $columns, TRUE);

		return $this->render();
	}


	function save()
	{
		// Pegar ID do usuário
		$user_id = $this->userauth->user->user_id;

		$this->load->library('form_validation');
		$this->form_validation->set_rules('password1', 'Senha', 'min_length[6]');
		$this->form_validation->set_rules('password2', 'Senha (novamente)', 'min_length[6]|matches[password1]');
		$this->form_validation->set_rules('email', 'Email address', 'max_length[255]|valid_email');
		$this->form_validation->set_rules('firstname', 'First name', 'max_length[20]');
		$this->form_validation->set_rules('lastname', 'Last name', 'max_length[20]');
		$this->form_validation->set_rules('displayname', 'Display name', 'max_length[20]');
		$this->form_validation->set_rules('extension', 'Extension', 'max_length[10]');

		if ($this->form_validation->run() == FALSE) {
			// Falha na validação
			return $this->edit();
		}

		// Validação aprovada!
		$data = array(
			'email' => $this->input->post('email'),
			'firstname' => $this->input->post('firstname'),
			'lastname' => $this->input->post('lastname'),
			'displayname' => $this->input->post('displayname'),
			'ext' => $this->input->post('ext'),
		);

		// Somente atualize a senha se uma foi fornecida
		if ($this->input->post('password1') && $this->input->post('password2')) {
			$data['password'] = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);
		}

		// Atualize a variável de sessão com displayname
		$this->session->set_userdata('displayname', $data['displayname']);

		// Agora chame o banco de dados para atualizar o usuário e carregue a mensagem apropriada para o valor de retorno
		if (!$this->crud_model->Edit('users', 'user_id', $user_id, $data)) {
			$flashmsg = msgbox('error', 'Ocorreu um erro no banco de dados ao atualizar seus detalhes.');
		} else {
			$flashmsg = msgbox('info', 'Perfil atualizados com sucesso.');
		}

		//Voltar ao inicio
		$this->session->set_flashdata('saved', $flashmsg);
		redirect('/');
	}
}
