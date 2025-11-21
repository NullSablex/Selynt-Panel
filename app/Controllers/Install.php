<?php

namespace App\Controllers;

use CodeIgniter\Controller;

class Install extends Controller
{
    public function index(string $param = ''): string
    {
        helper(['url', 'form']);

        // --- Controle de disponibilidade do instalador ---
        // Lê installer.status do .env (true/false)
        $installerEnabled = filter_var(
            (string) env('installer.status', 'false'),
            FILTER_VALIDATE_BOOLEAN
        );

        if (! $installerEnabled) {
            // Instalador desativado: mostra página de bloqueio
            return view('installer/disabled', ['page_title' => 'Instalação indisponível']);
        }

        // Versão mínima exigida
        $requiredPhp = '8.1.0';
        $currentPhp  = PHP_VERSION;
        $phpOk       = version_compare($currentPhp, $requiredPhp, '>=');

        // Extensões necessárias
        $requiredExtensions = [
            'curl',
            'openssl',
            'mbstring',
            'intl',
            'json',
            'pdo',
            'sqlite3',
            'pdo_sqlite',
            'shell_exec'
        ];

        $extensions      = [];
        $allExtensionsOk = true;

        foreach ($requiredExtensions as $ext) {
            $loaded = extension_loaded($ext);
            $extensions[] = [
                'name'   => $ext,
                'loaded' => $loaded,
            ];
            if (! $loaded) {
                $allExtensionsOk = false;
            }
        }

        $allOk = $phpOk && $allExtensionsOk;

        // STEP 2 – usuário inicial
        $request        = $this->request;
        $userConfigured = false;
        $userErrors     = [];
        $userData       = [
            'username'     => '',
            'email'        => '',
            'display_name' => '',
        ];

        $currentStep = 1;

        if ($param === 'confirm') {
            $currentStep = 2;

            // dados vindos do form
            $userData['username']     = trim((string) $request->getPost('username'));
            $userData['email']        = trim((string) $request->getPost('email'));
            $userData['display_name'] = trim((string) $request->getPost('display_name'));
            $password                 = (string) $request->getPost('password');
            $passwordConfirm          = (string) $request->getPost('password_confirm');

            // dados para validação
            $data = [
                'username'         => $userData['username'],
                'display_name'     => $userData['display_name'],
                'email'            => $userData['email'],
                'password'         => $password,
                'password_confirm' => $passwordConfirm,
            ];

            $rules = [
                'username'         => 'required|min_length[5]|max_length[30]',
                'display_name'     => 'required|max_length[15]',
                'email'            => 'required|max_length[100]|valid_email',
                'password'         => 'required|min_length[8]|max_length[128]',
                'password_confirm' => 'required|matches[password]',
            ];

            $messages = [
                'password' => [
                    'min_length' => lang('erro_senha_min_length'),
                    'max_length' => lang('erro_senha_max_length'),
                ],
            ];

            if (! $this->validateData($data, $rules, $messages)) {
                // mantém no step 2 com erros do CI
                $userErrors = $this->validator->getErrors();
            } else {
                $userModel = new \App\Models\UserModel();
                $userModel->insert([
                    'user'    => $userData['username'],
                    'email'   => $userData['email'],
                    'name'    => $userData['display_name'],
                    'pass'    => password_hash($password, PASSWORD_ARGON2ID),
                    'created' => time(),
                    'role'    => 'admin'
                ]);

                $userConfigured = true;
                $currentStep    = 3; // vai para orientações finais

                // Desativa o instalador automaticamente no .env
                $this->setInstallerStatus(false);
            }
        }

        $page = [
            'page_title' => 'Instalação',
            'requiredPhp' => $requiredPhp,
            'currentPhp' => $currentPhp,
            'phpOk' => $phpOk,
            'extensions' => $extensions,
            'allExtensionsOk' => $allExtensionsOk,
            'allOk' => $allOk,
            'userConfigured' => $userConfigured,
            'userErrors' => $userErrors,
            'userData' => $userData,
            'currentStep' => $currentStep,
        ];

        return view('installer/install', $page);
    }

    /**
     * Atualiza a chave installer.status no .env para true/false.
     * Se não existir, adiciona ao final.
     */
    private function setInstallerStatus(bool $enabled): void
    {
        $envPath = ROOTPATH . '.env';

        if (! is_file($envPath) || ! is_writable($envPath)) {
            log_message(
                'warning',
                'Não foi possível atualizar installer.status no .env (arquivo ausente ou sem permissão).'
            );
            return;
        }

        $content = file_get_contents($envPath);
        if ($content === false) {
            log_message('warning', 'Não foi possível ler o arquivo .env para atualizar installer.status.');
            return;
        }

        $newValue = $enabled ? 'true' : 'false';

        // Se já existir a linha installer.status = ..., substitui
        if (preg_match('/^installer\.status\s*=\s*.*$/m', $content)) {
            $content = preg_replace(
                '/^installer\.status\s*=\s*.*$/m',
                'installer.status = ' . $newValue,
                $content
            );
        } else {
            // Se não existir, adiciona no final
            $content .= PHP_EOL . 'installer.status = ' . $newValue . PHP_EOL;
        }

        file_put_contents($envPath, $content);
    }
}