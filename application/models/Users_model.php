<?php
defined('BASEPATH') OR exit('No direct script access allowed');


class Users_model extends CI_Model
{


	public function __construct()
	{
		parent::__construct();
	}


	/**
	 * Obtenha um usuário ativo/habilitado com o nome de usuário fornecido.
	 *
	 * @param  string $username usuário
	 * @return  mixed FALSE em caso de falha ou objeto usuário em caso de sucesso.
	 *
	 */
	public function get_by_username($username, $require_enabled = TRUE)
	{
		if ( ! strlen($username)) {
			return FALSE;
		}

		$where = [
			'username' => $username,
		];

		if ($require_enabled) {
			$where['enabled'] = 1;
		}

		$query = $this->db->get_where('users', $where, 1);

		if ($query->num_rows() === 1) {
			return $query->row();
		}

		return FALSE;
	}


	/**
	 * Obtenha um usuário ativo/habilitado pelo ID fornecido.
	 *
	 * @param  int $id ID do usuário
	 * @return  mixed FALSE em caso de falha ou objeto usuário em caso de sucesso.
	 *
	 */
	public function get_by_id($id)
	{
		$where = [
			'user_id' => $id,
			'enabled' => 1,
		];

		$query = $this->db->get_where('users', $where, 1);

		if ($query->num_rows() === 1) {
			return $query->row();
		}

		return FALSE;
	}


	/**
	 * Defina uma senha de usuário.
	 *
	 * @param  mixed $Id do usuário ou objeto usuário.
	 * @param  string $password Nova senha a ser definida.
	 *
	 */
	public function set_password($user, $password)
	{
		if (is_object($user)) {
			$user_id = $user->user_id;
		} elseif (is_numeric($user)) {
			$user_id = $user;
		}

		if ( ! isset($user_id)) {
			return FALSE;
		}

		$user_data = [
			'password' => password_hash($password, PASSWORD_DEFAULT),
		];

		$where = [ 'user_id' => $user_id ];

		return $this->db->update('users', $user_data, $where);
	}

	/**
	 * Desabilitar um usuário
	 *
	 * @param  mixed $Id do usuário ou objeto usuário.
	 *
	 */
	public function set_disabled($user)
	{
		if (is_object($user)) {
			$user_id = $user->user_id;
		} elseif (is_numeric($user)) {
			$user_id = $user;
		}

		if ( ! isset($user_id)) {
			return FALSE;
		}

		$user_data = [
			'enabled' => 0,
		];

		$where = [ 'user_id' => $user_id ];

		return $this->db->update('users', $user_data, $where);
	}


	public function insert($user_data = [])
	{
		$insert = $this->db->insert('users', $user_data);
		return ($insert ? $this->db->insert_id() : FALSE);
	}


	public function update($user_data = [], $where)
	{
		if ( ! is_array($where)) {
			$where = ['user_id' => (int) $where];
		}

		return $this->db->update('users', $user_data, $where);
	}


	function Get($user_id = NULL, $pp = 10, $start = 0)
	{
		if ($user_id == NULL) {
			return $this->crud_model->Get('users', NULL, NULL, NULL, 'enabled asc, username asc', $pp, $start);
		} else {
			return $this->crud_model->Get('users', 'user_id', $user_id);
		}
	}


	function Add($data){

		$username = $data['username'];

		$sql = "SELECT user_id FROM users WHERE username='$username' LIMIT 1";
		$query = $this->db->query($sql);

		if ($query->num_rows() == 1) {
			return 'username_exists';
		}else{
			$query = $this->db->insert('users', $data);
			return ($query ? $this->db->insert_id() : $query);
		}
	}


	function Edit($user_id, $data)
	{
		$this->db->where('user_id', $user_id);
		$result = $this->db->update('users', $data);
		return ($result ? $user_id : FALSE);
	}


	/**
	 * Excluir um usuário
	 *
	 * @param   int   $id   ID do usuário a ser excluído
	 *
	 */
	function Delete($id)
	{
		$this->db->where('user_id', $id);
		$this->db->delete('bookings');

		$set = array('user_id' => 0);
		$where = array('user_id' => $id);
		$this->db->update('rooms', $set, $where);

		$this->db->where('user_id', $id);
		return $this->db->delete('users');
	}


}
