<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Controlador validacion de registro de usuario
|--------------------------------------------------------------------------
|
*/
class ValidateRegister extends CI_Controller
{
	/*
		@data
		Descripcion: Datos pasados a la vista
		Tipo: array
	*/
	private $data = [];

	public function __construct()
	{
		parent::__construct();
		$this->ip->isBlocked();
		if(isset($_SESSION[$this->init->sessionNames['user']]))
		{
			$this->app_router->redirectTo();
		}
		$this->load->model('encrypt');
		$this->lang->load('validation/register', $this->init->appLang);
	}

	/************************************************
		Descripcion: Muestra la pagina de validacion se el periodo no ha expirado
		@visibility public
		@params string | string
		@return void
	************************************************/
	public function index($id_user, $hash)
	{

		$this->app_router->setRoutes('config.register-validation');

		$user_valid = $this->db->get_where(
			'users_validation',
			[
				'id_user' => $this->encrypt->decode($id_user),
				'token' => $this->encrypt->decode($hash)
			]
		)->row();
		if($user_valid)
		{
			$expiration = mysql_to_unix($user_valid->expiration);
			if($expiration < now())
			{
				$this->load->model('Users/register');
				$this->register->remove($user_valid->id_user);
				$this->app_router->redirectTo('expiredregistration');
			}
			else
			{
				$user = $this->getUsers->get($user_valid->id_user);
				$data['interface'] = 'register';
				$data['activePage'] = 'home';
				$data['csrf'] = [
					'name' => $this->security->get_csrf_token_name(),
					'hash' => $this->security->get_csrf_hash()
				];
				$data['name'] = $user->first_name;
				$data['id_user'] = $id_user;
				$data['token'] = $hash;
				$PwdRules =  read_file(APPPATH."language/{$this->init->appLang}/validation/password.json");
				$data['jsParams'][] = "var PwdRules = {$PwdRules};";

				$this->load->view('index', $data);
			}
		}
		else
		{
			$this->app_router->redirectTo('expiredregistration');
		}
	}

	/************************************************
		Descripcion: Valida la contrasenia del usuario registrado y lo activa
		@visibility public
		@params void
		@return void
	************************************************/
	public function validate()
	{
		$this->lang->load('validation/password', $this->init->appLang);

		$data = $this->init->request['data'];
		$this->form_validation->set_rules($this->lang->line('rules'));
		if ($this->form_validation->run() == FALSE)
		{
			$message = $this->lang->line('message-general-error');
			$message['message'] = str_replace('%errors%', validation_errors(), $message['message']);
			$this->session->set_flashdata($this->init->sessionNames['message'], $message);
			$this->app_router->redirectTo('validateregistration', [ $data['id_user'], $data['token'] ]);
		}
		else
		{
			$this->load->model('password');

			// Actualiza la contrasenia
			$newpwd = $this->password->setPwd($data['newpwd']);
			$d['user_pwd'] = $newpwd;
			$d['user_active'] = 1;
			$id_user = $this->encrypt->decode($data['id_user']);
			$this->db->where('id_user', $id_user);
			$this->db->update('users', $d);
			// Elimina el usuario de la tabla users_validation
			$this->db->delete('users_validation', ['id_user' => $id_user]);
			$this->session->set_flashdata($this->init->sessionNames['toast'], $this->lang->line('message-validation-ok'));
			// Agrega el mensaje de log
			$this->applog->additionalData = ['id_user' => $id_user];
			$this->applog->set('auth', $this->lang->line('user-validation-ok'));

			$this->app_router->redirectTo('validationsuccess');
		}
	}

	/************************************************
		Descripcion: Muestra la pagina de validacion expirado
		@visibility public
		@params void
		@return void
	************************************************/
	public function expired()
	{
		$this->app_router->setRoutes('config.register-expired');
		$data['interface'] = 'public';
		$data['activePage'] = 'home';
		$this->load->view('index', $data);
	}

	/************************************************
		Descripcion: Muestra la pagina de validacion exitosa
		@visibility public
		@params void
		@return void
	************************************************/
	public function success()
	{
		$this->app_router->setRoutes('config.register-success');
		$data['interface'] = 'public';
		$data['activePage'] = 'home';
		$this->load->view('index', $data);
	}
}