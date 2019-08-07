<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE VALIDACION DE USUARIOS
|--------------------------------------------------------------------------
|
|
*/

class Validate extends CI_Model
{
	/*
		@status
		Descripcion: estable el estado del usuario al intentar loguearse
			valores:
				'ok' (El usuario se ha logueado correctament)
				'user-no-active' (El usuario no se encuentra activo)
				'error' (Error de validacion)
		Tipo: string
	*/
	public $status = 'ok';

	/*
		@user
		Descripcion: estable el usuario activo
		Tipo: object
	*/
	public $user = NULL;

	function __construct()
	{
		parent::__construct();
		$this->load->model('password');
	}

	/*
	|--------------------------------------------------------------------------
	|	Valida un usuario registrado
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	public function auth()
	{
		$data = $this->init->request['data'];
		$user_email = $data['user_email'];
		$user = $this->getUsers->get(NULL, $user_email);
		if($user)
		{
			$this->user = $user;
			$pwd = $data['user_pwd'];
			if($user->user_active == 1)
			{
				if($this->password->pwdVerify($pwd, $user->user_pwd, $user->id_user))
				{
					$dir = FCPATH."assets/users/{$user->id_user}";
					// Crea la estructura de directorios del usuario si no existe
					if(!is_dir($dir))
					{
						$this->init->createDirStruct($user->id_user);
					}
					// Destruye el cookie de visitante y crea el cookie de usuario

					if(isset($_COOKIE[$this->init->cookieName['visitor']]))
					{
						delete_cookie($this->init->cookieName['visitor']);
					}
					if(!isset($_COOKIE[$this->init->cookieName['is-user']]))
					{
						set_cookie(
							$this->init->cookieName['is-user'], // Nombre
							1, // Valor
							30*24*3600 // Expiracion 1 mes
						);
					}
					// Establece los datos de sesion
					$_SESSION[$this->init->sessionNames['user']]['id_user'] = $user->id_user;
					$_SESSION[$this->init->sessionNames['user']]['user_role'] = $user->user_role;
					$_SESSION[$this->init->sessionNames['user']]['user_first'] = $user->user_first;
					$_SESSION[$this->init->sessionNames['user']]['user_active'] = $user->user_active;
					$_SESSION[$this->init->sessionNames['user']]['sess_start'] = now();
					$_SESSION[$this->init->sessionNames['user']]['ip_address'] = $this->input->ip_address();
					return;
				}
				$this->status = 'error';
			}
			else
			{
				$this->status = 'user-no-active';
			}
		}
		else
		{
			$this->status = 'error';
		}
	}
}