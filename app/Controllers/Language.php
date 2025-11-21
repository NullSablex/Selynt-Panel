<?php
declare(strict_types=1);

namespace App\Controllers;
use CodeIgniter\HTTP\{RedirectResponse, ResponseInterface};
use Config\App;

class Language extends BaseController {

    public function switch($locale): RedirectResponse
    {
        $config = new App();
        $supportedLocales = $config->supportedLocales;
        $lang = esc($locale);

        if (in_array($locale, $supportedLocales)) {
            $this->session->set('panel_lang', $lang);
        }

        return redirect()->back();
    }

    public function langs(): ResponseInterface
    {
        $current = $this->session->get('panel_lang');
        $basePath = APPPATH . 'Language' . DIRECTORY_SEPARATOR;

        $langsByCode = [];

        if (is_dir($basePath)) {
            foreach (scandir($basePath) as $dir) {
                if ($dir === '.' || $dir === '..') {
                    continue;
                }

                $jsonFile = $basePath . $dir . DIRECTORY_SEPARATOR . 'lang.json';
                if (!is_file($jsonFile)) {
                    continue;
                }

                $json = file_get_contents($jsonFile);
                if ($json === false) {
                    continue;
                }

                $data = json_decode($json, true);

                if (!is_array($data)) {
                    continue;
                }

                foreach ($data as $item) {
                    if (!is_array($item) || !isset($item['code'])) {
                        continue;
                    }

                    $code = $item['code'];
                    $item['active'] = ($current === $code);
                    $langsByCode[$code] = $item;
                }
            }
        }

        $langs = array_values($langsByCode);
        return $this->response->setJSON($langs);
    }
}