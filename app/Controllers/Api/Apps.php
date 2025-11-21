<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;

class Apps extends BaseController
{
    /**
     * POST /api/apps/{appName}/{action}
     * action: reload | restart | stop
     */
    public function action(string $appName, string $action): ResponseInterface
    {
        $action = strtolower($action);

        if (! in_array($action, ['reload', 'restart', 'stop'], true)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'success' => false,
                    'message' => 'Ação inválida.',
                ]);
        }

        try {
            switch ($action) {
                case 'reload':
                    $this->pm2->reloadApp($appName);
                    break;
                case 'restart':
                    $this->pm2->restartApp($appName);
                    break;
                case 'stop':
                    $this->pm2->stopApp($appName);
                    break;
            }

            return $this->response->setJSON([
                'success' => true,
            ]);
        } catch (\Throwable $e) {
            log_message('error', 'Erro PM2 ({action}) em {app}: {msg}', [
                'action' => $action,
                'app'    => $appName,
                'msg'    => $e->getMessage(),
            ]);

            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_INTERNAL_SERVER_ERROR)
                ->setJSON([
                    'success' => false,
                    'message' => $e->getMessage(),
                ]);
        }
    }

    /**
     * GET /api/apps/{appName}/logs/{logType}
     * logType: stdout | stderr
     * query:  nextKey (opcional), linesPerRequest (opcional)
     */
    public function logs(string $appName, string $logType): ResponseInterface
    {
        $logType = strtolower($logType);

        if (! in_array($logType, ['stdout', 'stderr'], true)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_BAD_REQUEST)
                ->setJSON([
                    'error' => 'Log Type must be stdout or stderr',
                ]);
        }

        // parâmetros de query
        $nextKey        = $this->request->getGet('nextKey');
        $linesPerReqGet = $this->request->getGet('linesPerRequest');
        // compat: se um dia vier como linePerRequest, aceita também
        $linePerReqAlt  = $this->request->getGet('linePerRequest');

        $linesPerRequest = (int) ($linesPerReqGet ?? $linePerReqAlt ?? 200);
        if ($linesPerRequest < 1) {
            $linesPerRequest = 200;
        }

        // pegar info do app (e caminho dos logs) via PM2
        $app = $this->pm2->describeApp($appName);

        if (! $app) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'error' => 'Aplicação não encontrada no PM2.',
                ]);
        }

        $filePath = $logType === 'stdout'
            ? ($app['pm_out_log_path'] ?? null)
            : ($app['pm_err_log_path'] ?? null);

        if (! $filePath || ! is_readable($filePath)) {
            return $this->response
                ->setStatusCode(ResponseInterface::HTTP_NOT_FOUND)
                ->setJSON([
                    'error' => 'Arquivo de log não encontrado ou inacessível.',
                ]);
        }

        // leitura reversa, similar ao readLogsReverse do Node
        $logs = $this->readLogsReverse(
            $filePath,
            $nextKey !== null ? (int) $nextKey : null,
            $linesPerRequest
        );

        // converte ANSI -> HTML e junta com <br/>
        $htmlLines = array_map(
            fn ($line) => $this->ansiToHtml($line),
            $logs['lines'] ?? []
        );
        $logs['lines'] = implode('<br/>', $htmlLines);

        return $this->response->setJSON([
            'logs' => $logs,
        ]);
    }

    /**
     * Lê o arquivo de log "de trás pra frente" com base em nextKey, de forma aproximada
     * ao readLogsReverse do código Node.
     */
    private function readLogsReverse(string $filePath, ?int $endBytes, int $linesPerRequest): array
    {
        if (! $filePath || $linesPerRequest < 1 || ! is_readable($filePath)) {
            return [
                'lines'           => [],
                'nextKey'         => -1,
                'linesPerRequest' => $linesPerRequest,
            ];
        }

        $fileSize = filesize($filePath);
        if ($fileSize === false) {
            return [
                'lines'           => [],
                'nextKey'         => -1,
                'linesPerRequest' => $linesPerRequest,
            ];
        }

        $end = ($endBytes !== null && $endBytes >= 0)
            ? min($endBytes, $fileSize)
            : $fileSize;

        // heurística igual: linhas * 200 bytes
        $dataSize = $linesPerRequest * 200;
        $start    = max(0, $end - $dataSize);

        $fh = fopen($filePath, 'rb');
        if (! $fh) {
            return [
                'lines'           => [],
                'nextKey'         => -1,
                'linesPerRequest' => $linesPerRequest,
            ];
        }

        // lê do start até o fim do arquivo
        fseek($fh, $start);
        $data = '';
        while (! feof($fh)) {
            $chunk = fread($fh, 8192);
            if ($chunk === false) {
                break;
            }
            $data .= $chunk;
        }
        fclose($fh);

        // garantimos que só usamos até $end
        $maxLen = max(0, $end - $start);
        if (strlen($data) > $maxLen) {
            $data = substr($data, 0, $maxLen);
        }

        $lines = explode("\n", $data);
        // pega apenas as últimas (linesPerRequest + 1)
        $lines = array_slice($lines, -($linesPerRequest + 1));

        $joined       = implode("\n", $lines);
        $sentDataSize = strlen($joined);
        $nextKey      = $end - $sentDataSize;

        if ($nextKey < 0) {
            $nextKey = -1;
        }

        // remove a última linha (mesma lógica do Node que faz data.pop())
        array_pop($lines);

        return [
            'lines'           => $lines,
            'nextKey'         => $nextKey,
            'linesPerRequest' => $linesPerRequest,
        ];
    }

    /**
     * Conversão simples ANSI -> HTML (remove códigos ANSI e escapa HTML).
     * Se quiser cores reais, depois dá pra trocar por uma lib específica.
     */
    private function ansiToHtml(string $text): string
    {
        // remove códigos ANSI
        $text = preg_replace('/\x1b\[[0-9;]*m/', '', $text);

        // escapa HTML
        return htmlspecialchars($text, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
    }
}