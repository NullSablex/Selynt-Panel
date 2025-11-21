<div class="app-main-header">
  <div>
    <h1>Aplicações</h1>
    <p>Visão geral dos processos gerenciados.</p>
  </div>

  <div class="main-header-actions">
    <div class="view-switcher">
      <button type="button" class="view-toggle active" data-view="grid">
        <i class="fa-solid fa-border-all"></i>
        Grade
      </button>
      <button type="button" class="view-toggle" data-view="list">
        <i class="fa-solid fa-list"></i>
        Lista
      </button>
    </div>

    <button type="button" class="btn-outline" onclick="location.reload()">
      <i class="fa-solid fa-rotate-right"></i>
      Atualizar
    </button>
  </div>
</div>

<section class="app-grid">
  <?php if (! empty($apps)): ?>
    <?php foreach ($apps as $app): ?>
      <?php
        // Detecta tipo para aplicar ícone / cor
        $runtime = strtolower((string)($app['runtime'] ?? $app['type'] ?? ''));
        $name    = (string)($app['name'] ?? '');

        $iconWrapperClass = 'app-icon';
        $iconClass        = 'fa-solid fa-cube';

        if ($runtime === 'node' || stripos($name, 'node') !== false) {
          $iconWrapperClass = 'app-icon app-icon-node';
          $iconClass        = 'fa-brands fa-node-js';
        } elseif ($runtime === 'docker' || stripos($name, 'docker') !== false) {
          $iconWrapperClass = 'app-icon app-icon-docker';
          $iconClass        = 'fa-brands fa-docker';
        }
      ?>
      <article class="app-card">
        <header class="app-card-header">
          <div class="app-header-main">
            <div class="<?= esc($iconWrapperClass) ?>">
              <i class="<?= esc($iconClass) ?>"></i>
            </div>
            <div class="app-info">
              <div class="app-name"
                   onclick="location.href='<?= url_to('app.manage', $app['name'])?>';">
                <?= esc($app['name']) ?>
              </div>
              <div class="app-meta">
                ID #<?= esc($app['pm_id']) ?>
                <?php if (! empty($app['port'])): ?>
                  &bull; Porta <?= esc($app['port']) ?>
                <?php endif; ?>
                <?php if (! empty($app['env'])): ?>
                  &bull; Ambiente: <?= esc($app['env']) ?>
                <?php endif; ?>
                <?php if (empty($app['port']) && empty($app['env'])): ?>
                  &bull; Uptime: <?= esc($app['uptime']) ?>
                <?php endif; ?>
              </div>
            </div>
          </div>
          <span class="badge <?= esc($app['badgeClass']) ?>">
            <?= esc($app['status']) ?>
          </span>
        </header>

        <div class="app-metrics">
          <div class="metric">
            <span class="metric-label">
              <i class="fa-solid fa-microchip"></i>
              CPU
            </span>
            <span class="metric-value"><?= esc($app['cpu']) ?>%</span>
          </div>
          <div class="metric">
            <span class="metric-label">
              <i class="fa-solid fa-memory"></i>
              Memória
            </span>
            <span class="metric-value"><?= esc($app['memory']) ?></span>
          </div>
          <div class="metric">
            <span class="metric-label">
              <i class="fa-solid fa-clock"></i>
              Uptime
            </span>
            <span class="metric-value"><?= esc($app['uptime']) ?></span>
          </div>
          <div class="metric">
            <span class="metric-label">
              <i class="fa-solid fa-code-branch"></i>
              Instâncias
            </span>
            <span class="metric-value">
              <?= esc($app['instances'] ?? 1) ?>
            </span>
          </div>
        </div>

        <footer class="app-card-footer">
          <?php if (! empty($app['isOnline'])): ?>
            <button type="button" class="btn-xs btn-soft"
                    onclick="pm2AppAction('<?= esc($app['name'], 'js') ?>', 'reload')">
              <i class="fa-solid fa-rotate"></i>
              Reload
            </button>
            <button type="button" class="btn-xs btn-soft"
                    onclick="pm2AppAction('<?= esc($app['name'], 'js') ?>', 'restart')">
              <i class="fa-solid fa-arrows-rotate"></i>
              Restart
            </button>
            <button type="button" class="btn-xs btn-danger"
                    onclick="pm2AppAction('<?= esc($app['name'], 'js') ?>', 'stop')">
              <i class="fa-solid fa-stop"></i>
              Stop
            </button>
          <?php else: ?>
            <button type="button" class="btn-xs btn-soft"
                    onclick="pm2AppAction('<?= esc($app['name'], 'js') ?>', 'restart')">
              <i class="fa-solid fa-arrows-rotate"></i>
              Restart
            </button>
          <?php endif; ?>
        </footer>
      </article>
    <?php endforeach; ?>
  <?php else: ?>
    <p style="font-size:0.9rem; color:var(--color-text-muted);">
      Nenhuma aplicação encontrada.
    </p>
  <?php endif; ?>
</section>

<?= $pager_links ?>