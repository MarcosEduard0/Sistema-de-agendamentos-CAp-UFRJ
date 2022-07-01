<?php
defined('BASEPATH') or exit('No direct script access allowed');

class MY_Controller extends CI_Controller
{


	/**
	 * Dados globais para visualização
	 *
	 * @var array
	 *
	 */
	public $data = array();


	public function __construct()
	{
		parent::__construct();

		$this->output->enable_profiler(config_item('show_profiler') === TRUE);

		$this->load->library('session');
		$this->load->library('form_validation');

		if (get_class($this) !== 'Install' && get_class($this) !== 'Upgrade') {

			if (!config_item('is_installed')) {
				redirect('install');
			}

			$this->load->database();
			$this->load->library('userauth');

			$this->load->library('migration');
			$this->migration->latest();

			$this->lang->load('crbs');
			$this->load->helper('language');

			$tz = setting('timezone');
			if (strlen($tz)) {
				date_default_timezone_set($tz);
			}
		}

		$this->data['scripts'] = array();

		$this->data['scripts'][] = 'assets/js/lib/jquery-3.5.1.min.js';
		$this->data['scripts'][] = 'assets/js/lib/sorttable.js';
		$this->data['scripts'][] = 'assets/js/lib/datepicker.js';
		$this->data['scripts'][] = 'assets/js/lib/es6-promise.auto.min.js';
		$this->data['scripts'][] = 'assets/js/lib/unpoly.min.js';
		$this->data['scripts'][] = 'assets/vendor/jquery/jquery-3.2.1.min.js';
		$this->data['scripts'][] = 'assets/js/popper.js';
		$this->data['scripts'][] = 'assets/js/popper.min.js';
		$this->data['scripts'][] = 'assets/vendor/select2/select2.min.js';
		$this->data['scripts'][] = 'assets/vendor/tilt/tilt.jquery.min.js';
		$this->data['scripts'][] = 'assets/js/bootstrap.js';
		// $this->data['scripts'][] = 'assets/js/bootstrap.min.js';
		$this->data['scripts'][] = 'assets/js/bootstrap.bundle.js';
		$this->data['scripts'][] = 'assets/js/bootstrap.bundle.min.js';
		$this->data['scripts'][] = 'assets/js/jquery.mask.min.js';
		$this->data['scripts'][] = 'assets/js/main.js';
		$this->data['scripts'][] = 'assets/js/functions.js';
		$this->data['scripts'][] = 'assets/js/main.min.js';
		$this->data['scripts'][] = 'assets/js/dataTables.bootstrap4.min.js';



		$this->data['styles'] = array();
		$this->data['styles'][] = 'assets/css/bootstrap.css';
		$this->data['styles'][] = 'assets/css/bootstrap.min.css';
		$this->data['styles'][] = 'assets/css/bootstrap-grid.css';
		$this->data['styles'][] = 'assets/css/bootstrap-grid.min.css';
		$this->data['styles'][] = 'assets/css/bootstrap-reboot.css';
		$this->data['styles'][] = 'assets/css/bootstrap-reboot.min.css';
		$this->data['styles'][] = 'assets/css/style.css';
		$this->data['styles'][] = 'assets/css/unpoly.min.css';
		$this->data['styles'][] = 'assets/fonts/font-awesome-4.7.0/css/font-awesome.min.css';
		$this->data['styles'][] = 'assets/vendor/animate/animate.css';
		$this->data['styles'][] = 'assets/css/dataTables.bootstrap4.min.css';
	}


	public function require_logged_in($msg = TRUE)
	{
		// Verificando o status de loggedin
		if (!$this->userauth->logged_in()) {
			if ($msg) {
				$this->session->set_flashdata('auth', msgbox('error', $this->lang->line('crbs_mustbeloggedin')));
			}
			redirect('login');
		}
	}

	public function require_logged_out()
	{
		// Verificando o status de loggedout
		if ($this->userauth->logged_in()) {
			redirect('../');
		}
	}


	public function require_auth_level($level)
	{
		if (!$this->userauth->is_level($level)) {
			$this->session->set_flashdata('auth', msgbox('error', $this->lang->line('crbs_mustbeadmin')));
			redirect(site_url());
		}
	}


	public function render($view_name = 'layout')
	{
		$this->load->view($view_name, $this->data);
	}
}
