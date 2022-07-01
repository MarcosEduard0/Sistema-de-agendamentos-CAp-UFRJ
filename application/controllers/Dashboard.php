<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->require_logged_in(FALSE);


		$this->load->model('bookings_model');
		$this->load->model('users_model');
	}


	/**
	 * Dashboard
	 *
	 */
	public function index()
	{

		// Get User ID
		$user_id = $this->userauth->user->user_id;

		// Obter agendamentos de um sala, se este usuário possuir um
		$this->data['myroom'] = $this->bookings_model->ByRoomOwner($user_id);
		// Obtenha todas os agendamentos feitos por este usuário (apenas as da equipe)
		$this->data['mybookings'] = $this->bookings_model->ByUser($user_id);
		// Obter total
		$this->data['total'] = $this->bookings_model->TotalNum($user_id);


		// $this->data['showtitle'] = 'Início';
		$this->data['title'] = setting('name');

		$this->data['body'] = '';

		$this->data['body'] .= $this->session->flashdata('auth');
		$this->data['body'] .= $this->load->view('dashboard/index', $this->data, TRUE);




		return $this->render();
	}
}
