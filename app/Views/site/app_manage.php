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

    .app-detail {
      margin-top: 4px;
    }

    .app-detail-grid {
      display: grid;
      grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);
      gap: 20px;
      align-items: flex-start;
    }

    .card-base {
      background-color: var(--color-card-bg);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-card-border);
      box-shadow: var(--shadow-soft);
      padding: 16px 18px 14px;
      transition:
        transform 0.15s ease,
        box-shadow 0.15s ease,
        border-color 0.15s ease,
        background-color 0.25s ease;
    }

    .card-base:hover {
      transform: translateY(-1px);
      box-shadow: 0 18px 35px -20px rgba(15, 23, 42, 0.9);
      border-color: rgba(129, 140, 248, 0.9);
    }

    /* Badge status */

    .badge {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      padding: 3px 9px;
      border-radius: 999px;
      font-size: 0.7rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
    }

    .badge-online {
      background-color: rgba(34, 197, 94, 0.18);
      color: #4ade80;
    }

    .badge-offline {
      background-color: rgba(248, 113, 113, 0.18);
      color: #fca5a5;
    }

    /* Card resumo da app */

    .app-summary-card {
      composes: card-base;
    }

    .app-summary-card {
      background-color: var(--color-card-bg);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-card-border);
      box-shadow: var(--shadow-soft);
      padding: 16px 18px 14px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .app-summary-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
    }

    .app-summary-title {
      display: flex;
      align-items: center;
      gap: 10px;
    }

    .app-summary-icon {
      width: 42px;
      height: 34px;
      border-radius: 14px;
      background: rgba(148, 163, 184, 0.12);
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .app-summary-icon i {
      font-size: 1.1rem;
      color: var(--color-primary);
    }

    .app-summary-name {
      font-size: 0.98rem;
      font-weight: 500;
    }

    .app-summary-sub {
      font-size: 0.78rem;
      color: var(--color-text-muted);
      margin-top: 2px;
    }

    .app-summary-body {
      margin-top: 6px;
      display: flex;
      flex-direction: column;
      gap: 4px;
    }

    .stat-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.85rem;
      padding: 5px 0;
      border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
    }

    .stat-row:last-child {
      border-bottom: none;
    }

    .stat-label {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--color-text-muted);
    }

    .stat-label i {
      font-size: 0.85rem;
    }

    .stat-value {
      font-size: 0.9rem;
    }

    .app-summary-footer {
      margin-top: 10px;
      padding-top: 8px;
      border-top: 1px solid rgba(148, 163, 184, 0.25);
      display: flex;
      flex-wrap: wrap;
      gap: 8px;
      justify-content: flex-end;
    }

    /* Botões */

    .btn-xs {
      border-radius: 999px;
      border: 0;
      font-size: 0.78rem;
      padding: 5px 10px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 4px;
      transition:
        background-color 0.15s ease,
        color 0.15s ease,
        box-shadow 0.15s ease;
    }

    .btn-xs i {
      font-size: 0.8rem;
    }

    .btn-soft {
      background-color: rgba(148, 163, 184, 0.12);
      color: var(--color-text);
    }

    .btn-soft:hover {
      background-color: rgba(148, 163, 184, 0.28);
      box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.9);
    }

    .btn-danger {
      background-color: rgba(239, 68, 68, 0.18);
      color: #fecaca;
    }

    .btn-danger:hover {
      background-color: rgba(239, 68, 68, 0.3);
      box-shadow: 0 8px 20px -14px rgba(239, 68, 68, 0.8);
    }

    /* Card de logs */

    .logs-card {
      background-color: var(--color-card-bg);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-card-border);
      box-shadow: var(--shadow-soft);
      padding: 12px 16px 14px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .logs-card-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding-bottom: 6px;
      border-bottom: 1px solid rgba(148, 163, 184, 0.35);
    }

    .log-tabs {
      display: inline-flex;
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.6);
      overflow: hidden;
      background-color: rgba(15, 23, 42, 0.9);
    }

    body.theme-light .log-tabs {
      background-color: #ffffff;
    }

    .log-tab-btn {
      border: 0;
      background: transparent;
      font-size: 0.8rem;
      padding: 6px 11px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--color-text-muted);
      cursor: pointer;
      transition:
        background-color 0.15s ease,
        color 0.15s ease;
    }

    .log-tab-btn i {
      font-size: 0.85rem;
    }

    .log-tab-btn.active {
      background-color: rgba(148, 163, 184, 0.18);
      color: var(--color-text);
    }

    .logs-actions {
      display: inline-flex;
      gap: 6px;
    }

    .icon-btn {
      width: 30px;
      height: 30px;
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.6);
      background: transparent;
      color: var(--color-text-muted);
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 0.85rem;
      transition:
        background-color 0.15s ease,
        color 0.15s ease,
        box-shadow 0.15s ease;
    }

    .icon-btn:hover {
      background-color: rgba(148, 163, 184, 0.18);
      color: var(--color-text);
      box-shadow: 0 6px 16px -12px rgba(15, 23, 42, 0.9);
    }

    .logs-card-body {
      margin-top: 4px;
    }

    .log-pane {
      display: none;
    }

    .log-pane.active {
      display: block;
    }

    .log-code {
      margin: 0;
      padding: 10px 12px;
      border-radius: 12px;
      background-color: #020617;
      border: 1px solid rgba(15, 23, 42, 0.8);
      max-height: 75vh;
      overflow-y: auto;
    }

    body.theme-light .log-code {
      background-color: #111827;
      border-color: rgba(15, 23, 42, 0.8);
      color: #e5e7eb;
    }

    .log-code code {
      font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
      font-size: 0.8rem;
      white-space: pre-wrap;
      word-break: break-word;
    }

    /* Modal .env */

    .env-modal-backdrop {
      position: fixed;
      inset: 0;
      background: rgba(15, 23, 42, 0.7);
      display: none;
      align-items: center;
      justify-content: center;
      z-index: 50;
    }

    .env-modal-backdrop.open {
      display: flex;
    }

    .env-modal {
      width: 100%;
      max-width: 720px;
      max-height: 90vh;
      background-color: var(--color-card-bg);
      border-radius: 18px;
      border: 1px solid var(--color-card-border);
      box-shadow: 0 25px 60px -30px rgba(15, 23, 42, 0.95);
      padding: 16px 18px 14px;
      display: flex;
      flex-direction: column;
      gap: 10px;
    }

    .env-modal-header {
      display: flex;
      align-items: center;
      justify-content: space-between;
      gap: 10px;
      padding-bottom: 4px;
      border-bottom: 1px solid rgba(148, 163, 184, 0.35);
    }

    .env-modal-title {
      font-size: 0.98rem;
      font-weight: 500;
    }

    .env-modal-close {
      border: 0;
      background: transparent;
      width: 30px;
      height: 30px;
      border-radius: 999px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      color: var(--color-text-muted);
      transition:
        background-color 0.15s ease,
        color 0.15s ease;
    }

    .env-modal-close:hover {
      background-color: rgba(148, 163, 184, 0.18);
      color: var(--color-text);
    }

    .env-modal-body {
      margin-top: 6px;
      overflow-y: auto;
    }

    .env-modal-body pre {
      margin: 0;
      max-height: 70vh;
    }

    @media (max-width: 900px) {
      .app-detail-grid {
        grid-template-columns: 1fr;
      }
    }

    @media (max-width: 640px) {
      .logs-card {
        padding: 12px 12px 12px;
      }
      .app-summary-card {
        padding: 14px 14px 12px;
      }
    }
  </style>

