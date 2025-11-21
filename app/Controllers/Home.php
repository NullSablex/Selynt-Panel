<?php
declare(strict_types=1);

namespace App\Controllers;

use App\Models\UserModel;
use CodeIgniter\HTTP\RedirectResponse;

class Home extends BaseController
{
    public function index(): RedirectResponse|string
    {
        if ($this->session->get('logged_in')) {
            swal_error('Você já está logado!!');
            return redirect()->back();
        }

        $page = [
            'page_name' => 'entrar',
            'page_title' => 'Fazer login'
        ];
        return view('site/login', $page);
    }

    public function login_confirm(): RedirectResponse
    {
        if ($this->session->get('logged_in')) {
            swal_error('Você não pode fazer isso enquanto está logado!!');
            return redirect()->back();
        }

        $user = esc($this->request->getPost('username'));
		$senha = esc($this->request->getPost('password'));

		$data = [
			'username' => $user,
			'password' => $senha,
		];

		$rules = [
			'username' => 'required|max_length[50]',
			'password' => 'required|min_length[8]|max_length[128]',
		];

        $messages = [
            'password' => [
                'min_length' => lang('erro_senha_min_length'),
                'max_length' => lang('erro_senha_max_length'),
            ]
        ];
		
		if (!$this->validateData($data, $rules, $messages)) {
            swal_error($this->validator->getErrors());
			return redirect()->back()->withInput();
		}

        $userModel = new UserModel();

        if ($userModel->login(['user' => $data['username'], 'pass' => $data['password']])) {
            return redirect()->route('apps.dashboard');
		} else {
			return redirect()->back();
		}
    }

    function logout(): RedirectResponse
	{
        $this->session->remove(['acc_status', 'user_id', 'logged_in', 'acc_register']);
        $this->session->destroy();
        return redirect()->route('login');
	}
}
