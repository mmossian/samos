<?php
namespace App\Services;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use Swift_Mailer;
use Swift_Message;
use Swift_SmtpTransport;

class Mail extends BaseService
{
	private static $config;
	private static $mailer;
	private static $message;
	private static $body;
	private static $view = 'email-template';
	private static $to;
	private static $cc = null;
	private static $bcc = null;

	public static function constructor($template, $to, $cc=null, $bcc=null)
	{
		self::$to = $to;
		self::$cc = $cc;
		self::$bcc = $bcc;
		self::$body = $template;
		self::$config = config('Email');
	}

	private static function setTransport()
	{
		$transport = (new Swift_SmtpTransport(
			self::$config->SMTPHost,
			self::$config->SMTPPort,
			self::$config->SMTPCrypto
		))
			->setUsername(self::$config->SMTPUser)
			->setPassword(self::$config->SMTPPass);
		self::$mailer = new Swift_Mailer($transport);
	}

	private static function setMessage()
	{
		self::$message = (new Swift_Message(self::$body['subject']))
			->setFrom([self::$config->fromEmail => self::$config->fromName])
			->setTo(self::$to)
			->setPriority(self::$body['priority'])
			//->setEncoder(self::$config->charset)
			->setContentType(self::$config->mailType)
			->setBody(self::setBody());
		if(isset(self::$cc))
		{
			self::$message->setCc(self::$cc);
		}
		if(isset(self::$bcc))
		{
			self::$message->setBcc(self::$bcc);
		}
	}

	private static function setBody()
	{
		$data = [
			'imgSrc' => self::setLogo(),
			'footer' => self::setFooter(),
			'body' => self::$body['body']
		];
		return view(self::$view, $data);
	}

	private static function setFooter()
	{
		return str_replace('{app-name}', MAIL_SIGNATURE, lang('Mail.mail-footer'));
	}

	private static function setLogo()
	{
		return \Config\Services::logo();
	}

	public static function send()
	{
		self::setMessage();
		self::setTransport();
		return self::$mailer->send(self::$message);
	}
}