<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| LIBRERIA DE GESTION DE INTENTOS DE VALIDACION
|--------------------------------------------------------------------------
|
|
*/
class Throttling
{
	private $driver;
	private $key = NULL;
	public $cached = [];
	public $lifeTime = NULL;
	public $maxAttempts = NULL;
	const MAX_ATTEMPTS = 3;
	const LIFE_TIME = 60;

	public function __construct()
	{

		$this->driver = new \Doctrine\Common\Cache\ApcuCache();
		//$this->driver = new \Doctrine\Common\Cache\FilesystemCache('./application/cache');
		$this->_set();
	}

	/*
	|--------------------------------------------------------------------------
	|	Inicializa el cache
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function _set()
	{
		if(!isset($this->lifeTime))
		{
			$this->lifeTime = self::LIFE_TIME;
		}
		if(!isset($this->maxAttempts))
		{
			$this->maxAttempts = self::MAX_ATTEMPTS;
		}
		$this->key = 'access_attempts-'.$_SERVER['REMOTE_ADDR'];
		if(!$this->driver->contains($this->key))
		{
			$config = [
				'status' => 'active',
				'attempts' => 0,
				'time' => time()
			];
			$this->driver->save($this->key, $config, $this->lifeTime);
		}
		$this->cached = $this->driver->fetch($this->key);
	}

	/*
	|--------------------------------------------------------------------------
	|	Chequea si la ip ha sido bloqueada
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return boolean
	|--------------------------------------------------------------------------
	*/
	public function isLocked()
	{
		return $this->cached['status'] === 'locked-'.$_SERVER['REMOTE_ADDR'] ? TRUE : FALSE;
	}

	/*
	|--------------------------------------------------------------------------
	|	Incrementa intentos de login
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function increment()
	{
		$this->cached['attempts'] += 1;
		$this->driver->save($this->key, $this->cached, self::LIFE_TIME);
		if($this->cached['attempts'] >= $this->maxAttempts)
		{
			$this->lock();
		}
		$this->cached = $this->driver->fetch($this->key);
	}

	/*
	|--------------------------------------------------------------------------
	|	Bloquea la ip
	|--------------------------------------------------------------------------
	|	@access private
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	private function lock()
	{
		$this->cached['status'] = 'locked-'.$_SERVER['REMOTE_ADDR'];
		$this->cached['time'] = time() + self::LIFE_TIME;
		$this->driver->save($this->key, $this->cached, self::LIFE_TIME);
	}

	/*
	|--------------------------------------------------------------------------
	|	Elimina el cache
	|--------------------------------------------------------------------------
	|	@access public
	|	@params void
	|	@return void
	|--------------------------------------------------------------------------
	*/
	public function delete()
	{
		$this->driver->delete($this->key);
	}
}