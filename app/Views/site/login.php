<!DOCTYPE html>
<html lang="<?= service('request')->getLocale();?>">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title.' | Selynt Panel';?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?= base_url('assets/base.css');?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <style>
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

      /* transição geral de tema */
      transition:
        background-color 0.25s ease,
        background-image 0.25s ease,
        color 0.25s ease;
    }

    .login-wrapper {
      width: 100%;
      max-width: 380px;
    }

    .login-card {
      position: relative;
      background: var(--color-card-bg);
      border-radius: var(--radius-lg);
      border: 1px solid var(--color-card-border);
      box-shadow: var(--shadow-soft);
      padding: 26px 24px 20px;
      overflow: hidden;
      transition:
        background-color 0.25s ease,
        border-color 0.25s ease,
        box-shadow 0.25s ease;
    }

    .brand-area {
      display: flex;
      justify-content: center;
      margin-bottom: 18px;
    }

    /* Placeholder de logotipo */
    .brand-placeholder {
      width: 52px;
      height: 52px;
      border-radius: 16px;
      border: 1px solid rgba(148, 163, 184, 0.5);
      display: flex;
      align-items: center;
      justify-content: center;
      font-size: 0.7rem;
      letter-spacing: 0.12em;
      text-transform: uppercase;
      color: var(--color-text-muted);
      transition:
        background-color 0.25s ease,
        border-color 0.25s ease,
        color 0.25s ease;
    }

    .login-header {
      margin-bottom: 18px;
      text-align: center;
    }

    .login-title {
      font-size: 1.2rem;
      font-weight: 600;
      letter-spacing: 0.03em;
      transition: color 0.25s ease;
    }

    .login-subtitle {
      font-size: 0.9rem;
      color: var(--color-text-muted);
      margin-top: 6px;
      transition: color 0.25s ease;
    }

    .form-group {
      margin-bottom: 14px;
    }

    .form-label {
      display: block;
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.1em;
      color: var(--color-text-muted);
      margin-bottom: 6px;
      transition: color 0.25s ease;
    }

    .form-control {
      width: 100%;
      padding: 10px 11px;
      border-radius: var(--radius-pill);
      border: 1px solid rgba(148, 163, 184, 0.4);
      background: rgba(15, 23, 42, 0.9);
      color: var(--color-text);
      font-size: 0.9rem;
      outline: none;
      transition:
        border-color 0.15s ease,
        box-shadow 0.15s ease,
        background-color 0.15s ease,
        color 0.15s ease;
    }

    body.theme-light .form-control {
      background: #ffffff;
    }

    .form-control::placeholder {
      color: rgba(148, 163, 184, 0.7);
    }

    .form-control:focus {
      border-color: var(--color-primary);
      box-shadow: 0 0 0 1px rgba(79, 70, 229, 0.4);
      background: rgba(15, 23, 42, 0.98);
    }

    body.theme-light .form-control:focus {
      background: #ffffff;
    }

    .form-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      font-size: 0.8rem;
      margin-top: 6px;
      margin-bottom: 16px;
    }

    .checkbox-label {
      display: inline-flex;
      align-items: center;
      gap: 6px;
      color: var(--color-text-muted);
      cursor: pointer;
      transition: color 0.25s ease;
    }

    .checkbox-label input[type="checkbox"] {
      width: 14px;
      height: 14px;
      border-radius: 4px;
      accent-color: var(--color-primary);
      cursor: pointer;
    }

    .link-muted {
      color: var(--color-text-muted);
      text-decoration: none;
      transition: color 0.15s ease;
    }

    .link-muted:hover {
      color: var(--color-text);
      text-decoration: underline;
    }

    .btn-primary {
      width: 100%;
      border: none;
      border-radius: var(--radius-pill);
      padding: 10px 14px;
      font-size: 0.9rem;
      font-weight: 500;
      text-transform: uppercase;
      letter-spacing: 0.12em;
      background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
      color: #f9fafb;
      cursor: pointer;
      box-shadow: 0 14px 30px -18px rgba(79, 70, 229, 0.8);
      transition:
        transform 0.12s ease,
        box-shadow 0.12s ease,
        filter 0.12s ease;
    }

    .btn-primary:hover {
      filter: brightness(1.04);
      transform: translateY(-1px);
      box-shadow: 0 18px 36px -20px rgba(79, 70, 229, 0.95);
    }

    .btn-primary:active {
      transform: translateY(0);
      box-shadow: 0 10px 24px -18px rgba(79, 70, 229, 0.85);
    }

    .login-footer {
      margin-top: 16px;
      font-size: 0.8rem;
      color: var(--color-text-muted);
      text-align: center;
      transition: color 0.25s ease;
    }

    .error-message {
      margin-top: 6px;
      font-size: 0.8rem;
      color: var(--color-error);
      min-height: 16px;
    }

    /* Botão de alternância de tema (melhorado) */
    .theme-toggle {
      position: absolute;
      top: 10px;
      right: 10px;
      border: 0;
      border-radius: 999px;
      padding: 5px 10px;
      display: inline-flex;
      align-items: center;
      gap: 6px;
      background: rgba(15, 23, 42, 0.9);
      color: var(--color-text-muted);
      cursor: pointer;
      font-size: 0.78rem;
      text-transform: uppercase;
      letter-spacing: 0.08em;
      transition:
        background-color 0.2s ease,
        color 0.2s ease,
        box-shadow 0.2s ease,
        transform 0.1s ease,
        border-color 0.2s ease;
      box-shadow: 0 0 0 1px rgba(148, 163, 184, 0.6);
    }

    body.theme-light .theme-toggle {
      background: #ffffff;
    }

    .theme-toggle:hover {
      color: var(--color-text);
      transform: translateY(-1px);
      box-shadow: 0 6px 14px -8px rgba(15, 23, 42, 0.7);
    }

    .theme-toggle:active {
      transform: translateY(0);
      box-shadow: 0 4px 10px -8px rgba(15, 23, 42, 0.7);
    }

    .theme-toggle i {
      font-size: 0.85rem;
    }

    .theme-toggle .icon-sun {
      display: none;
    }

    .theme-toggle .icon-moon {
      display: inline-block;
    }

    body.theme-light .theme-toggle .icon-sun {
      display: inline-block;
    }

    body.theme-light .theme-toggle .icon-moon {
      display: none;
    }

    @media (max-width: 480px) {
      .login-card {
        padding: 22px 18px 18px;
      }

      .login-title {
        font-size: 1.1rem;
      }

      .theme-toggle {
        padding: 4px 8px;
        font-size: 0.72rem;
      }
    }
  </style>
