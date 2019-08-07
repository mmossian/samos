<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| MODELO DE GESTION DE CONTRASENIAS
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Ubicacion: application/models
|--------------------------------------------------------------------------
|
|--------------------------------------------------------------------------
| Nombre : Password.php
|--------------------------------------------------------------------------
|
*/
class Password extends CI_Model
{
	/*
		@error
		Descripcion: Id mensaje de error
			Referenciado en language/es/message_lang
		Tipo: object
	*/
	public $error = NULL;

	function __construct()
	{
		parent::__construct();
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Obtiene la contrasena de usuario.

		@access public
		@params int
		@return string
	---------------------------------------------------------------------------
	*/
	function get($id_user)
	{
		$query = $this->db->get_where('users', ['id_user' => $id_user])->row();
		return $query->user_pwd;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Crea una contrasena de usuario.

		@access public
		@params string
		@return string
	---------------------------------------------------------------------------
	*/
	function setPwd($pwd){
		$cost = $this->_setPwdCost($pwd);
		return password_hash($pwd, PASSWORD_DEFAULT, ['cost'=> $cost]);
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Comprueba que la contrasena coincida con un hash.

		@access public
		@params string
		@return boolean
	---------------------------------------------------------------------------
	*/
	function pwdVerify($pwd, $hash, $iduser, $is_employee=FALSE){
		if(password_verify($pwd, $hash)){
			$this->_checkRehash($pwd, $hash, $iduser, $is_employee);
			return TRUE;
		}
		return FALSE;
	}

	function _setPwdCost($pwd){
		$timeTarget = 0.05; // 50 milisegundos
		$coste = 8;
		do {
		    $coste++;
		    $ini = microtime(true);
		    password_hash($pwd, PASSWORD_DEFAULT, ["cost" => $coste]);
		    $end = microtime(true);
		} while (($end - $ini) < $timeTarget);
		return $coste;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: comprueba si el hash facilitado implementa el algoritmo y
			opciones proporcionadas.
			Si no, asume que el hash necesita volver a ser generado.
		@access private
		@params string
		@return void
	---------------------------------------------------------------------------
	*/
	function _checkRehash($pwd, $hash, $iduser, $is_employee){
		$cost = $this->_setPwdCost($pwd);
		if(password_needs_rehash($hash, PASSWORD_DEFAULT, ['cost'=> $cost])){
			// Si es así, crear un nuevo hash y reemplazar el antiguo
			$newHash = password_hash($pwd, PASSWORD_DEFAULT, ['cost'=> $cost]);
			if($is_employee === FALSE)
			{
				$this->db->where('id_user', $iduser);
				$data['user_pwd'] = $newHash;
				$this->db->update('users', $data);
			}
			/*else
			{
				$this->db->where('id_employee', $iduser);
				$data['employee_pwd'] = $newHash;
				$this->db->update('dtr_employees', $data);
			}*/
		}
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Actualiza contrasena de usuario.

		@access public
		@params string
		@return boolean
	---------------------------------------------------------------------------
	*/
	function update($id_user=NULL)
	{
		if(!isset($id_user))
		{
			$id_user = $this->init->user->id_user;
		}
		$user_pwd = $this->get($id_user);
		$curpwd = $this->init->request['data']['curpwd'];
		$newpwd = $this->init->request['data']['newpwd'];
		if($this->pwdVerify($curpwd, $user_pwd, $id_user))
		{
			$data['user_pwd'] = $this->setPwd($newpwd);
			return $this->db
				->where('id_user', $id_user)
				->update('users', $data);
		}
		$this->error = 'message-password-no-match';
		return FALSE;
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Establece las opciones de validacion la contrasenia de usuario.

		@access public
		@params string
		@return array
	---------------------------------------------------------------------------
	*/
	public function setLength()
	{
		$pwdSettings = $this->config->item('dtr-password');
		$validFields = $this->lang->line('dtr-password-length');
		$search = ['%min%', '%max%'];
		$replace = [$pwdSettings['minlength'], $pwdSettings['maxlength']];
		return [
			'min' => $pwdSettings['minlength'],
			'max' => $pwdSettings['maxlength'],
			'msg' => str_replace($search, $replace, $validFields)
		];
	}

	/*
	---------------------------------------------------------------------------
		Descripcion: Resetea la contrasenia de usuario.

		@access public
		@params int
		@return boolean
	---------------------------------------------------------------------------
	*/
	public function reset($id_user, $blockUser=FALSE)
	{
		$len = $this->config->item('dtr-password');
		$pwd = random_string('alnum', $len['minlength']);

		$newpwd = $this->setPwd($pwd);

		$data['user_pwd'] = $newpwd;
		if($blockUser === TRUE)
		{
			$data['user_active'] = 0;
		}
		$this->db->where('id_user', $id_user);
		$this->db->update('users', $data);

		return $pwd;
	}
}