<header class="app-main-header">
  <h1>Logs da aplicação</h1>
  <p>Visualize métricas e saídas em tempo quase em tempo real do processo monitorado pelo painel.</p>
</header>

<section class="app-detail" id="appDetail"
         data-app-name="<?= esc($app['name'] ?? '') ?>">
  <div class="app-detail-grid">

    <!-- Card resumo da aplicação -->
    <article class="app-summary-card">
      <header class="app-summary-header">
        <div class="app-summary-title">
          <?php
            $rtSummary   = strtolower((string)($app['runtime'] ?? $app['type'] ?? ''));
            $nameSummary = (string)($app['name'] ?? '');

            $summaryIconWrapper = 'app-summary-icon';
            $summaryIconClass   = 'fa-solid fa-cube';

            if ($rtSummary === 'docker' || stripos($nameSummary, 'docker') !== false) {
              $summaryIconWrapper .= ' app-summary-icon-docker';
              $summaryIconClass    = 'fa-brands fa-docker';
            } elseif ($rtSummary === 'node' || stripos($nameSummary, 'node') !== false) {
              $summaryIconWrapper .= ' app-summary-icon-node';
              $summaryIconClass    = 'fa-brands fa-node-js';
            }
          ?>
          <div class="<?= esc($summaryIconWrapper) ?>">
            <i class="<?= esc($summaryIconClass) ?>"></i>
          </div>
          <div>
            <div class="app-summary-name"><?= esc($app['name'] ?? 'Aplicação') ?></div>
            <p class="app-summary-sub">Processo monitorado por este painel</p>
          </div>
        </div>

        <?php $online = ! empty($app['isOnline']); ?>
        <span class="badge <?= $online ? 'badge-online' : 'badge-offline' ?>">
          <?= $online ? 'online' : 'offline' ?>
        </span>
      </header>

      <div class="app-summary-body">
        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-solid fa-microchip"></i>
            <span>CPU</span>
          </div>
          <div class="stat-value"><?= esc($app['cpu'] ?? '0') ?>%</div>
        </div>

        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-solid fa-memory"></i>
            <span>Memória</span>
          </div>
          <div class="stat-value"><?= esc($app['mAs imagens são pré-definidas e não expõem dados pessoais.emory'] ?? '0 MB') ?></div>
        </div>

        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-regular fa-clock"></i>
            <span>Uptime</span>
          </div>
          <div class="stat-value"><?= esc($app['uptime'] ?? '—') ?></div>
        </div>

        <?php if (! empty($app['git_branch'])): ?>
        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-solid fa-code-branch"></i>
            <span>Git branch</span>
          </div>
          <div class="stat-value"><?= esc($app['git_branch']) ?></div>
        </div>
        <?php endif; ?>

        <?php if (! empty($app['git_commit'])): ?>
        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-solid fa-code"></i>
            <span>Git commit</span>
          </div>
          <div class="stat-value"><?= esc($app['git_commit']) ?></div>
        </div>
        <?php endif; ?>

        <?php if (! empty($app['env_file'])): ?>
        <div class="stat-row">
          <div class="stat-label">
            <i class="fa-regular fa-file-lines"></i>
            <span>Arquivo .env</span>
          </div>
          <div class="stat-value">
            <button type="button" class="btn-xs btn-soft" id="openEnvModal">
              <i class="fa-solid fa-eye"></i>
              Ver .env
            </button>
          </div>
        </div>
        <?php endif; ?>
      </div>

      <footer class="app-summary-footer">
        <?php if ($online): ?>
          <button type="button" class="btn-xs btn-soft"
                  onclick="pm2AppAction('<?= esc($app['name'] ?? '') ?>', 'reload')">
            <i class="fa-solid fa-rotate"></i>
            Reload
          </button>
          <button type="button" class="btn-xs btn-soft"
                  onclick="pm2AppAction('<?= esc($app['name'] ?? '') ?>', 'restart')">
            <i class="fa-solid fa-arrows-rotate"></i>
            Restart
          </button>
          <button type="button" class="btn-xs btn-danger"
                  onclick="pm2AppAction('<?= esc($app['name'] ?? '') ?>', 'stop')">
            <i class="fa-solid fa-stop"></i>
            Stop
          </button>
        <?php else: ?>
          <button type="button" class="btn-xs btn-soft"
                  onclick="pm2AppAction('<?= esc($app['name'] ?? '') ?>', 'restart')">
            <i class="fa-solid fa-arrows-rotate"></i>
            Restart
          </button>
        <?php endif; ?>
      </footer>
    </article>

    <!-- Card de logs -->
    <article class="logs-card">
      <header class="logs-card-header">
        <div class="log-tabs">
          <button type="button" class="log-tab-btn active"
                  data-target="stdout-pane">
            <i class="fa-solid fa-circle-check"></i>
            <span>STDOUT</span>
          </button>
          <button type="button" class="log-tab-btn"
                  data-target="stderr-pane">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <span>STDERR</span>
          </button>
        </div>

        <div class="logs-actions">
          <button type="button" class="icon-btn" onclick="nextLogs()" title="Carregar logs anteriores">
            <i class="fa-solid fa-arrow-up-long"></i>
          </button>
          <button type="button" class="icon-btn" onclick="refreshLogs()" title="Atualizar logs">
            <i class="fa-solid fa-rotate"></i>
          </button>
        </div>
      </header>

      <div class="logs-card-body">
        <div class="log-pane active"
             id="stdout-pane"
             data-log-type="stdout"
             data-next-key="<?= esc($logs['stdout']['nextKey'] ?? '') ?>">
          <pre class="log-code">