</head>

<body>
  <div class="login-wrapper">
    <div class="login-card">
      <!-- Botão de alternância de tema -->
      <button type="button" class="theme-toggle" aria-label="Alternar tema">
        <i class="fa-solid fa-moon icon-moon"></i>
        <i class="fa-solid fa-sun icon-sun"></i>
      </button>

      <div class="brand-area">
        <img src="<?= base_url('assets/img/logo.png');?>" class="brand-placeholder" alt="Logo">
      </div>

      <div class="login-header">
        <h1 class="login-title">Acessar painel</h1>
        <p class="login-subtitle">Entre com seu usuário e senha para continuar.</p>
      </div>

      <form method="post" action="<?= url_to('login.confirm') ?>">
        <?= csrf_field() ?>

        <div class="form-group">
          <label class="form-label" for="username"><?= lang('Site.usuario')?></label>
          <input
            id="username"
            name="username"
            type="text"
            class="form-control"
            placeholder="seu_usuario"
            autocomplete="username">
        </div>

        <div class="form-group">
          <label class="form-label" for="password"><?= lang('Site.senha')?></label>
          <input
            id="password"
            name="password"
            type="password"
            class="form-control"
            placeholder="••••••••"
            autocomplete="current-password">
        </div>

        <div class="form-row">
          <a href="#" class="link-muted">Esqueceu a senha?</a>
        </div>

        <button type="submit" class="btn-primary">
          <?= lang('Site.entrar')?>
        </button>
      </form>

      <div class="login-footer">
        <span>Acesso restrito</span>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= base_url('assets/js/script.js') ?>"></script>
  <script>
    var error_message   = <?= json_encode($session->getFlashdata('error'));?>;
    
    (function () {
      var body = document.body;
      var btn = document.querySelector('.theme-toggle');

      // aplicar tema salvo
      var savedTheme = null;
      try {
        savedTheme = localStorage.getItem('theme');
      } catch (e) {
        savedTheme = null;
      }

      if (savedTheme === 'light') {
        body.classList.add('theme-light');
      }

      // alternância e salvamento
      if (btn) {
        btn.addEventListener('click', function () {
          body.classList.toggle('theme-light');
          var isLight = body.classList.contains('theme-light');

          try {
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
          } catch (e) {
            // se não puder salvar, apenas ignora
          }
        });
      }
    })();
  </script>
</body>
</html>
