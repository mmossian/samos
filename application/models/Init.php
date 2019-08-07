<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Modelo de inicializacion de la aplicacion
|--------------------------------------------------------------------------
|
*/
class Init extends CI_Model
{
	/*
		@user
		Descripcion: Usuario activo
		Tipo: object
	*/
	public $user = NULL;

	/*
		@appName
		Descripcion: Nombre de la aplicacion
		Tipo: string
	*/
	public $appName = NULL;

	/*
		@baseUrl
		Descripcion: Ruta base
		Tipo: string
	*/
	public $baseUrl = NULL;

	/*
		@curUrl
		Descripcion: Ruta actual
		Tipo: string
	*/
	public $curUrl = NULL;

	/*
		@appLang
		Descripcion: Idioma de la aplicacion.
			Por defecto es espanol
		Tipo: string
	*/
	public $appLang = 'es';

	/*
		@appLogo
		Descripcion: Logo de la aplicacion.
		Tipo: string or null
	*/
	public $appLogo = NULL;

	/*
		@sessionNames
		Descripcion: Nombres de las variables de sesion.
		Tipo: array
	*/
	public $sessionNames = [];

	/*
		@cookieName
		Descripcion: Nombres de las cookies.
		Tipo: array
	*/
	public $cookieName = [];

	/*
		@appMessage
		Descripcion: Mensajes de la aplicacion.
		Tipo: string
	*/
	public $appMessage = NULL;

	/*
		@request
		Descripcion: Cabeceras y datos.
		Tipo: string
	*/
	public $request = NULL;

	public function __construct()
	{
		parent::__construct();
		//ini_set('mysql.trace_mode', 0);
		// Chequeo de ip bloqueada
		$this->load->model('ip');
		// Modelo de obtencion usuarios
		$this->load->model('Users/getUsers');
		// Establece politicas de seguridad
		$this->csp->send();

		$this->appName = $this->config->item('app-name');
		$this->baseUrl = base_url();
		$this->curUrl = current_url();

		$this->_setSessionNames();
		$this->_setCookieNames();
		$this->_setRequest();
		$this->_setUser();
		$this->_setAppLang();

		$this->_setAppLogo();
	}

	/************************************************
		Descripcion: Establece los nombres de las variables de sesion
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setSessionNames()
	{
		// Usuario logueado
		$this->sessionNames['user'] = $this->appName.'-USER';
		// Mensajes
		$this->sessionNames['message'] = $this->appName.'-MESSAGE';
		// Toast Mensajes (Requeridos por semantic)
		$this->sessionNames['toast'] = $this->appName.'-TOAST';
		// Datos pasados via post o get
		$this->sessionNames['request'] = $this->appName.'-REQUEST';
	}

	/************************************************
		Descripcion: Establece los nombres de las cookies
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setCookieNames()
	{
		$this->cookieName['visitor'] = $this->appName.'-visitor';
		$this->cookieName['is-user'] = $this->appName.'-is-user';
	}

	/************************************************
		Descripcion: Establece el logo de la aplicacion
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setAppLogo()
	{
		$dir = 'assets/imgs/app-logo/';
		$logo = get_filenames(FCPATH.$dir);
		if(isset($logo[0]))
		{
			$this->appLogo = $this->baseUrl.$dir.$logo[0];
		}
	}

	/************************************************
		Descripcion: Establece las cabeceras, metodo y datos enviados
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setRequest()
	{
		$this->request['headers'] = $this->input->request_headers(TRUE);
		$this->request['method'] = $this->input->method();
		if($this->request['method'] === 'post')
		{
			$this->request['data'] = $this->security->xss_clean($this->input->post(NULL, TRUE));
		}
		else
		{
			$this->request['data'] = $this->security->xss_clean($this->input->get(NULL, TRUE));
		}
	}

	/************************************************
		Descripcion: Carga el idioma del usuario logueado
			y levanta los archivos de idioma por defecto
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setAppLang()
	{
		if(isset($_SESSION[$this->sessionNames['user']]))
		{
			$this->appLang = $this->user->user_lang;
		}
		$this->lang->load('common', $this->appLang);
		$this->lang->load('log', $this->appLang);
		$this->lang->load('message', $this->appLang);
		$this->lang->load('form_validation', $this->appLang);
	}

	/************************************************
		Descripcion: Establece el usuario logueado
		@visibility private
		@params void
		@return void
	************************************************/
	private function _setUser()
	{
		if(isset($_SESSION[$this->sessionNames['user']]))
		{
			// Cheque que el usuario logueado este activo
			if($_SESSION[$this->sessionNames['user']]['user_active'] == 0 AND $_SESSION[$this->sessionNames['user']]['user_first'] == 0)
			{
				session_destroy();
				redirect($this->baseUrl, 'refresh');
			}
			$this->user = $this->db
				->join('users_settings', 'users_settings.id_user = users.id_user', 'inner')
				->join('emails', 'users.id_email = emails.id_email', 'inner')
				->join('users_data', 'users_data.id_user = users.id_user', 'inner')
				->join('address', 'users_data.id_address = address.id_address', 'inner')
				->join('phones', 'users_data.id_phone = phones.id_phone', 'left')
				->join('companies', 'users_data.id_company = companies.id_company', 'left')
				->where('users.id_user', $_SESSION[$this->sessionNames['user']]['id_user'])
				->get('users')
				->row();

			$this->user->user_pwd = '********';
			$this->user->fullname = $this->user->first_name.' '.$this->user->last_name;
			$this->user->dtf = $this->user->user_dformat.' '.$this->user->user_tformat;
			$this->user->sess_start = mdate($this->user->dtf, $_SESSION[$this->sessionNames['user']]['sess_start']);
			$this->user->ip_address = $_SESSION[$this->sessionNames['user']]['ip_address'];
			$this->user->dir = "assets/users/{$this->user->id_user}";

			$image = get_filenames(FCPATH.$this->user->dir.'/me');
			if(count($image) > 0)
			{
				$img = $image[0];
				$this->user->image = $this->baseUrl.$this->user->dir.'/me/'.$img;
			}
			else
			{
				$this->user->image = $this->baseUrl.'assets/imgs/user-anonymus.png';
			}
		}
	}

	public function createDirStruct($id_user)
	{
		$dir = FCPATH."assets/users/{$id_user}";
		return mkdir($dir) AND mkdir("{$dir}/me") AND mkdir("{$dir}/temp") AND mkdir("{$dir}/docs");
	}
}