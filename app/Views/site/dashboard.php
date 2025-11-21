<style>
.app-main-header {
  margin-bottom: 18px;
}

.app-main-header h1 {
  font-size: 1.1rem;
  letter-spacing: 0.04em;
  text-transform: uppercase;
}

.app-main-header p {
  font-size: 0.85rem;
  color: var(--color-text-muted);
  margin-top: 4px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 16px;
  margin-bottom: 20px;
}

.stat-card {
  background-color: var(--color-card-bg);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-card-border);
  box-shadow: var(--shadow-soft);
  padding: 14px 16px;
  display: flex;
  flex-direction: column;
  gap: 6px;
  transition:
    transform 0.15s ease,
    box-shadow 0.15s ease,
    border-color 0.15s ease,
    background-color 0.25s ease;
}

.stat-card:hover {
  transform: translateY(-2px);
  box-shadow: 0 18px 35px -20px rgba(15, 23, 42, 0.9);
  border-color: rgba(129, 140, 248, 0.9);
}

.stat-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
}

.stat-title {
  font-size: 0.8rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--color-text-muted);
}

.stat-icon {
  width: 34px;
  height: 34px;
  border-radius: 12px;
  background-color: rgba(148, 163, 184, 0.14);
  display: flex;
  align-items: center;
  justify-content: center;
}

.stat-icon i {
  font-size: 0.9rem;
}

/* cores padrão (tema escuro) */
.stat-card-total .stat-icon {
  background-color: rgba(56, 189, 248, 0.18);
  color: #7dd3fc;
}

.stat-card-online .stat-icon {
  background-color: rgba(34, 197, 94, 0.18);
  color: #4ade80;
}

.stat-card-offline .stat-icon {
  background-color: rgba(248, 113, 113, 0.18);
  color: #fecaca;
}

/* tema claro: ícones dos cards com contraste melhor */
body.theme-light .stat-card-total .stat-icon {
  background-color: #e0f2fe; /* azul bem claro */
  color: #0369a1;           /* azul mais escuro para o ícone */
}

body.theme-light .stat-card-online .stat-icon {
  background-color: #dcfce7;
  color: #166534;
}

body.theme-light .stat-card-offline .stat-icon {
  background-color: #fee2e2;
  color: #b91c1c;
}

.stat-value {
  font-size: 1.4rem;
  font-weight: 600;
}

.stat-subtext {
  font-size: 0.8rem;
  color: var(--color-text-muted);
}

.online-indicator {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  font-size: 0.78rem;
  color: var(--color-text-muted);
}

.online-dot {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background-color: #22c55e;
}

.offline-dot {
  width: 8px;
  height: 8px;
  border-radius: 999px;
  background-color: #ef4444;
}

.apps-table-card {
  margin-top: 10px;
  background-color: var(--color-card-bg);
  border-radius: var(--radius-lg);
  border: 1px solid var(--color-card-border);
  box-shadow: var(--shadow-soft);
  padding: 14px 16px;
}

.apps-table-card-header {
  display: flex;
  align-items: center;
  justify-content: space-between;
  gap: 8px;
  margin-bottom: 10px;
}

.apps-table-card-header h2 {
  font-size: 0.95rem;
}

.apps-table-card-header p {
  font-size: 0.8rem;
  color: var(--color-text-muted);
}

table.apps-table {
  width: 100%;
  border-collapse: collapse;
  font-size: 0.8rem;
}

.apps-table thead {
  font-size: 0.75rem;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  color: var(--color-text-muted);
}

.apps-table th,
.apps-table td {
  padding: 6px 4px;
  text-align: left;
  border-bottom: 1px solid rgba(148, 163, 184, 0.25);
}

.apps-table tbody tr:last-child td {
  border-bottom: none;
}

.status-pill {
  display: inline-flex;
  align-items: center;
  gap: 6px;
  padding: 2px 8px;
  border-radius: 999px;
  font-size: 0.72rem;
  text-transform: uppercase;
  letter-spacing: 0.06em;
}

.status-pill.online {
  background-color: rgba(34, 197, 94, 0.15);
  color: #4ade80;
}

.status-pill.offline {
  background-color: rgba(248, 113, 113, 0.15);
  color: #fca5a5;
}

/* tema claro: status-pill mais legível */
body.theme-light .status-pill.online {
  background-color: #dcfce7;
  color: #166534;
}

body.theme-light .status-pill.offline {
  background-color: #fee2e2;
  color: #991b1b;
}

.status-pill i {
  font-size: 0.7rem;
}

.apps-table a {
  color: var(--color-primary);
  text-decoration: none;
  font-weight: 500;
}

.apps-table a:hover {
  text-decoration: underline;
}

.app-row-main {
  display: flex;
  align-items: center;
  gap: 8px;
}

/* Ajuste do ícone dentro da tabela para bater com os cards */
.apps-table .app-row-main .app-icon {
  width: 26px;
  height: 26px;
  border-radius: 10px;
  box-shadow: 0 10px 25px -18px rgba(15, 23, 42, 0.9);
}

