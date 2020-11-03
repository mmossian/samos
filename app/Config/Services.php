<?php namespace Config;

use CodeIgniter\Config\Services as CoreServices;

/**
 * Services Configuration file.
 *
 * Services are simply other classes/libraries that the system uses
 * to do its job. This is used by CodeIgniter to allow the core of the
 * framework to be swapped out easily without affecting the usage within
 * the rest of your application.
 *
 * This file holds any application-specific services, or service overrides
 * that you might need. An example has been included with the general
 * method format you should use for your service methods. For more examples,
 * see the core Services file at system/Config/Services.php.
 */
class Services extends CoreServices
{

	public static function renderView(string $view, array $params = [], $getShared = false)
	{
		$loader = new \Twig\Loader\FilesystemLoader(APPPATH.'Views');
		$twig = new \Twig\Environment($loader, [
		    'cache' => WRITEPATH.'cache',
		    'debug' => true
		]);
		$twig->addExtension(new \Twig\Extra\Intl\IntlExtension());
		return $twig->render($view, $params);
	}

	public static function asset($getShared = false)
	{
		return base_url().'/assets';
	}

	public static function logo($getShared = false)
	{
		return base_url().'/assets/images/'.APP_LOGO;
	}

	public static function setMenu($type, $getShared = false)
	{
		return (array) lang('Menu.'.$type);
	}

	public static function setJsonRules($file, $getShared = false)
	{
		$rules = file_get_contents(APPPATH.'Language/'.service('request')->getLocale().'/Json/'.$file);
		return $rules;
	}

}
