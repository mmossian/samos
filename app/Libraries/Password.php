<?php

namespace App\Libraries;

use App\Models\UserModel;

class Password
{
	private $password;
	private $options;

	public function __construct($password)
	{
		$this->password = $password;
		$this->options = [
			'cost' => $this->cost()
		];
	}

	public function set()
	{
		return password_hash($this->password, PASSWORD_DEFAULT, $this->options);
	}

	public function get($user_id)
	{
		$model = new UserModel;
		$hash = $model->where('user_id', $user_id)->findColumn('user_password');
		return $hash[0];
	}

	public function verify($user_id, $hash)
	{
		if(password_verify($this->password, $hash))
		{
			if (password_needs_rehash($hash, PASSWORD_DEFAULT, $this->options))
			{
				$this->update($user_id, $this->set());
				return true;
			}
			return true;
		}
		return false;
	}

	public function update($user_id, $newHash)
	{
		$model = new UserModel;
		return $model
			->where('id', $user_id)
			->set(['user_password' => $newHash])
			->update();
	}

	private function cost()
	{
		$timeTarget = 0.05; // 50 milisegundos

		$coste = 8;
		do {
		    $coste++;
		    $start = microtime(true);
		    password_hash($this->password, PASSWORD_DEFAULT, ["cost" => $coste]);
		    $end = microtime(true);
		} while (($end - $start) < $timeTarget);
		return $coste;
	}
}
