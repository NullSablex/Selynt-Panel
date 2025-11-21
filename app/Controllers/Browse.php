<?php
declare(strict_types=1);

namespace App\Controllers;

use CodeIgniter\HTTP\RedirectResponse;

class Browse extends BaseController
{
    public function index(): string
    {
        set_menu(1);

        $apps = $this->pm2->listApps();

        $totalApps = count($apps);
        $online    = 0;

        foreach ($apps as $app) {
            if (! empty($app['isOnline'])) {
                $online++;
            }
        }

        $offline       = max(0, $totalApps - $online);
        $onlinePercent = $totalApps > 0 ? round(($online / $totalApps) * 100) : 0;

        $page = [
            'page_name' => 'dashboard',
            'page_title' => 'Dashboard',
            'apps' => $apps,
            'totalApps' => $totalApps,
            'onlineApps' => $online,
            'offlineApps' => $offline,
            'onlinePercent' => $onlinePercent,
        ];

        return view('site/index', $page);
    }

    public function apps(int $page = 1): RedirectResponse|string
    {
        set_menu(2);

        try {
            $apps = $this->pm2->listApps();  
        } catch (\Throwable $e) {
            log_message('error', 'Erro ao listar apps do PM2: {msg}', [
                'msg' => $e->getMessage(),
            ]);
            $apps = [];
        }

        $totalApps = count($apps);
        $online = 0;

        foreach ($apps as $app) {
            if (!empty($app['isOnline'])) {
                $online++;
            }
        }

        $offline = max(0, $totalApps - $online);
        $onlinePercent = $totalApps > 0 ? round(($online / $totalApps) * 100) : 0;

        $perPage = 10;

        if ($page < 1) {
            $page = 1;
        }

        $maxPage = max(1, (int) ceil($totalApps / $perPage));
        if ($page > $maxPage) {
            $page = $maxPage;
        }

        $offset = ($page - 1) * $perPage;
        $appsPage = array_slice($apps, $offset, $perPage);

        $data = [
            'page_name' => 'apps',
            'page_title' => 'Aplicações',
            'apps' => $appsPage,
            'totalApps' => $totalApps,
            'onlineApps' => $online,
            'offlineApps' => $offline,
            'onlinePercent' => $onlinePercent,
            'pager_links' => $this->pager->makeLinks($page, $perPage, $totalApps, 'default', 2),
        ];

        return view('site/index', $data);
    }

    /**
     * Detalhe de uma app: /apps/{appName}
     * (equivalente à rota Express que você mostrou)
     */
    public function app_show(string $appName): RedirectResponse|string
    {
        $this->session->remove('active_menu');
        $app = $this->pm2->describeApp($appName);

        if (! $app) {
            return redirect()->to('/apps');
        }

        // badge + flag de status
        $app['badgeClass'] = $app['status'] === 'online' ? 'badge-online' : 'badge-offline';
        $app['isOnline']   = $app['status'] === 'online';

        $cwd = $app['pm2_env_cwd'] ?? '';

        // Git + .env (equivalentes às funções JS)
        if ($cwd !== '') {
            try {
                $app['git_branch'] = $this->pm2->getGitBranch($cwd);
            } catch (\Throwable $e) {
                $app['git_branch'] = null;
            }

            try {
                $app['git_commit'] = $this->pm2->getGitCommit($cwd);
            } catch (\Throwable $e) {
                $app['git_commit'] = null;
            }

            try {
                $app['env_file'] = $this->pm2->getEnvFile($cwd);
            } catch (\Throwable $e) {
                $app['env_file'] = null;
            }
        } else {
            $app['git_branch'] = null;
            $app['git_commit'] = null;
            $app['env_file']   = null;
        }

        // Logs iniciais (sem nextKey, mesma ideia do Node)
        $stdout = $this->pm2->readLogsReverse($app['pm_out_log_path'] ?? '', null, 200);
        $stderr = $this->pm2->readLogsReverse($app['pm_err_log_path'] ?? '', null, 200);

        // Convertendo ANSI -> HTML e juntando em <br/> (igual ansiConvert.toHtml + join)
        $stdoutLines = array_map(fn ($l) => $this->ansiToHtml($l), $stdout['lines'] ?? []);
        $stderrLines = array_map(fn ($l) => $this->ansiToHtml($l), $stderr['lines'] ?? []);

        $stdout['lines'] = implode('<br/>', $stdoutLines);
        $stderr['lines'] = implode('<br/>', $stderrLines);

        $logs = [
            'stdout' => $stdout,
            'stderr' => $stderr,
        ];

        $page = [
            'page_name' => 'app_manage',
            'page_title' => 'Dados da aplicação ('.$appName.')',
            'app' => $app,
            'logs' => $logs
        ];
        return view('site/index', $page);
    }