/* Garantia de cores (caso não venham do CSS global) */
.apps-table .app-icon-node {
  color: #22c55e;
}

.apps-table .app-icon-docker {
  color: #0ea5e9;
}

@media (max-width: 640px) {
  .apps-table thead {
    display: none;
  }

  .apps-table tr {
    display: block;
    border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    margin-bottom: 8px;
    padding-bottom: 6px;
  }

  .apps-table td {
    display: flex;
    justify-content: space-between;
    border-bottom: none;
  }

  .apps-table td::before {
    content: attr(data-label);
    font-weight: 500;
    color: var(--color-text-muted);
    margin-right: 10px;
  }
}

</style>

<header class="app-main-header">
  <h1>Dashboard</h1>
  <p>Resumo geral das aplicações monitoradas.</p>
</header>

<section class="stats-grid">
  <article class="stat-card stat-card-total">
    <div class="stat-header">
      <div>
        <div class="stat-title">Total de aplicações</div>
        <div class="stat-value"><?= esc($totalApps) ?></div>
      </div>
      <div class="stat-icon">
        <i class="fa-solid fa-cubes"></i>
      </div>
    </div>
    <div class="stat-subtext">
      Todas as aplicações atualmente visíveis no painel.
    </div>
  </article>

  <article class="stat-card stat-card-online">
    <div class="stat-header">
      <div>
        <div class="stat-title">Aplicações online</div>
        <div class="stat-value"><?= esc($onlineApps) ?></div>
      </div>
      <div class="stat-icon">
        <i class="fa-solid fa-circle-check"></i>
      </div>
    </div>
    <div class="stat-subtext">
      <span class="online-indicator">
        <span class="online-dot"></span>
        <?= esc($onlinePercent) ?>% do total
      </span>
    </div>
  </article>

  <article class="stat-card stat-card-offline">
    <div class="stat-header">
      <div>
        <div class="stat-title">Aplicações offline</div>
        <div class="stat-value"><?= esc($offlineApps) ?></div>
      </div>
      <div class="stat-icon">
        <i class="fa-solid fa-circle-xmark"></i>
      </div>
    </div>
    <div class="stat-subtext">
      <span class="online-indicator">
        <span class="offline-dot"></span>
        Verifique se estão paradas por opção.
      </span>
    </div>
  </article>
</section>

<section class="apps-table-card">
  <header class="apps-table-card-header">
    <div>
      <h2>Aplicações recentes</h2>
      <p>Lista resumida das aplicações e seus estados atuais.</p>
    </div>
    <a href="<?= site_url('apps') ?>" style="font-size:0.8rem; text-decoration:none; color:var(--color-primary);">
      <i class="fa-solid fa-arrow-up-right-from-square"></i>
      Ver todas
    </a>
  </header>

  <?php if (! empty($apps)): ?>
    <div style="overflow-x:auto;">
      <table class="apps-table">
        <thead>
          <tr>
            <th>Aplicação</th>
            <th>Status</th>
            <th>CPU</th>
            <th>Memória</th>
            <th>Uptime</th>
          </tr>
        </thead>
        <tbody>
          <?php foreach ($apps as $app): ?>
            <tr>
              <td data-label="Aplicação">
                <?php
                  $rt   = strtolower((string)($app['runtime'] ?? $app['type'] ?? ''));
                  $name = (string)($app['name'] ?? '');

                  $wrapperClasses = 'app-icon';
                  $iconClass      = 'fa-solid fa-cube';

                  if ($rt === 'docker' || stripos($name, 'docker') !== false) {
                    $wrapperClasses .= ' app-icon-docker';
                    $iconClass       = 'fa-brands fa-docker';
                  } elseif ($rt === 'node' || stripos($name, 'node') !== false) {
                    $wrapperClasses .= ' app-icon-node';
                    $iconClass       = 'fa-brands fa-node-js';
                  }
                ?>
                <div class="app-row-main">
                  <div class="<?= esc($wrapperClasses) ?>">
                    <i class="<?= esc($iconClass) ?>"></i>
                  </div>
                  <a href="<?= url_to('app.manage', $name) ?>">
                    <?= esc($name) ?>
                  </a>
                </div>
              </td>

              <td data-label="Status">
                <?php $isOnline = ! empty($app['isOnline']); ?>
                <span class="status-pill <?= $isOnline ? 'online' : 'offline' ?>">
                  <i class="fa-solid <?= $isOnline ? 'fa-circle' : 'fa-circle-xmark' ?>"></i>
                  <?= $isOnline ? 'online' : 'offline' ?>
                </span>
              </td>

              <td data-label="CPU">
                <?= esc($app['cpu']) ?>%
              </td>
              <td data-label="Memória">
                <?= esc($app['memory']) ?>
              </td>
              <td data-label="Uptime">
                <?= esc($app['uptime']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p style="font-size:0.85rem; color:var(--color-text-muted);">
      Nenhuma aplicação encontrada.
    </p>
  <?php endif; ?>
</section>
