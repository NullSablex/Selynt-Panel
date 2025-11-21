<!DOCTYPE html>
<html lang="<?= service('request')->getLocale();?>">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title.' | Selynt Panel';?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
    :root {
      --color-primary: #4f46e5;
      --color-primary-dark: #3730a3;

      --color-bg: #020617;
      --color-bg-soft: #020617;
      --color-card-bg: #020617;
      --color-card-border: rgba(148, 163, 184, 0.35);

      --color-text: #e5e7eb;
      --color-text-muted: #9ca3af;
      --color-error: #ef4444;

      --radius-lg: 12px;
      --radius-pill: 999px;

      --shadow-soft: 0 18px 40px -24px rgba(15, 23, 42, 0.9);
    }

    /* Tema claro (ativar com class="theme-light" no <body>) */
    body.theme-light {
      --color-bg: #f3f4f6;
      --color-bg-soft: #e5e7eb;
      --color-card-bg: #ffffff;
      --color-card-border: rgba(156, 163, 175, 0.7);

      --color-text: #111827;
      --color-text-muted: #6b7280;

      --shadow-soft: 0 18px 40px -24px rgba(15, 23, 42, 0.2);
    }

    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      min-height: 100vh;
      font-family: system-ui, -apple-system, BlinkMacSystemFont, "Segoe UI", sans-serif;
      background-color: var(--color-bg);
      background-image:
        radial-gradient(circle at top, rgba(79, 70, 229, 0.16), transparent 55%),
        linear-gradient(to bottom, var(--color-bg-soft), var(--color-bg));
      color: var(--color-text);
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 16px;
    }

    .card {
      width: 100%;
      max-width: 480px;
      background-color: var(--color-card-bg);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-card-border);
      box-shadow: var(--shadow-soft);
      padding: 18px 20px 16px;
      text-align: left;
    }

    .card-topbar {
      display: flex;
      justify-content: flex-end;
      margin-bottom: 8px;
    }

    .card-header {
      display: flex;
      align-items: center;
      gap: 10px;
      margin-bottom: 10px;
    }

    .icon-badge {
      width: 38px;
      height: 38px;
      border-radius: 14px;
      display: flex;
      align-items: center;
      justify-content: center;
      background-color: rgba(248, 113, 113, 0.18);
      border: 1px solid rgba(248, 113, 113, 0.6);
      color: #fecaca;
    }

    .icon-badge i {
      font-size: 1.1rem;
    }

    .card-header h1 {
      font-size: 1rem;
      text-transform: uppercase;
      letter-spacing: 0.06em;
    }

    .card-header p {
      font-size: 0.85rem;
      color: var(--color-text-muted);
      margin-top: 2px;
    }

    .card-body {
      margin-top: 6px;
      font-size: 0.85rem;
      color: var(--color-text-muted);
    }

    .card-body p {
      margin-bottom: 8px;
    }

    .card-footer {
      margin-top: 12px;
      display: flex;
      justify-content: space-between;
      gap: 8px;
      align-items: center;
      font-size: 0.8rem;
      color: var(--color-text-muted);
      flex-wrap: wrap;
    }

    .btn-pill {
      border-radius: 999px;
      border: 0;
      font-size: 0.8rem;
      padding: 7px 12px;
      cursor: pointer;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      text-decoration: none;
      background-color: rgba(148, 163, 184, 0.14);
      color: var(--color-text);
      transition:
        background-color 0.15s ease,
        color 0.15s ease,
        box-shadow 0.15s ease;
    }

    .btn-pill:hover {
      background-color: rgba(148, 163, 184, 0.26);
      box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.9);
    }

    /* Botão de tema */
    .theme-toggle {
      border-radius: 999px;
      border: 1px solid rgba(148, 163, 184, 0.6);
      background-color: rgba(15, 23, 42, 0.8);
      color: var(--color-text-muted);
      width: 42px;
      height: 26px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      cursor: pointer;
      font-size: 0.9rem;
      transition:
        background-color 0.15s ease,
        color 0.15s ease,
        box-shadow 0.15s ease,
        border-color 0.15s ease;
    }

    .theme-toggle i {
      pointer-events: none;
    }

    .theme-toggle .icon-sun {
      display: none;
    }

    body.theme-light .theme-toggle {
      background-color: #ffffff;
    }

    body.theme-light .theme-toggle .icon-moon {
      display: none;
    }

    body.theme-light .theme-toggle .icon-sun {
      display: inline-block;
    }

    /* Ajustes tema claro */
    body.theme-light .card {
      background-color: var(--color-card-bg);
      border-color: var(--color-card-border);
    }

    body.theme-light .icon-badge {
      background-color: rgba(254, 226, 226, 0.9);
      border-color: rgba(239, 68, 68, 0.7);
      color: #b91c1c;
    }

    body.theme-light .card-body,
    body.theme-light .card-header p,
    body.theme-light .card-footer {
      color: var(--color-text-muted);
    }

    body.theme-light .btn-pill {
      background-color: #e5e7eb;
      color: #111827;
    }

    body.theme-light .btn-pill:hover {
      background-color: #d1d5db;
      box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.35);
    }

    @media (max-width: 480px) {
      .card-footer {
        flex-direction: column-reverse;
        align-items: flex-start;
      }
    }
  </style>
</head>
<body>
  <div class="card">
    <div class="card-topbar">
      <button type="button" class="theme-toggle" aria-label="Alternar tema">
        <i class="fa-solid fa-moon icon-moon"></i>
        <i class="fa-solid fa-sun icon-sun"></i>
      </button>
    </div>

    <header class="card-header">
      <div class="icon-badge">
        <i class="fa-solid fa-lock"></i>
      </div>
      <div>
        <h1>Instalação indisponível</h1>
        <p>O assistente de instalação não está acessível neste momento.</p>
      </div>
    </header>

    <div class="card-body">
      <p>
        Esta rotina de instalação foi desativada pelo administrador do sistema
        por motivos de segurança.
      </p>
      <p>
        Se você precisa ajustar a configuração, utilize o procedimento interno
        definido para este ambiente.
      </p>
    </div>

    <footer class="card-footer">
      <span>
        Caso o sistema já esteja configurado, utilize o acesso padrão.
      </span>
      <a href="<?= url_to('login') ?>" class="btn-pill">
        <i class="fa-solid fa-right-to-bracket"></i>
        Ir para o login
      </a>
    </footer>
  </div>

  <script>
    (function () {
      var body = document.body;
      var toggleBtn = document.querySelector('.theme-toggle');
      if (!toggleBtn) return;

      // Tema inicial a partir do localStorage
      var storedTheme = null;
      try {
        storedTheme = localStorage.getItem('panel_theme');
      } catch (e) {}

      if (storedTheme === 'light') {
        body.classList.add('theme-light');
      }

      function applyIconState() {
        var isLight = body.classList.contains('theme-light');
        var moon = toggleBtn.querySelector('.icon-moon');
        var sun  = toggleBtn.querySelector('.icon-sun');
        if (moon) moon.style.display = isLight ? 'none' : 'inline-block';
        if (sun)  sun.style.display  = isLight ? 'inline-block' : 'none';
      }

      applyIconState();

      toggleBtn.addEventListener('click', function () {
        body.classList.toggle('theme-light');
        var isLight = body.classList.contains('theme-light');

        try {
          localStorage.setItem('panel_theme', isLight ? 'light' : 'dark');
        } catch (e) {}

        applyIconState();
      });
    })();
  </script>
</body>
</html>