    public function profile(string $param = ''): RedirectResponse|string
    {
        $this->session->remove('active_menu');
        $userId = $this->session->get('user_id');
        $user_data = $this->user_model
                          ->select('user')
                          ->find($userId);

        if ($param === 'update') {
            $userId = (int) $this->session->get('user_id');

            if (!$this->session->get('logged_in')) {
                return redirect()->route('login');
            }

            $avatar = (string) $this->request->getPost('avatar');

            $allowedAvatars = $this->base_model->getAllowedAvatars();
            if ($avatar === '' || !in_array($avatar, $allowedAvatars, true)) {
                swal_error('Selecione uma imagem de perfil válida.');
                return redirect()->back()->withInput();
            }

            $this->user_model->update($userId, [
                'avatar' => $avatar,
            ]);

            $this->session->set('user_avatar', $avatar);

            swal_success('Imagem de perfil atualizada com sucesso.');
            return redirect()->route('user.profile');
        }

        $page = [
            'page_name' => 'profile',
            'page_title' => 'Meu Perfil',
            'user_nick' => $user_data['user'] ?? '',
            'avatars' => $this->base_model->getAvatars(),
        ];

        return view('site/index', $page);
    }

    public function user_settings(): string
    {
        $this->session->remove('active_menu');
        $userId = $this->session->get('user_id');

        $page = [
            'page_name' => 'settings_user',
            'page_title' => 'Configurações da Conta',
            'user_details' => $this->user_model->select('email, user, created, last_login')->find($userId),
        ];

        return view('site/index', $page);
    }

    /**
     * Atualiza dados da conta (nome exibido, e-mail e senha).
     * Rota para o form: url_to('user.settings.update')
     */
    public function user_settings_update(): RedirectResponse
    {
        $userId = $this->session->get('user_id');

        if (! $userId) {
            return redirect()->route('login');
        }

        $row = $this->user_model->find($userId);

        if (! $row) {
            return redirect()->route('login');
        }

        // Dados do form
        $displayName     = trim((string) $this->request->getPost('display_name'));
        $email           = trim((string) $this->request->getPost('email'));
        $passwordCurrent = (string) $this->request->getPost('password_current');
        $password        = (string) $this->request->getPost('password');
        $passwordConfirm = (string) $this->request->getPost('password_confirm');

        // Dados para validação
        $data = [
            'display_name'     => $displayName,
            'email'            => $email,
            'password_current' => $passwordCurrent,
            'password'         => $password,
            'password_confirm' => $passwordConfirm,
        ];

        // Regras:
        // - display_name: obrigatório, máx. 15
        // - email: obrigatório, máx. 100, válido
        // - password: opcional, mas se vier precisa 8–128
        // - password_confirm: precisa bater com password
        // - password_current: obrigatório se password/password_confirm forem usados
        $rules = [
            'display_name'     => 'required|max_length[15]',
            'email'            => 'required|max_length[100]|valid_email',
            'password'         => 'permit_empty|min_length[8]|max_length[128]',
            'password_confirm' => 'matches[password]',
            'password_current' => 'required_with[password,password_confirm]',
        ];

        $messages = [
            'password' => [
                'min_length' => lang('erro_senha_min_length'),
                'max_length' => lang('erro_senha_max_length'),
            ],
            'password_current' => [
                'required_with' => 'Para alterar a senha, informe a sua senha atual.',
            ],
            'password_confirm' => [
                'matches' => 'A confirmação da senha deve ser igual à nova senha.',
            ],
        ];

        if (! $this->validateData($data, $rules, $messages)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $this->validator->getErrors());
        }

        // Monta os dados para atualização
        $updateData = [];

        if ($displayName !== ($row['name'] ?? '')) {
            $updateData['name'] = $displayName;
        }

        if ($email !== ($row['email'] ?? '')) {
            $updateData['email'] = $email;
        }

        // Troca de senha (se foi preenchida)
        if ($password !== '') {
            // Garante que a senha atual está correta
            $hashAtual = $row['pass'] ?? '';

            if (! password_verify($passwordCurrent, $hashAtual)) {
                return redirect()->back()
                    ->withInput()
                    ->with('errors', [
                        'password_current' => 'Senha atual incorreta.',
                    ]);
            }

            $updateData['pass'] = password_hash($password, PASSWORD_ARGON2ID);
        }

        if (! empty($updateData)) {
            $this->user_model->update($userId, $updateData);
        }

        swal_success('Configurações atualizadas com sucesso.');
        return redirect()->back();
    }

    /**
     * Versão simples de ansiConvert.toHtml
     */
    private function ansiToHtml(string $text): string
    {
        // remove códigos ANSI
        $text = preg_replace('/\x1b\[[0-9;]*m/', '', $text);

        // escapa HTML
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}
