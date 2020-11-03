<?php
namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;
use App\Services\Authorize;

class Guest implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
	    if (Authorize::isLoggedIn())
	    {
            return redirect(Authorize::setRedirect());
	    }
    }

    //--------------------------------------------------------------------

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // return new Visitor($request, $response);
    }
}
