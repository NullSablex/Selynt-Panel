<?php

use Config\Services;

if (!function_exists('active_menu')) {
    /**
     * Verifica se o menu está ativo com base no ID e no tipo de usuário.
     *
     * @param int        $id   ID do menu a ser verificado.
     * @param string     $type Tipo de usuário ('user', 'admin').
     * @return bool Retorna true se o menu estiver ativo, caso contrário, retorna false.
     */
    function active_menu($id, string $type): bool
    {
        $session = Services::session();

        if ($type === 'user' && $session->get('active_menu') === $id) {
            return true;
        }

        if ($type === 'admin' && $session->get('adm_active_menu') === $id) {
            return true;
        }

        return false;
    }
}

if (!function_exists('set_menu')) {
    /**
     * Define o menu ativo na sessão do usuário ou administrador.
     *
     * Se o parâmetro `$type` for `null`, define o menu ativo para usuários comuns (`active_menu`).
     * Se o parâmetro `$type` for `admin`, define o menu ativo para usuários de gerenciamento (`adm_active_menu`).
     *
     * @param int         $id   ID do menu a ser definido como ativo.
     * @param string|null $type Tipo de usuário, como `null` para usuários comuns.
     * 
     * @return void
     */
    function set_menu(int $id, $type = null): void
    {
        $session = Services::session();

        if ($type === null) {
            $session->set('active_menu', null); 
            $session->set('active_menu', $id);
        }

        if ($type === 'admin') {
            $session->set('adm_active_menu', null);
            $session->set('adm_active_menu', $id);
        }
    }
}

if (!function_exists('get_assets')) {
    /**
     * Retorna os assets (scripts e links) relacionados a uma página específica, corrigindo o alinhamento.
     *
     * @param string $page Nome da página para a qual os assets devem ser retornados.
     * @param int $spaceCount Número de espaços a serem adicionados antes das linhas subsequentes.
     * @return string Tags HTML de scripts e links concatenadas, com alinhamento correto.
     */
    function get_assets($page, $spaceCount = 4): string
    {
        $assetsFile = APPPATH.'Views/assets/Assets.php';
        if (!file_exists($assetsFile)) {
            return '';
        }

        $assets = require $assetsFile;
        $pageAssets = $assets[$page] ?? [];

        if (empty($pageAssets)) {
            return '';
        }

        $spaces = str_repeat(' ', $spaceCount);
        $formattedAssets = [$pageAssets[0]];

        for ($i = 1; $i < count($pageAssets); $i++) {
            $formattedAssets[] = $spaces . $pageAssets[$i];
        }

        return implode("\n", $formattedAssets);
    }
}

if (!function_exists('get_scripts')) {
    /**
     * Retorna os dados relacionados a uma página específica, corrigindo o alinhamento.
     *
     * @param string $page Nome da página para a qual os assets devem ser retornados.
     * @param int $spaceCount Número de espaços a serem adicionados antes das linhas subsequentes.
     * @return string Dados de constante ou variáveis de uso no JS, com alinhamento correto.
     */
    function get_scripts($page, $spaceCount = 8): string
    {
        $scriptsFile = APPPATH . 'Views/assets/Scripts.php';
        if (!file_exists($scriptsFile)) {
            return '';
        }

        $scripts = require $scriptsFile;
        $pageAssets = $scripts[$page] ?? [];

        if (empty($pageAssets)) {
            return '';
        }

        $spaces = str_repeat(' ', $spaceCount);
        $formattedAssets = [];

        foreach ($pageAssets as $index => $asset) {
            $value = is_callable($asset) ? $asset() : $asset;
            $formattedAssets[] = ($index === 0) ? $value : $spaces . $value;
        }

        return implode("\n", $formattedAssets);
    }
}

if (!function_exists('format_datetime')) {
    /**
     * Formata um timestamp em data e hora com estilos personalizados.
     *
     * Exemplo de retorno: "11/09/2000 às 10:30:00"
     *
     * @param int $time Timestamp a ser formatado.
     * @param array $args Array com os formatos opcionais:
     *                    - 'date' => Formato da data (padrão: 'd/m/Y')
     *                    - 'time' => Formato da hora (padrão: 'H:i:s')
     *
     * @return string Data e hora formatadas.
     */
    function format_datetime(int $time = 0, array $args = []): string
    {
        if ($time <= 0) {
            return lang('Site.data_invalida');
        }

        $date_format = $args['date'] ?? 'd/m/Y';
        $time_format = $args['time'] ?? 'H:i:s';

        return date($date_format, $time) . ' ' . lang('Site.as') . ' ' . date($time_format, $time);
    }
}

if (! function_exists('swal_flash')) {
    /**
     * Registra flashdata para SweetAlert2 com títulos e botão padrão.
     * - Se $data for string, vira { title, text, confirmButtonText }.
     * - Se $data for array, só preenche o que faltar (title/confirmButtonText).
     * - Aliases aceitos: msg -> text, confirm -> confirmButtonText.
     *
     * @param 'success'|'error'|'warning'|'info' $type
     * @param string|array $data
     * @return void
     */
    function swal_flash(string $type, $data): void
    {
        $allowed = ['success','error','warning','info'];
        if (! in_array($type, $allowed, true)) {
            throw new InvalidArgumentException("Tipo inválido: {$type}");
        }

        $defaultTitles = [
            'success' => 'Sucesso',
            'error'   => 'Erro',
            'warning' => 'Atenção',
            'info'    => 'Informação',
        ];
        $defaultConfirm = 'Ok';

        // Normaliza para array
        $payload = is_array($data) ? $data : ['text' => (string) $data];

        // Aliases
        if (isset($payload['msg']) && ! isset($payload['text']) && ! isset($payload['html'])) {
            $payload['text'] = $payload['msg'];
            unset($payload['msg']);
        }
        if (isset($payload['confirm']) && ! isset($payload['confirmButtonText'])) {
            $payload['confirmButtonText'] = $payload['confirm'];
            unset($payload['confirm']);
        }

        // Defaults apenas se ausentes (podem ser sobrescritos por quem chamar)
        $payload['title'] = $payload['title'] ?? $defaultTitles[$type];
        $payload['confirmButtonText'] = $payload['confirmButtonText'] ?? $defaultConfirm;

        session()->setFlashdata($type, $payload);
    }
}

if (! function_exists('swal_success')) { /** @param string|array $data */ function swal_success($data): void { swal_flash('success', $data); } }
if (! function_exists('swal_error'))   { /** @param string|array $data */ function swal_error($data): void   { swal_flash('error',   $data); } }
if (! function_exists('swal_warning')) { /** @param string|array $data */ function swal_warning($data): void { swal_flash('warning', $data); } }
if (! function_exists('swal_info'))    { /** @param string|array $data */ function swal_info($data): void    { swal_flash('info',    $data); } }