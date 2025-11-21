<?php

namespace App\Filters;

use CodeIgniter\HTTP\{
    RequestInterface,
    ResponseInterface,
    CLIRequest
};
use CodeIgniter\Filters\FilterInterface;
use Config\{Services, App};

class Language implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $session   = Services::session();
        $language  = Services::language();
        $supported = config(App::class)->supportedLocales;

        if ($request instanceof CLIRequest) {
            $locale = $session->get('panel_lang') ?? 'pt-BR';
        } else {
            $negotiated = method_exists($request, 'negotiate')
                ? $request->negotiate('language', $supported)
                : null;

            $locale = $session->get('panel_lang') ?? $negotiated ?? 'pt-BR';
        }

        $language->setLocale($locale);

        if (!$session->has('panel_lang')) {
            $session->set('panel_lang', $locale);
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // N/A
    }
}