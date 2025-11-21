<?php

namespace App\Libraries\Pm2;

class Services
{
    /**
     * Caminho do binário do PM2 (ajuste se necessário, ex: /usr/bin/pm2)
     */
    private string $pm2Bin;

    public function __construct(string $pm2Bin = 'pm2')
    {
        $this->pm2Bin = $pm2Bin;
    }

    /**
     * Executa pm2 <comando> <process> e retorna true em caso de sucesso.
     * Em erro lança RuntimeException (comportamento semelhante ao Promise reject).
     */
    public function runSimpleCommand(string $command, $process): bool
    {
        $process = (string) $process;

        $cmd = sprintf(
            '%s %s %s 2>&1',
            escapeshellcmd($this->pm2Bin),
            $command,
            escapeshellarg($process)
        );

        $output = [];
        $exit   = 0;

        exec($cmd, $output, $exit);

        if ($exit !== 0) {
            $msg = trim(implode("\n", $output));
            throw new \RuntimeException(
                "Falha ao executar pm2 {$command} em '{$process}': " . $msg
            );
        }

        return true;
    }

    /**
     * Converte bytes para tamanho legível.
     */
    public function bytesToSize(int $bytes): string
    {
        if ($bytes <= 0) {
            return '0 B';
        }

        $units = ['B', 'KB', 'MB', 'GB', 'TB'];
        $pow   = (int) floor(log($bytes, 1024));
        $pow   = min($pow, count($units) - 1);

        $value = $bytes / (1024 ** $pow);

        if ($pow === 0) {
            return $value . ' ' . $units[$pow];
        }

        return sprintf('%.1f %s', $value, $units[$pow]);
    }

    /**
     * Calcula uptime a partir de pm_uptime em ms (igual timeSince do Node).
     */
    public function timeSinceMs($ms): string
    {
        if (empty($ms)) {
            return '—';
        }

        // Converte ms para segundos usando divisão inteira (sem float)
        $start = intdiv((int) $ms, 1000);

        $diff = time() - $start;

        if ($diff < 0) {
            $diff = 0;
        }

        $days = intdiv($diff, 86400);
        $hours = intdiv($diff % 86400, 3600);
        $minutes = intdiv($diff % 3600, 60);

        if ($days > 0) {
            return sprintf('%dd %dh %dm', $days, $hours, $minutes);
        }

        return sprintf('%dh %dm', $hours, $minutes);
    }

    /**
     * Lê o conteúdo do arquivo .env do diretório da app.
     * Retorna null se não existir; lança exceção se houver outro erro de leitura.
     */
    public function getEnvFileContent(string $cwd, string $envFileName = '.env'): ?string
    {
        if ($cwd === '') {
            return null;
        }

        $envPath = rtrim($cwd, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . $envFileName;

        if (! is_file($envPath)) {
            // equivalente ao ENOENT do Node -> null
            return null;
        }

        $content = @file_get_contents($envPath);

        if ($content === false) {
            throw new \RuntimeException("Não foi possível ler o arquivo .env em {$envPath}");
        }

        return $content;
    }

    /**
     * Retorna o branch atual do Git (ou null se não for repositório / erro).
     */
    public function getGitBranch(string $cwd): ?string
    {
        if ($cwd === '') {
            return null;
        }

        $cmd = sprintf(
            'cd %s && git rev-parse --abbrev-ref HEAD 2>&1',
            escapeshellarg($cwd)
        );

        $output = [];
        $exit   = 0;
        exec($cmd, $output, $exit);

        if ($exit !== 0 || empty($output)) {
            return null;
        }

        return trim(implode("\n", $output));
    }

    /**
     * Retorna o commit atual (hash curto) do Git (ou null).
     */
    public function getGitCommit(string $cwd): ?string
    {
        if ($cwd === '') {
            return null;
        }

        $cmd = sprintf(
            'cd %s && git rev-parse --short HEAD 2>&1',
            escapeshellarg($cwd)
        );

        $output = [];
        $exit   = 0;
        exec($cmd, $output, $exit);

        if ($exit !== 0 || empty($output)) {
            return null;
        }

        return trim(implode("\n", $output));
    }
}