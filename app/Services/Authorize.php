<?php
namespace App\Services;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use App\Libraries\Errors;
use App\Libraries\Password;
use App\Models\UserModel;

class Authorize extends BaseService
{

    private static $credentials;
    private static $userModel;

    public static function constructor()
    {
        self::$userModel = new UserModel;
    }

    public static function isLoggedIn()
	{
		return is_null(session(USER_SESSION_NAME)) ? false : true;
	}

    public static function userGroup()
    {
        return session(USER_SESSION_NAME)->ugroup;
    }

    public static function firstTime()
    {
        return session(USER_SESSION_NAME)->first_time == 1 ? true : false;
    }

    public static function emailVerified()
    {
        return is_null(session(USER_SESSION_NAME)->email_verified_at) ? false : true;
    }
    public static function isActive()
    {
        if(is_null(session(USER_SESSION_NAME)))
        {
            return false;
        }
        $active = self::$userModel
            ->where('id', session(USER_SESSION_NAME)->id)
            ->findColumn('active');
        return $active[0] == 1 ? true : false;
    }

    public static function auth(RequestInterface $request)
    {
        self::$credentials = $request->getPost();
        $validation =  \Config\Services::validation();

        if($validation->run(self::$credentials, 'login'))
        {

            $user = self::$userModel
                ->where('email', self::$credentials['email'])
                ->first();
            if($user && !self::isActive())
            {
                $message = lang('Messages.message-user-not-active');
                $message['message'] = str_replace('{email}', $user->email, $message['message']);
                return redirect(PUBLIC_HOME)->with(TOAST_MESSAGE, $message);
            }
            if($user && !self::emailVerified())
            {
                return redirect(PUBLIC_HOME)->with(TOAST_MESSAGE, lang('Messages.message-user-email-notverified'));
            }
            $pwd = new Password(self::$credentials['password']);
            if($user && (boolean) $pwd->verify($user->id, $user->password) === true)
            {
                self::createUserSession($user);
                return redirect(self::setRedirect());
            }
            session()->setFlashdata(REQUEST_DATA, self::$credentials);
            return redirect()->back()->with(TOAST_MESSAGE, lang('Messages.message-login-error'));
        }
        $errors = new Errors($validation->getErrors(), self::$credentials);
        return $errors->set();
    }

    public static function logout()
    {
        $group = session(USER_SESSION_NAME)->ugroup;
        $route = $group === ADMIN_GROUP_ID ? 'login' : 'acceso';
        session()->stop();
        session()->destroy();
        return redirect()->to('auth/'.$route);
    }

    public static function createUserSession($user)
	{
		$time = new Time('now', config('App')->appTimezone);
		$user->password = null;
		$user->session_start = $time->toLocalizedString('d-m-Y H:i');
		session()->set(USER_SESSION_NAME, $user);
	}

    /*private static function validate()
	{
		$validation =  \Config\Services::validation();

		if($validation->run(self::$credentials, 'login'))
		{
			return true;
		}
		$errors = new Errors($validation->getErrors(), self::$credentials);
		return $errors->set();
	}*/

    public static function setRedirect()
    {
        if(self::firstTime())
        {
            return redirect(FIRST_HOME);
        }
        if(self::$credentials['ugroup'] == APP_USER)
        {
            return PUBLIC_HOME;
        }
        elseif (self::$credentials['ugroup'] == APP_COMPANY)
        {
            return COMPANY_HOME;
        }
        else
        {
            return ADMIN_HOME;
        }
    }

    /**
     *  Actualiza el password del usuario loqueado
     *
     *
     */

    public static function updateSessionPassword(RequestInterface $request)
    {
        $request = $request->getPost();
        $validation =  \Config\Services::validation();
        if((boolean) $validation->run($request, 'passwordprofile'))
        {
            $user_id = session(USER_SESSION_NAME)->id;
            $userModel = new UserModel;
            $user = $userModel
                ->where('id', $user_id)
                ->first();
            $pwd = new Password($request['cur_password']);
            if($pwd->verify($user_id, $user->password))
            {
                 $newpwd = new Password($request['password']);
                 $new_pwd = $newpwd->set();
                 $userModel
                    ->where('id', $user_id)
                    ->set(['password' => $new_pwd])
                    ->update();
                return redirect()->back()->with(TOAST_MESSAGE, lang('Messages.message-record-saved-ok'));
            }
            return redirect()->back()->with(TOAST_MESSAGE, lang('Messages.message-curpassword-not-match'));
        }
        $errors = new Errors($validation->getErrors(), $request);
        return $errors->set();
    }
}
