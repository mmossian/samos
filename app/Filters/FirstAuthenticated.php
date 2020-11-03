<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Services\Authorize;

class FirstAuthenticated implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if((boolean) Authorize::firstTime() == false)
        {
            return redirect(PUBLIC_HOME);
        }
        if((boolean) Authorize::userActive() == false)
        {
        	return Authorize::logout();
        }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // return new Visitor($request, $response);
    }
}
