<?php

namespace App\Controllers;

use App\Libraries\Pm2\Pm2;
use CodeIgniter\Controller;
use CodeIgniter\Database\BaseConnection;
use CodeIgniter\HTTP\{
    CLIRequest,
    IncomingRequest,
    RequestInterface,
    ResponseInterface
};
use CodeIgniter\Session\Session;
use Config\Services;
use Psr\Log\LoggerInterface;
use App\Models\{UserModel, BaseModel};

/**
 * Class BaseController
 *
 * BaseController provides a convenient place for loading components
 * and performing functions that are needed by all your controllers.
 * Extend this class in any new controllers:
 *     class Home extends BaseController
 *
 * For security be sure to declare any new methods as protected or private.
 */
abstract class BaseController extends Controller
{
    /**
     * Instance of the main Request object.
     *
     * @var CLIRequest|IncomingRequest
     */
    protected $request;

    /**
     * An array of helpers to be loaded automatically upon
     * class instantiation. These helpers will be available
     * to all other controllers that extend BaseController.
     *
     * @var list<string>
     */
    protected $helpers = [];

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected BaseConnection $db;
    protected Session $session;
    protected $pager;
    protected Pm2 $pm2;
    protected UserModel $user_model;
    protected BaseModel $base_model;
    protected $View;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.

        $this->db = db_connect();
        $this->session = session();
        $this->pager = service('pager');
        $this->pm2 = new Pm2();
        $this->user_model = new UserModel();
        $this->base_model = new BaseModel();

        if($this->session->get('logged_in')/*$this->auth->loggedIn()*/) {
            $data = [
                'session' => $this->session,
                'user' => $this->user_model->select(['name'])->find($this->session->get('user_id')),
            ];
        } else {
            $data = [
                'session' => $this->session,
            ];
        }

        $this->View = Services::renderer();
        $this->View->setData($data);
    }
}
