<?php namespace App\Filters;
 
use CodeIgniter\HTTP\{RequestInterface, ResponseInterface};
use CodeIgniter\Filters\FilterInterface;
 
class Auth implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        // if user not logged in
        if(!session()->get('logged_in')){
            return redirect()->route('login'); 
        }
    }
 
    //--------------------------------------------------------------------
 
    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}