<code class="language-bash"><?= $logs['stdout']['lines'] ?? '' ?></code>
          </pre>
        </div>

        <div class="log-pane"
             id="stderr-pane"
             data-log-type="stderr"
             data-next-key="<?= esc($logs['stderr']['nextKey'] ?? '') ?>">
          <pre class="log-code">
<code class="language-bash"><?= $logs['stderr']['lines'] ?? '' ?></code>
          </pre>
        </div>
      </div>
    </article>

  </div>
</section>

<?php if (! empty($app['env_file'])): ?>
<div class="env-modal-backdrop" id="envModal">
  <div class="env-modal">
    <header class="env-modal-header">
      <h2 class="env-modal-title"><?= esc($app['name'] ?? '') ?> [.env]</h2>
      <button type="button" class="env-modal-close" id="closeEnvModal" aria-label="Fechar">
        <i class="fa-solid fa-xmark"></i>
      </button>
    </header>
    <div class="env-modal-body">
      <pre><code class="language-bash"><?= esc($app['env_file']) ?></code></pre>
    </div>
  </div>
</div>
<?php endif; ?>

<!--<script src="/assets/js/prism.js"></script>-->
<script>
  // Tabs de logs
  (function () {
    var tabButtons = document.querySelectorAll('.log-tab-btn');
    if (!tabButtons.length) return;

    tabButtons.forEach(function (btn) {
      btn.addEventListener('click', function () {
        var targetId = btn.getAttribute('data-target');
        if (!targetId) return;

        tabButtons.forEach(function (b) { b.classList.remove('active'); });
        btn.classList.add('active');

        var panes = document.querySelectorAll('.log-pane');
        panes.forEach(function (p) { p.classList.remove('active'); });

        var pane = document.getElementById(targetId);
        if (pane) {
          pane.classList.add('active');
        }
      });
    });
  })();

  function getActiveLogPane() {
    var pane = document.querySelector('.log-pane.active');
    if (!pane) return null;
    return {
      pane: pane,
      logType: pane.getAttribute('data-log-type'),
      nextKey: pane.getAttribute('data-next-key') || ''
    };
  }

  async function fetchLogs(logType, nextKey) {
    var root = document.getElementById('appDetail');
    if (!root) return null;
    var appName = root.getAttribute('data-app-name') || '';
    if (!logType || !appName) return null;

    var url = '/api/apps/' +
      encodeURIComponent(appName) +
      '/logs/' +
      encodeURIComponent(logType);

    if (nextKey) {
      url += '?nextKey=' + encodeURIComponent(nextKey);
    }

    try {
      var response = await fetch(url, {
        method: 'GET',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!response.ok) {
        console.error('Erro ao buscar logs');
        return null;
      }

      var data = await response.json();
      if (data && data.logs) {
        return data.logs;
      }
    } catch (e) {
      console.error(e);
    }
    return null;
  }

  function setLogsData(logType, logs, action) {
    var pane = document.querySelector('.log-pane[data-log-type="' + logType + '"]');
    if (!pane || !logs) return;

    var nextKey = (typeof logs.nextKey !== 'undefined') ? logs.nextKey : '';
    pane.setAttribute('data-next-key', nextKey);

    var codeEl = pane.querySelector('code');
    if (!codeEl) return;

    if (action === 'refresh') {
      codeEl.innerHTML = logs.lines || '';
    } else if (action === 'append') {
      codeEl.innerHTML = (codeEl.innerHTML || '') + '<br/>' + (logs.lines || '');
    } else if (action === 'prepend') {
      codeEl.innerHTML = (logs.lines || '') + '<br/>' + (codeEl.innerHTML || '');
    }

    if (window.Prism && typeof Prism.highlightElement === 'function') {
      Prism.highlightElement(codeEl);
    }
  }

  async function refreshLogs() {
    var data = getActiveLogPane();
    if (!data) return;

    var logs = await fetchLogs(data.logType, '');
    if (logs) {
      setLogsData(data.logType, logs, 'refresh');
    } else {
      console.log('Unable to fetch logs');
    }
  }

  async function nextLogs() {
    var data = getActiveLogPane();
    if (!data) return;

    var nextKey = data.nextKey;
    if (nextKey !== '' && !isNaN(parseInt(nextKey, 10)) && parseInt(nextKey, 10) < 0) {
      console.log('End of logs');
      return;
    }

    var logs = await fetchLogs(data.logType, nextKey);
    if (logs) {
      setLogsData(data.logType, logs, 'prepend');
    } else {
      console.log('Unable to fetch logs');
    }
  }

  // Modal do arquivo .env
  (function () {
    var openBtn = document.getElementById('openEnvModal');
    var modal = document.getElementById('envModal');
    if (!modal) return;
    var closeBtn = document.getElementById('closeEnvModal');

    function openModal() {
      modal.classList.add('open');
      document.body.classList.add('modal-open');
      if (window.Prism && typeof Prism.highlightAll === 'function') {
        Prism.highlightAll();
      }
    }

    function closeModal() {
      modal.classList.remove('open');
      document.body.classList.remove('modal-open');
    }

    if (openBtn) {
      openBtn.addEventListener('click', function () {
        openModal();
      });
    }

    if (closeBtn) {
      closeBtn.addEventListener('click', function () {
        closeModal();
      });
    }

    modal.addEventListener('click', function (e) {
      if (e.target === modal) {
        closeModal();
      }
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal.classList.contains('open')) {
        closeModal();
      }
    });
  })();

  // Ação PM2 (igual da página anterior)
  async function pm2AppAction(appName, action) {
    var labels = {
      reload: 'recarregar',
      restart: 'reiniciar',
      stop: 'parar'
    };

    const result = await Swal.fire({
      title: 'Confirmar ação',
      text: 'Deseja realmente ' + (labels[action] || action) + ' "' + appName + '"?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Sim',
      cancelButtonText: 'Cancelar',
      confirmButtonColor: '#4f46e5'
    });

    if (!result.isConfirmed) {
      return;
    }

    var url = '/api/apps/' +
      encodeURIComponent(appName) + '/' +
      encodeURIComponent(action);

    try {
      var response = await fetch(url, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest'
        }
      });

      if (!response.ok) {
        var msg = 'Falha ao executar ação.';
        try {
          var data = await response.json();
          if (data && data.message) {
            msg = data.message;
          }
        } catch (e) {}

        await Swal.fire('Erro', msg, 'error');
        return;
      }

      await Swal.fire('Sucesso', 'Ação executada com sucesso.', 'success');
      location.reload();
    } catch (e) {
      console.error(e);
      await Swal.fire('Erro', 'Erro de comunicação com o servidor.', 'error');
    }
  }

  if (window.Prism && typeof Prism.highlightAll === 'function') {
    Prism.highlightAll();
  }
</script>