<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth_local
{


	protected $CI;

	protected $errors = [];


	public function __construct($config = [])
	{
		$this->CI = &get_instance();

		$this->CI->load->model('users_model');
		$this->CI->load->model('settings_model');

		if (!empty($config)) {
			$this->init($config);
		}
	}


	public function init($config)
	{
		$this->errors = [];

		foreach ($config as $key => $val) {
			if (isset($this->$key)) {
				$this->$key = $val;
			}
		}

		return $this;
	}




	/**
	 * Check a given username and password against the local users table.
	 *
	 * @param string $username
	 * @param string $password
	 * @return mixed FALSE on failure or DB User row on success.
	 *
	 */
	public function authenticate($username = '', $password = '')
	{
		return $this->verify($username, $password);
	}


	/**
	 * Verifique se um determinado nome de usuário e senha são válidos.
	 *
	 * @param string $username
	 * @param string $password
	 * @return mixed FALSE em caso de falha ou o objeto usuário do banco de dados em caso de sucesso.
	 *
	 */
	public function verify($username, $password)
	{
		$username = trim($username);

		if (!strlen($username) || !strlen($password)) {
			$this->errors[] = 'sem_usuario_ou_sem_senha';
			return FALSE;
		}

		$user = $this->CI->users_model->get_by_username($username, FALSE);

		if (!$user) {
			$this->errors[] = 'usuario_nao_encontrado';
			return FALSE;
		}

		$agora = date("Y-m-d");
		$created = explode(' ', $user->created);
		$created = $created[0];

		//Pegando o numero de meses definido para o vencimento de uma conta
		$num = $this->CI->settings_model->get('validity');
		if ($num != '0') {
			$created = date('Y-m-d', strtotime($num . ' months', strtotime($created)));

			//Ultrapassando o certo numero de meses de ativação de conta e caso nao senha adm a conta sera desativada.
			if (strtotime($created) < strtotime($agora) && $user->authlevel == 2) {
				$this->CI->users_model->set_disabled($user->user_id);
				$user->enabled = 0;
			}
		}

		if ($user->enabled == 0) {
			$this->errors[] = 'usuario_nao_habilitado';
			return FALSE;
		}

		// Controlador para determinar se a senha deve ser atualizada, se bem-sucedida.
		$upgrade_password = FALSE;

		$password_hash = $user->password;

		// Verifique o formato de senha antigo
		if (substr($password_hash, 0, 5) === 'sha1:') {
			// o valor da senha do usuário é password_hash () do antigo valor sha1
			$password_hash = substr($password_hash, 5);
			$upgrade_password = TRUE;
			$verified = password_verify(sha1($password), $password_hash);
		} else {
			// O valor da senha do usuário é a saída direta de password_hash () de sua senha.
			$verified = password_verify($password, $password_hash);
		}

		if (!$verified) {
			$this->errors[] = 'senha_incorreta';
			return FALSE;
		}

		// Se precisarmos atualizar sua senha para um novo armazenamento sem sha1, faça isso agora
		if ($upgrade_password) {
			$this->CI->users_model->set_password($user->user_id, $password);
		}

		return $this->CI->users_model->get_by_id($user->user_id);
	}


	/**
	 * Get any errors that have been set.
	 *
	 * @return array
	 *
	 */
	public function get_errors()
	{
		return $this->errors;
	}
}
