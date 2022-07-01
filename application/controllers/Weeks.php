<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Weeks extends MY_Controller
{
	public $WeeksCount = 0;

	public function __construct()
	{
		parent::__construct();

		$this->require_logged_in();
		$this->require_auth_level(ADMINISTRADOR);

		$this->load->model('crud_model');
		$this->load->model('holidays_model');
		$this->load->model('weeks_model');
	}

	function index()
	{

		$this->data['weeks'] = $this->weeks_model->Get();
		$this->data['cal'] = NULL;
		$this->data['academicyear'] = $this->weeks_model->GetAcademicYear();

		if (!$this->data['academicyear']) {
			$this->data['body'] = msgbox('aviso ', "Configure primeiro o seu ano letivo.");
		} else {
			$this->data['body'] = '';
		}

		$this->data['body'] .= $this->load->view('weeks/weeks_index', $this->data, TRUE);

		$this->data['title'] = 'Ciclo da semana do calendário';
		$this->data['showtitle'] = $this->data['title'];

		return $this->render();
	}

	/**
	 * Função Controller para lidar com a página Adicionar
	 *
	 */
	function add()
	{
		$this->data['academicyear'] = $this->weeks_model->GetAcademicYear();

		if (!$this->data['academicyear']) {
			redirect('weeks');
		}

		$this->data['weeks'] = $this->weeks_model->Get();
		$this->data['mondays'] = $this->weeks_model->GetMondays();
		$this->data['weekscount'] = (is_array($this->data['weeks']) ? count($this->data['weeks']) : 0);

		// Carregar View
		$this->data['title'] = 'Nova Semana';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('weeks/weeks_add', $this->data, TRUE);

		return $this->render();
	}

	/**
	 * Controller function to handle the Edit page
	 *
	 */
	function edit($id = NULL)
	{
		$this->data['week'] = $this->weeks_model->Get($id);

		if (empty($this->data['week'])) {
			show_404();
		}

		$this->data['weeks'] = $this->weeks_model->Get(NULL);
		$this->data['mondays'] = $this->weeks_model->GetMondays();
		$this->data['academicyear'] = $this->weeks_model->GetAcademicYear();
		$this->data['weekscount'] = count($this->data['weeks']);

		$this->data['title'] = 'Editar Semana';
		$this->data['showtitle'] = $this->data['title'];

		$this->data['body'] = $this->load->view('weeks/weeks_add', $this->data, TRUE);

		return $this->render();
	}

	function save()
	{
		// Pegar ID do form
		$week_id = $this->input->post('week_id');

		$this->load->library('form_validation');

		$this->form_validation->set_rules('week_id', 'ID', 'integer');
		$this->form_validation->set_rules('name', 'Name', 'min_length[1]|max_length[20]');
		$this->form_validation->set_rules('bgcol', 'Background colour', 'min_length[6]|max_length[7]|callback__is_valid_colour');
		$this->form_validation->set_rules('fgcol', 'Foreground colour', 'min_length[6]|max_length[7]|callback__is_valid_colour');

		if ($this->form_validation->run() == FALSE) {
			return (empty($week_id) ? $this->add() : $this->edit($week_id));
		}

		// Validação Sucesso!
		$week_data = array(
			'name' => $this->input->post('name'),
			'bgcol' => $this->_makecol($this->input->post('bgcol')),
			'fgcol' => $this->_makecol($this->input->post('fgcol')),
			'icon' => '',
		);

		// Agora veja se estamos editando ou adicionando
		if (empty($week_id)) {
			// Sem ID, adicionando novo registro
			$week_id = $this->weeks_model->Add($week_data);
			if ($week_id) {
				$flashmsg = msgbox('info', sprintf($this->lang->line('crbs_action_added'), $week_data['name']));
			} else {
				$flashmsg = msgbox('error', sprintf($this->lang->line('crbs_action_dberror'), 'adding'));
			}
		} else {
			// Temos um ID, atualizando o registro existente
			if ($this->weeks_model->Edit($week_id, $week_data)) {
				$flashmsg = msgbox('info', sprintf($this->lang->line('crbs_action_saved'), $week_data['name']));
			} else {
				$flashmsg = msgbox('error', sprintf($this->lang->line('crbs_action_dberror'), 'editing'));
			}
		}
		$this->weeks_model->UpdateMondays($week_id, $this->input->post('dates'));

		$this->session->set_flashdata('saved', $flashmsg);
		redirect('weeks');
	}

	/**
	 * Deletar a semana
	 *
	 */
	function delete($id = NULL)
	{
		// Verifique se um formulário foi enviado; se não - mostre para pedir confirmação ao usuário
		if ($this->input->post('id')) {
			// O formulário foi enviado (portanto, o valor POST existe)
			// Chame a função do modelo para excluir
			$this->weeks_model->delete($this->input->post('id'));
			$this->session->set_flashdata('saved', msgbox('info', $this->lang->line('crbs_action_deleted')));
			redirect('weeks');
		}
		// Initialise page
		$this->data['action'] = 'weeks/delete';
		$this->data['id'] = $id;
		$this->data['cancel'] = 'weeks';
		$this->data['text'] = 'Se você excluir esta semana, <strong> todas as reservas recorrentes </strong> anexadas a esta semana não estarão mais visíveis.';

		$row = $this->weeks_model->Get($id);
		$this->data['title'] = 'Deletar Semana (' . html_escape($row->name) . ')';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('partials/deleteconfirm', $this->data, TRUE);

		return $this->render();
	}

	function academicyear()
	{
		$this->data['academicyear'] = $this->weeks_model->GetAcademicYear();

		if (!$this->data['academicyear']) {
			$this->data['academicyear'] = new Stdclass();
			$this->data['academicyear']->date_start = date("Y-m-d");
			$this->data['academicyear']->date_end = date("Y-m-d", strtotime("+1 Year", strtotime(date("Y-m-d"))));
		}

		$this->data['title'] = 'Ano Letivo';
		$this->data['showtitle'] = $this->data['title'];
		$this->data['body'] = $this->load->view('weeks/weeks_academicyear', $this->data, True);

		return $this->render();
	}

	function saveacademicyear()
	{
		$this->load->library('form_validation');

		$this->form_validation->set_rules('date_start', 'Start date', 'required|min_length[8]|max_length[10]');
		$this->form_validation->set_rules('date_end', 'End date', 'required|min_length[8]|max_length[10]');

		if ($this->form_validation->run() == FALSE) {
			return $this->academicyear();
		}

		$start_date = explode('-', $this->input->post('date_start'));
		$end_date = explode('-', $this->input->post('date_end'));
		$year_data = array(
			'date_start' => sprintf("%s-%s-%s", $start_date[0], $start_date[1], $start_date[2]),
			'date_end' => sprintf("%s-%s-%s", $end_date[0], $end_date[1], $end_date[2]),
		);

		$this->weeks_model->SaveAcademicYear($year_data);

		$this->session->set_flashdata('saved', msgbox('info', 'As datas do ano letivo foram atualizadas.'));

		redirect('weeks/academicyear');
	}

	function _is_valid_colour($colour)
	{
		$hex = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F');
		#print_r($hex);
		// Remova o hash
		$colour = strtoupper(str_replace('#', '', $colour));
		// Certifique-se de que temos 6 dígitos
		if (strlen($colour) == 6) {
			$ret = true;
			for ($i = 0; $i < strlen($colour); $i++) {
				if (!in_array($colour[$i], $hex)) {
					$this->form_validation->set_message('_is_valid_colour', $this->lang->line('colour_invalid'));
					return false;
					$ret = false;
				}
			}
		} else {
			$this->form_validation->set_message('_is_valid_colour', $this->lang->line('colour_invalid'));
			$ret = false;
		}
		return $ret;
	}

	function _makecol($colour)
	{
		return strtoupper(str_replace('#', '', $colour));
	}
}
