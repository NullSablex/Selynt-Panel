<?php

namespace App\Libraries\Pm2;

class Pm2
{
    /**
     * Caminho do binário do PM2 (ajuste se necessário, ex: /usr/bin/pm2)
     */
    private string $pm2Bin;

    /**
     * Serviço de utilidades.
     */
    private Services $services;

    public function __construct(string $pm2Bin = 'pm2')
    {
        $this->pm2Bin   = $pm2Bin;
        $this->services = new Services($pm2Bin);
    }

    /**
     * Lista todos os apps do PM2 (equivalente ao listApps() do Node).
     */
    public function listApps(): array
    {
        $cmd    = escapeshellcmd($this->pm2Bin) . ' jlist 2>/dev/null';
        $output = shell_exec($cmd);

        if ($output === null || $output === '') {
            return [];
        }

        $data = json_decode($output, true);
        if (! is_array($data)) {
            return [];
        }

        $apps = [];

        foreach ($data as $app) {
            $name      = $app['name'] ?? ($app['pm2_env']['name'] ?? 'unknown');
            $status    = $app['pm2_env']['status'] ?? 'unknown';
            $cpu       = $app['monit']['cpu'] ?? 0;
            $memory    = $app['monit']['memory'] ?? 0;
            $pmUptime  = $app['pm2_env']['pm_uptime'] ?? null;
            $pmId      = $app['pm_id'] ?? null;
            $instances = $app['pm2_env']['instances'] ?? 1;

            // Runtime (node, python, bash, none/binary, etc.)
            $interpreterRaw = $app['pm2_env']['runtime'] ?? $app['pm2_env']['exec_interpreter'] ?? '';
            $runtime = strtolower(basename((string) $interpreterRaw));
            $execMode = strtolower((string) ($app['pm2_env']['exec_mode'] ?? ''));

            $apps[] = [
                'name'       => $name,
                'status'     => $status,
                'badgeClass' => $status === 'online' ? 'badge-online' : 'badge-offline',
                'isOnline'   => $status === 'online',
                'cpu'        => $cpu,
                'memory'     => $this->services->bytesToSize((int) $memory),
                'uptime'     => $this->services->timeSinceMs($pmUptime),
                'pm_id'      => $pmId,
                'instances'  => $instances,
                'runtime'    => $runtime,
                'exec_mode' => $execMode,
            ];
        }

        return $apps;
    }

    /**
     * Retorna detalhes de um processo gerenciado pelo PM2.
     *
     * A busca é feita pelo nome do processo ou pelo pm_id informado
     * em $process. Caso não seja encontrado, retorna null.
     *
     * @param string $process Nome do processo ou ID (pm_id) do PM2.
     *
     * @return array<string, mixed>|null Detalhes normalizados do processo ou null se não encontrado.
     */
    public function describeApp(string $process): ?array
    {
        $cmd = escapeshellcmd($this->pm2Bin) . ' jlist 2>/dev/null';
        $output = shell_exec($cmd);

        if ($output === null || $output === '') {
            return null;
        }

        $data = json_decode($output, true);
        if (!is_array($data)) {
            return null;
        }

        foreach ($data as $app) {
            $name = $app['name'] ?? ($app['pm2_env']['name'] ?? '');
            $pmId = (string) ($app['pm_id'] ?? '');

            if ($process !== '' && ((string) $name === $process || $pmId === $process)) {
                $status = $app['pm2_env']['status'] ?? 'unknown';
                $cpu = $app['monit']['cpu'] ?? 0;
                $memory = $app['monit']['memory'] ?? 0;
                $pmUptime = $app['pm2_env']['pm_uptime'] ?? null;

                $pmOutLog = $app['pm2_env']['pm_out_log_path'] ?? null;
                $pmErrLog = $app['pm2_env']['pm_err_log_path'] ?? null;
                $pmCwd = $app['pm2_env']['pm_cwd'] ?? null;

                // Mesmo tratamento de runtime usado em listApps()
                $interpreterRaw = $app['pm2_env']['runtime']
                    ?? $app['pm2_env']['exec_interpreter']
                    ?? '';

                $runtime = strtolower(basename((string) $interpreterRaw));
                $execMode = strtolower((string) ($app['pm2_env']['exec_mode'] ?? ''));

                return [
                    'name' => $name,
                    'status' => $status,
                    'cpu' => $cpu,
                    'memory' => $this->services->bytesToSize((int) $memory),
                    'uptime' => $this->services->timeSinceMs($pmUptime),
                    'pm_id' => $app['pm_id'] ?? null,
                    'pm_out_log_path' => $pmOutLog,
                    'pm_err_log_path' => $pmErrLog,
                    'pm2_env_cwd' => $pmCwd,
                    'runtime' => $runtime,   // ex.: node, python, bash, etc.
                    'exec_mode' => $execMode,  // ex.: fork_mode, cluster_mode
                ];
            }
        }

        return null;
    }

    public function reloadApp($process): bool
    {
        return $this->services->runSimpleCommand('reload', $process);
    }

    public function stopApp($process): bool
    {
        return $this->services->runSimpleCommand('stop', $process);
    }

    public function restartApp($process): bool
    {
        return $this->services->runSimpleCommand('restart', $process);
    }

    /**
     * Proxy para leitura do .env.
     */
    public function getEnvFile(string $cwd, string $envFileName = '.env'): ?string
    {
        return $this->services->getEnvFileContent($cwd, $envFileName);
    }

    /**
     * Proxy para branch Git.
     */
    public function getGitBranch(string $cwd): ?string
    {
        return $this->services->getGitBranch($cwd);
    }

    /**
     * Proxy para commit Git (hash curto).
     */
    public function getGitCommit(string $cwd): ?string
    {
        return $this->services->getGitCommit($cwd);
    }

    /**
     * Leitura reversa de logs (igual já estava).
     */
    public function readLogsReverse(string $filePath, ?int $endBytes, int $linesPerRequest): array
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

        $maxLen = max(0, $end - $start);
        if (strlen($data) > $maxLen) {
            $data = substr($data, 0, $maxLen);
        }

        $lines = explode("\n", $data);
        $lines = array_slice($lines, -($linesPerRequest + 1));

        $joined       = implode("\n", $lines);
        $sentDataSize = strlen($joined);
        $nextKey      = $end - $sentDataSize;

        if ($nextKey < 0) {
            $nextKey = -1;
        }

        array_pop($lines);

        return [
            'lines'           => $lines,
            'nextKey'         => $nextKey,
            'linesPerRequest' => $linesPerRequest,
        ];
    }
}