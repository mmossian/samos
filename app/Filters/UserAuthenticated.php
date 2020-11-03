<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Services\Authorize;

class UserAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
	    if (!Authorize::isLoggedIn() || Authorize::userGroup() != APP_USER)
	    {
            return redirect(PUBLIC_HOME);
	    }
        if((boolean) Authorize::userActive() == false)
        {
            return Authorize::logout();
        }
        if(Authorize::firstTime() == true)
        {
            return redirect(FIRST_HOME);
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // return new Visitor($request, $response);
    }
}
