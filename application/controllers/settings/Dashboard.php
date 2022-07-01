<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends MY_Controller
{


	public function __construct()
	{
		parent::__construct();
		$this->require_auth_level(ADMINISTRADOR);
		redirect('settings/general');
	}


	public function index()
	{
	}
}
