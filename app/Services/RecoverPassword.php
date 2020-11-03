<?php
namespace App\Services;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use App\Services\Config\Mail;
use App\Libraries\Errors;
use App\Libraries\Password;
use App\Models\UserModel;
use App\Models\PasswordResetModel;

class RecoverPassword extends BaseService
{

    private static $credentials;
    private static $userModel;
    private static $passwordResetModel;
    private static $encrypter;

    public static function constructor()
    {
    	self::$userModel = new UserModel;
        self::$passwordResetModel = new PasswordResetModel;
        self::$encrypter = \Config\Services::encrypter();
    }

    public static function setView($id)
    {
        return !self::exists($id)
            ? 'auth/restore-password.twig'
            : 'auth/restore-password-error.twig';
    }

    public static function recover(RequestInterface $request)
    {
    	self::$credentials = $request->getPost();
    	$validation =  \Config\Services::validation();
    	if((boolean) $validation->run(self::$credentials, 'recoverpassword'))
    	{
            // Obtengo el usuario
            $user = self::$userModel
                ->where('email', self::$credentials['email'])
                ->first();
            if($user && $user->ugroup == USER_GROUP_ID && $user->active == 1)
            {
                if(self::exists($user->id))
                {
                    $message = lang('Messages.message-sent-password-done');
                    $message['message'] = str_replace('{email}', self::$credentials['email'], $message['message']);
                    return redirect('home')->with('TOAST-MESSAGE', $message);
                }
        		$userName = $user->firstname.' '.$user->lastname;
                $encryptedData = self::encryptData($user);
        		Mail::constructor(self::setMailTemplate($encryptedData, $user),[self::$credentials['email'] => $userName]);
        		$message = lang('Messages.message-mail-sent-error');
    	        if(Mail::send())
    	        {
                    $config = config('App');
                    $data = [
                        'user_id' => $user->id,
                        'hash' => $encryptedData['hash'],
                        'created_at' => Time::now($config->appTimezone)
                            ->toLocalizedString('yyyy-MM-dd H:m:s')
                    ];
                    self::$passwordResetModel->insert($data);
    	        	$message = lang('Messages.message-sent-password-ok');
                    $message['message'] = str_replace(
                        ['{PasswordResetExpires}', '{email}'],
                        [TIME_TO_VERIFY_EXPIRATION/3600, self::$credentials['email']],
                        $message['message']);
                    return redirect('home')->with('TOAST-MESSAGE', $message);
    	        }
            }
            $message = lang('Messages.message-user-not-exists');
            return redirect()->back()->with('TOAST-MESSAGE', $message);
    	}
    	$errors = new Errors($validation->getErrors(), self::$credentials);
		return $errors->set();
    }

	private static function setMailTemplate($encryptedData, $user)
    {
        $href = base_url().'/auth/restablecer-contrasena/'.$encryptedData['id_enc'].'/'.$encryptedData['hash_enc'];

        $template = lang('Mail.mail-forgot-password-sent');
        $template['body'] = str_replace(
            ['{username}', '{href}'],
            [$user->firstname, $href],
            $template['body']
        );
        return $template;
    }

    public static function validate(RequestInterface $request)
    {
        $request = $request->getPost();
        $validation =  \Config\Services::validation();
        if((boolean) $validation->run($request, 'restorepassword'))
        {
            $user_id = self::$encrypter->decrypt(hex2bin($request['id']));
            $user = self::$passwordResetModel
                ->where('user_id', $user_id)
                ->where('hash', self::$encrypter->decrypt(hex2bin($request['hash'])))
                ->first();
            if($user && self::expired($user))
            {
                $pwd = new Password($request['password']);
                // Actualiza contrasenia
                self::$userModel
                    ->where('id', $user_id)
                    ->set(['password' => $pwd->set($request['password'])])
                    ->update();
                // Elimina al usuario de la tabla password_resets
                self::$passwordResetModel->where('user_id', $user_id)->delete();
                return redirect('acceso')->with('TOAST-MESSAGE', lang('Messages.message-password-validation-ok'));
            }
            return redirect('home')->with('TOAST-MESSAGE', lang('Messages.message-registration-validation-error'));
        }
        $errors = new Errors($validation->getErrors(), self::$credentials);
        return $errors->set();
    }

    private static function encryptData($user)
    {
        helper('text');
        $hash = random_string('sha1');
        return [
            'id_enc' => bin2hex(self::$encrypter->encrypt($user->id)),
            'hash' => $hash,
            'hash_enc' => bin2hex(self::$encrypter->encrypt($hash))
        ];
    }

    private static function exists($id)
    {
        $resets = self::$passwordResetModel->where('user_id', $id)->first();
        if(is_null($resets))
        {
            return false;
        }
        if(!self::expired($resets))
        {
            self::$passwordResetModel->where('user_id', $id)->delete();
            return false;
        }
        return true;
    }

    private static function expired($user)
    {
        $config = config('App');
        $now = Time::now($config->appTimezone)->timestamp;
        $expiration = Time::parse($user->created_at, $config->appTimezone)
            ->addSeconds(TIME_TO_VERIFY_EXPIRATION)
            ->timestamp;
        return $expiration < $now ? false : true;
    }
}