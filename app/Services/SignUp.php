<?php
namespace App\Services;

use CodeIgniter\Config\BaseService;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\I18n\Time;
use App\Services\Config\Mail;
use App\Libraries\Errors;
use App\Libraries\Password;
use App\Models\UserModel;
use App\Models\CompanyModel;

class SignUp extends BaseService
{

    private static $credentials;
    private static $userModel;
    private static $companyModel;

    public static function constructor()
    {
    	self::$userModel = new UserModel;
        self::$companyModel = new CompanyModel;
    }

    /**
     *  Registra un nuevo usuario
     *  @access public
     *  @params object
     *  @return void
     */
    public static function register(RequestInterface $request)
    {
    	self::$credentials = $request->getPost();
    	$validation =  \Config\Services::validation();
        // Valida los datos del formulario
    	if((boolean) $validation->run(self::$credentials, 'signup'))
    	{
            // Establece la fecha de creacion del usuario
            $config = config('App');
            self::$credentials['created_at'] = Time::now($config->appTimezone)
                ->subHours(1)
                ->toLocalizedString('yyyy-MM-dd H:m:s');
            // Establece el password e inserta al nuevo usuario
            $pwd = new Password(self::$credentials['password']);
            self::$credentials['password'] = $pwd->set();
            // Inicia la transaccion
            $db = \Config\Database::connect();
            $db->transStart();
                self::$companyModel->insert(self::$credentials);
                self::$credentials['company_id'] = self::$companyModel->insertID();
                self::$userModel->insert(self::$credentials);
                $lastId = self::$userModel->insertID();
            $db->transComplete();

            // Envia correo de validacion
            if($db->transStatus() == true)
            {
                $userName = self::$credentials['firstname'].' '.self::$credentials['lastname'];
                Mail::constructor(self::setMailTemplate(),[self::$credentials['email'] => $userName]);
                if(Mail::send())
                {
                    $message = lang('Messages.message-registration-ok');
                    $message['message'] = str_replace(
                        ['{signUpConfirmationExpires}', '{email}'],
                        [TIME_TO_VERIFY_EXPIRATION/3600, self::$credentials['email']],
                        $message['message']);
                    return redirect('acceso')->with('TOAST-MESSAGE', $message);
                }
                self::$userModel->where('id', $lastId)->delete();
                return redirect()->back()->with('TOAST-MESSAGE', lang('Messages.message-mail-sent-error'));
            }
            return redirect()->back()->with('TOAST-MESSAGE', lang('Messages.message-registration-error'));
    	}
    	$errors = new Errors($validation->getErrors(), self::$credentials);
		return $errors->set();
    }

    /**
     *  Establece la plantilla del correo a enviar
     *  @access private
     *  @params void
     *  @return array
     */
	private static function setMailTemplate()
    {
        // Encripta los datos a ser enviados en la url
    	$encrypter = \Config\Services::encrypter();
        $href = base_url().'/auth/validar-registro/'.bin2hex($encrypter->encrypt(self::$credentials['email']));

        $template = lang('Mail.mail-registration');
        $template['body'] = str_replace(
            ['{name}', '{app-name}', '{email}', '{href}'],
            [self::$credentials['firstname'], APP_SHORTNAME, self::$credentials['email'], $href],
            $template['body']
        );
        return $template;
    }

    /**
     *  Valida el registro desde el correo enviado
     *  @access public
     *  @params string
     *  @return void
     */
    public static function validate($email)
    {
    	$config = config('App');
    	$encrypter = \Config\Services::encrypter();
    	$user_email = $encrypter->decrypt(hex2bin($email));
    	$user = self::$userModel->where('email', $user_email)->first();
    	if($user && $user->email_verified == 0)
    	{
    		$now = Time::now($config->appTimezone)->timestamp;
    		$created = Time::parse($user->created_at, $config->appTimezone)
    			->addSeconds(TIME_TO_VERIFY_EXPIRATION)
    			->timestamp;
    		if($created < $now)
    		{
    			self::$userModel->where('email', $user_email)->delete();
    			return redirect('home')->with('TOAST-MESSAGE', lang('Messages.message-registration-validation-error'));
    		}
    		self::$userModel
    			->where('email', $user_email)
    			->set(['email_verified' => 1])
    			->update();
    		return redirect('acceso')->with('TOAST-MESSAGE', lang('Messages.message-registration-validation-ok'));
    	}
    	return redirect('home')->with('TOAST-MESSAGE', lang('Messages.message-registration-validation-error'));
    }

}