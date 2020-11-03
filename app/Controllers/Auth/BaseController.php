<?php
namespace App\Controllers\Auth;

/**
* Class BaseController
*
* BaseController provides a convenient place for loading components
* and performing functions that are needed by all your controllers.
* Extend this class in any new controllers:
*     class Home extends BaseController
*
* For security be sure to declare any new methods as protected or private.
*
* @package CodeIgniter
*/

use CodeIgniter\Controller;

class BaseController extends Controller
{

	/**
	* An array of helpers to be loaded automatically upon
	* class instantiation. These helpers will be available
	* to all other controllers that extend BaseController.
	*
	* @var array
	*/
	protected $helpers = [];
	protected $data = [];

	/**
	* Constructor.
	*/
	public function initController(\CodeIgniter\HTTP\RequestInterface $request, \CodeIgniter\HTTP\ResponseInterface $response, \Psr\Log\LoggerInterface $logger)
	{
		// Do Not Edit This Line
		parent::initController($request, $response, $logger);

		//--------------------------------------------------------------------
		// Preload any models, libraries, etc, here.
		//--------------------------------------------------------------------
		// E.g.:
		$this->session = \Config\Services::session();
		$this->data['AppName'] = APP_NAME;
		$this->data['BaseUrl'] = base_url();
		$this->data['CurUrl'] = current_url();
		$this->data['MenuItems'] = \Config\Services::setMenu('public');
		$this->data['AssetsUrl'] = \Config\Services::asset();
		$this->data['AppLogo'] = \Config\Services::logo();
		$this->data['CsrfMeta'] = csrf_meta();
		$this->data['CsrfField'] = csrf_field();
		$this->data['Buttons'] = (array) lang('Button.buttons');

		if($this->session->has(TOAST_MESSAGE))
		{
			$this->data['ToastMessage'] = $this->session->get(TOAST_MESSAGE);
		}
		if($this->session->has(INLINE_MESSAGE))
		{
			$this->data['InlineMessage'] = $this->session->get(INLINE_MESSAGE);
		}
		if($this->session->has(REQUEST_DATA))
		{
			$this->data['Old'] = $this->session->get(REQUEST_DATA);
		}
	}

}
