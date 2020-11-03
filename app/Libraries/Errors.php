<?php
namespace App\Libraries;



class Errors
{
	private $errors;
	private $data;

	public function __construct($errors, $data=null)
	{
		$this->errors = $errors;
		$this->data = $data;
	}

	public function set()
	{
		if(is_array($this->errors))
		{
			$errors = '<ul>';
			foreach ($this->errors as $k => $error)
			{
				$e = str_replace($k, lang('Errors.'.$k), $error);
				$errors .= "<li>{$e}</li>";
			}
			$errors .= '</ul>';
		}
		else
		{
			$errors = $this->errors;
		}
		session()->setFlashdata(REQUEST_DATA, $this->data);
		$flash = lang('Messages.message-general-error');
		$flash['message'] = str_replace('{error}', $errors, $flash['message']);
		return redirect()->back()->with(TOAST_MESSAGE, $flash);
	}
}
