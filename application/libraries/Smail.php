<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| Libreria de gestion de envio de correos con swiftmailer
|--------------------------------------------------------------------------
| Ubicacion: application/libraries
*/
class Smail extends CI_Model
{
	protected $CI = NULL;
	public $from = NULL;
	public $to = NULL;
	public $cc = NULL;
	public $bcc = NULL;
	public $subject = '';
	public $message = '';
	public $priority = NULL;
	public $attachment = NULL;
	public $errors = NULL;
	private $transport = NULL;

	function __construct()
	{
		$this->CI =& get_instance();
		$this->CI->load->config('config.mail');
		$this->transport = (new Swift_SmtpTransport(
			$this->CI->config->item('smtp_host'),
			$this->CI->config->item('smtp_port'),
			$this->CI->config->item('smtp_crypto')
		))
		->setUsername($this->CI->config->item('smtp_user'))
		->setPassword($this->CI->config->item('smtp_pass'));
	}

	private function _set()
	{
		if(!isset($this->from))
		{
			$this->from = $this->CI->config->item('dtr-default-from');
		}
	}

	public function send()
	{
		$this->_set();
		$mailer = new Swift_Mailer($this->transport);
		$message = (new Swift_Message($this->subject))
		->setFrom($this->from)
		->setBody($this->message, 'text/html');
		if(isset($this->to))
		{
			$message->setTo($this->to);
		}
		if(isset($this->cc))
		{
			$message->setCc($this->cc);
		}
		if(isset($this->bcc))
		{
			$message->setBcc($this->bcc);
		}
		if(!$mailer->send($message, $errors))
		{
			$this->errors = $errors;
			return FALSE;
		}
		return TRUE;
	}
}