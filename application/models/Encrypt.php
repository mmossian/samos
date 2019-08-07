<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| MODELO DE ENCRIPTACION DE CLAVES
|--------------------------------------------------------------------------
|
|
*/

class Encrypt extends CI_Model
{

	private $encryptionKey = NULL;
	public $dinamicKey = FALSE;
	private $configOptions = [
		'driver' => 'openssl',
		'cipher' => 'aes-256',
		'mode' => 'cbc'
	];

	function __construct()
	{
		parent::__construct();
		$this->load->library('encryption');
		$this->encryptionKey = $this->config->item('encryption_key');
		$this->configOptions['key'] = $this->encryptionKey;
		$this->encryption->initialize($this->configOptions);
	}

	/*
		-------------------------------------------------------
		Encripta un array o cadena de caracteres
		-------------------------------------------------------
		@visibility public
		@params array | string | NULL
		@return array | string
		-------------------------------------------------------
	*/
	public function encode($data=NULL)
	{
		$result;
		if(isset($data))
		{
			if(is_array($data))
			{
				foreach ($data as $key => $value)
				{
					$result[$key] = $this->_encode($value);
				}
			}
			else
			{
				$result = $this->_encode($data);
			}
		}
		else
		{
			$data = random_string('alnum', 60);
			$result = $this->_encode($data);
		}
		return $result;
	}

	public function decode($data)
	{
		$result;
		if(is_array($data))
		{
			foreach ($data as $key => $value)
			{
				$result[$key] = $this->_decode($value);
			}
		}
		else
		{
			$result = $this->_decode($data);
		}
		return $result;
	}


	private function _encode($str)
	{
		$result = $this->encryption->encrypt($str);
		if(!empty(trim($str)))
		{
			$result = strtr(
				$result,
				[
					'+' => '.',
					'=' => '-',
					'/' => '~'
				]
			);
		}
		return $result;
	}

	private function _decode($str)
	{
		$result = strtr(
			$str,
			[
				'.' => '+',
				'-' => '=',
				'~' => '/'
			]
		);
		return $this->encryption->decrypt($result);
	}
}