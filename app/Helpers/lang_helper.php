<?php

if (!function_exists('listSupportedLanguages')) {
    /**
     * Retorna os idiomas suportados com nomes legíveis e seus códigos abreviados.
     * A lista é ordenada pelo campo "order" e inclui apenas idiomas com "status: true".
     *
     * @return array Array com os idiomas suportados (apenas nome legível e código).
     */
    function listSupportedLanguages(): array
    {
        $filePath = APPPATH.'Language/langs.json';

        if (!file_exists($filePath)) {
            throw new \RuntimeException('O arquivo langs.json não foi encontrado.');
        }

        $languages = json_decode(file_get_contents($filePath), true);
        if (json_last_error() !== JSON_ERROR_NONE || !is_array($languages)) {
            throw new \RuntimeException('Erro ao decodificar o arquivo langs.json: '.json_last_error_msg());
        }

        $supportedLocales = config('App')->supportedLocales ?? array_keys($languages);
        $filteredLanguages = [];
        foreach ($languages as $code => $data) {
            if (in_array($code, $supportedLocales) && ($data['status'] ?? false) === true) {
                $filteredLanguages[$code] = $data;
            }
        }

        uasort($filteredLanguages, fn($a, $b) => $a['order'] <=> $b['order']);
        $result = [];
        foreach ($filteredLanguages as $code => $data) {
            $result[$code] = $data['name'];
        }

        return $result;
    }
}

if (!function_exists('lang_name_user')) {
    /**
     * Obtém o nome do idioma do usuário com base no site_lang armazenado na sessão.
     *
     * @return string Nome do idioma ou 'Unknown' se não encontrado.
     */
    function lang_name_user(): string
    {
        $currentLang = session('panel_lang');
        $languages = listSupportedLanguages();
        return $languages[$currentLang] ?? 'Unknown';
    }
}