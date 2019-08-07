<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| LIBRERIA DE GESTION DE ARCHIVOS LOGS
|--------------------------------------------------------------------------
| Prototipo
|	{
|		"message":"El usuario Jaun Perez (ID = 1) ha intentado loguearse",
|		"context":[],
|		"level":200,
|		"level_name":"INFO",
|		"channel":"user-no-active",
|		"datetime":{
|			"date":"2019-07-26 22:41:38.047949","timezone_type":3,"timezone":"America/Sao_Paulo"
|		},
|		"extra":{
|			"data":"{
|				\"ip_address\":\"::1\",
|				\"agent\":\"Mozilla\\/5.0 (X11; Linux i686; rv:60.0) Gecko\\/20100101 Firefox\\/60.0\",
|				\"request_uri\":\"\\/vet\\/index.php\\/login\",
|				\"language\":\"es-ES,es;q=0.8,en-US;q=0.5,en;q=0.3\",
|				\"request_method\":\"POST\",
|				\"additional_data\":{\"id_user\":\"1\"},
|				\"email\":\"jperez@example.com\"
|			}"
|		}
|	}
*/
use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\FirePHPHandler;
use Monolog\Formatter\JsonFormatter;
use Monolog\Formatter\HtmlFormatter;

class Applog
{
	public $additionalData = [];
	protected $CI = NULL;
	private $logDir = NULL;
	private $logger = NULL;
	private $channels = [];
	private $filename = NULL;

	public function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->helper('url');
		$this->CI->load->helper('file');
		$this->CI->load->helper('date');
		$this->CI->config->load('config.log');
		$this->logDir = APPPATH.'logs/monolog/';
		$this->filename = $this->logDir.$this->CI->config->item('app-name').'.log';
	}

	public function set($logger, $data)
	{
		$this->channels = $this->CI->config->item('monolog-channels');
		if(in_array($logger, $this->channels))
		{
			// Crea el logger
			$this->logger = new Logger($logger);
			// Formatea los datos en formato json
			$formatter = new JsonFormatter();
			// Crea manejadores
			$stream = new RotatingFileHandler($this->filename, $this->_setLevel($data['level']));
			$stream->setFormatter($formatter);
			$this->logger->pushHandler($stream);
			$this->_setMessage($data['message']);
		}
	}

	private function _setLevel($level)
	{
		switch ($level)
		{
			case 'INFO':
				return Logger::INFO;
			break;

			case 'ALERT':
				return Logger::ALERT;
			break;

			default:
				# code...
			break;
		}
	}

	private function _setMessage($message)
	{
		$this->logger->pushProcessor(function ($entry) {
			$entry['extra']['data'] = $this->_setExtraData();
			return $entry;
		});
		$this->logger->info($message);
	}

	private function _setExtraData()
	{
		return json_encode([
			'ip_address' => $this->CI->input->ip_address(),
			'agent' => $this->CI->input->user_agent(),
			'request_uri' => $_SERVER['REQUEST_URI'],
			'language' => $_SERVER['HTTP_ACCEPT_LANGUAGE'],
			'request_method' => $_SERVER['REQUEST_METHOD'],
			'additional_data' => $this->additionalData
		]);
	}
}