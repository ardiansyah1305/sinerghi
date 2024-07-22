<?php

namespace App\Controllers;

use CodeIgniter\Controller;
use CodeIgniter\HTTP\CLIRequest;
use CodeIgniter\HTTP\IncomingRequest;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use Psr\Log\LoggerInterface;
use App\Models\UserModel;

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
    protected $helpers = ['url', 'form'];

    /**
     * Data user yang diambil dari database.
     * 
     * @var array|null
     */
    protected $userData;

    /**
     * Be sure to declare properties for any property fetch you initialized.
     * The creation of dynamic property is deprecated in PHP 8.2.
     */
    protected $session;

    /**
     * @return void
     */
    public function initController(RequestInterface $request, ResponseInterface $response, LoggerInterface $logger)
    {
        // Do Not Edit This Line
        parent::initController($request, $response, $logger);

        // Preload any models, libraries, etc, here.
        $this->session = \Config\Services::session();

        // Pastikan pengguna sudah login
        if (!$this->session->get('logged_in')) {
            return redirect()->to('/login');
        }

        // Ambil user_id dari session
        $userId = $this->session->get('id');
        if (!$userId) {
            log_message('error', 'User ID not found in session.');
            return redirect()->to('/login'); // Arahkan ke halaman login jika user_id tidak ditemukan
        }

        // Debugging: Periksa userId
        log_message('debug', 'User ID: ' . $userId);

        // Ambil data user dari database
        $userModel = new UserModel();
        $this->userData = $userModel->find($userId);
        if (!$this->userData) {
            log_message('error', 'User not found in database for user ID: ' . $userId);
            return redirect()->to('/login')->with('error', 'User not found'); // Arahkan ke halaman login jika user tidak ditemukan
        }

        // Set the username for use in views
        $this->username = $this->userData['username'];
    }
}
