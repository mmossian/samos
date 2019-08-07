<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Libreria de gestion de rutas
|--------------------------------------------------------------------------
|
*/
class App_router
{
	/*
		@CI
		Descripcion: Nueva instancia de la aplicacion
		Tipo: string
	*/
	protected $CI = NULL;

	/*
		@CI
		Descripcion: Rutas asociadas a un archivo de configuracion
		Tipo: array
	*/
	public $appRoutes = NULL;

	public function __construct()
	{
		$this->CI =& get_instance();
	}

	/************************************************
		Descripcion: Establece la ruta de una vista
		@visibility public
		@params string
		@return string
	************************************************/
	public function route($route)
	{
		$route = str_replace('%lang%', $this->CI->init->appLang, $route);
		return substr($route, 0, 1) == '#' ? $route : $this->CI->init->baseUrl.'index.php/'.$route;
	}

	/************************************************
		Descripcion: Establece la ruta de archivos css y js
		@visibility public
		@params string
		@return string
	************************************************/
	public function asset($route)
	{
		return $this->CI->init->baseUrl.'assets/'.$route;
	}

	/************************************************
		Descripcion: Establece las rutas de archivos definidos en application/config/files
		@visibility public
		@params array
		@return array
	************************************************/
	public function setRoutes($file)
	{
		$routes = [];
		$this->CI->config->load('files/'.$file);
		foreach ($this->CI->config->item('app-files')['views'] as $view)
		{
			$routes['views'][] = str_replace('%lang%', $this->CI->init->appLang, $view);
		}
		foreach ($this->CI->config->item('app-files')['css'] as $css)
		{
			$routes['css'][] = $this->asset($css);
		}
		foreach ($this->CI->config->item('app-files')['js'] as $js)
		{
			$routes['js'][] = $this->asset($js);
		}
		if(isset($this->CI->config->item('app-files')['params']))
		{
			foreach ($this->CI->config->item('app-files')['params'] as $params)
			{
				$routes['params'][] = $params;
			}
		}
		if(isset($this->CI->config->item('app-files')['sources']))
		{
			foreach ($this->CI->config->item('app-files')['sources'] as $sources)
			{
				$routes['sources'][] = str_replace('%lang%', $this->CI->init->appLang, $sources);
			}
		}
		if(count($this->CI->config->item('app-files')['langs']) > 0)
		{
			foreach ($this->CI->config->item('app-files')['langs'] as $lang)
			{
				$this->CI->lang->load($lang, $this->CI->init->appLang);
			}
		}
		$this->appRoutes = $routes;
	}

	/************************************************
		Descripcion: Redireccion de rutas
		@visibility public
		@params array
		@return array
	************************************************/
	public function redirectTo($route=NULL, array $params=NULL)
	{
		$param = isset($params) ? implode('/', $params) : '';
		if(isset($route))
		{
			$route = !empty($param) ? $route.'/'.$param : $route;
			redirect($this->CI->init->baseUrl.'index.php/'.$route, 'refresh');
		}
		else
		{
			if(!isset($_SESSION[$this->CI->init->sessionNames['user']]))
			{
				redirect($this->CI->init->baseUrl, 'refresh');
			}
			else
			{
				$role = ucwords($_SESSION[$this->CI->init->sessionNames['user']]['user_role']);
				$first = $_SESSION[$this->CI->init->sessionNames['user']]['user_first'];
				$dir = $first == 1 ? "index.php/personaldata" : "index.php/{$role}home" ;
				redirect($this->CI->init->baseUrl.$dir, 'refresh');
			}
		}
	}
}