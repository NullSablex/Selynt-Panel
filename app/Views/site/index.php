<!DOCTYPE html>
<html lang="<?= service('request')->getLocale();?>">
<head>
  <meta charset="UTF-8">
  <title><?= $page_title.' | Selynt Panel';?></title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" href="<?= base_url('assets/img/logo.png'); ?>" type="image/png">
  <link rel="stylesheet" href="<?= base_url('assets/base.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flag-icons@6.6.6/css/flag-icons.min.css">
  <!--<link rel="stylesheet" href="<?= base_url('assets/prism.css'); ?>">-->
</head>
<body>
  <div class="app-shell">
    <header class="app-header">
      <div class="header-left">
        <img src="<?= base_url('assets/img/logo.png');?>" class="brand-mini" alt="Logo">

        <nav class="main-nav">
          <a href="<?= url_to('apps.dashboard')?>"<?= active_menu(1, 'user') ? 'class="active"' : '' ?>>Dashboard</a>
          <a href="<?= url_to('apps.panel')?>"<?= active_menu(2, 'user') ? 'class="active"' : '' ?>>Aplicações</a>
          <!--<a href="#">Logs</a>
          <a href="#">Configurações</a>-->
        </nav>
      </div>

      <div class="header-right">
        <button type="button" class="lang-button" id="open-lang-modal">
          <i class="fa-solid fa-globe"></i>
          <span class="lang-button-label"><?= lang_name_user(); ?></span>
        </button>

        <button type="button" class="theme-toggle" aria-label="Alternar tema">
          <i class="fa-solid fa-moon icon-moon"></i>
          <i class="fa-solid fa-sun icon-sun"></i>
        </button>

        <div class="user-dropdown">
          <button type="button" class="user-profile">
            <img src="<?= base_url('assets/img/avatars/'.$session->user_avatar.'.png');?>" class="user-avatar" alt="Logo">
            <div class="user-meta">
              <span class="user-name"><?= $user['name'];?></span>
              <span class="user-role">Administrador</span>
            </div>
            <i class="fa-solid fa-chevron-down user-caret"></i>
          </button>

          <div class="user-menu">
            <ul class="user-menu-list">
              <li class="user-menu-label"><?= lang('Site.conta') ?></li>
              <li>
                <a href="<?= url_to('user.profile') ?>" class="user-menu-link">
                  <i class="fa-solid fa-user"></i>
                  <span><?= lang('Site.perfil')?></span>
                </a>
              </li>
              <li>
                <a href="<?= url_to('user.settings') ?>" class="user-menu-link">
                  <i class="fa-solid fa-gear"></i>
                  <span><?= lang('Site.configuracoes')?></span>
                </a>
              </li>

              <li><div class="user-menu-separator"></div></li>

              <li>
                <a href="/logout" class="user-menu-link user-menu-link-danger">
                  <i class="fa-solid fa-right-from-bracket"></i>
                  <span><?= lang('Site.sair')?></span>
                </a>
              </li>
            </ul>
          </div>
        </div>

      </div>
    </header>

    <main class="app-main">
      <?= view('site/'.$page_name);?>
    </main>
  </div>

  <div class="lang-modal-backdrop" id="langModal">
    <div class="lang-modal">
      <header class="lang-modal-header">
        <div>
          <div class="lang-modal-title"><?= lang('Site.selecione_um_idioma') ?></div>
        </div>
        <button type="button" class="lang-modal-close" id="close-lang-modal" aria-label="Fechar">
          <i class="fa-solid fa-xmark"></i>
        </button>
      </header>
      <p class="lang-modal-subtitle">
        <?= lang('Site.seu_painel_sera...') ?>
      </p>

      <div class="lang-modal-grid"></div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="<?= base_url('assets/js/script.js') ?>"></script>
  <script>
    var success_message = <?= json_encode($session->getFlashdata('success'));?>;
    var warning_message = <?= json_encode($session->getFlashdata('warning'));?>;
    var info_message    = <?= json_encode($session->getFlashdata('info'));?>;
    var error_message   = <?= json_encode($session->getFlashdata('error'));?>;
    
    // Tema (usa localStorage, igual na tela de login)
    (function () {
      var body = document.body;
      var btn = document.querySelector('.theme-toggle');

      var savedTheme = null;
      try {
        savedTheme = localStorage.getItem('theme');
      } catch (e) {
        savedTheme = null;
      }
      if (savedTheme === 'light') {
        body.classList.add('theme-light');
      }

      if (btn) {
        btn.addEventListener('click', function () {
          body.classList.toggle('theme-light');
          var isLight = body.classList.contains('theme-light');
          try {
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
          } catch (e) {}
        });
      }
    })();

    // Dropdown de usuário
    (function () {
      var dropdown = document.querySelector('.user-dropdown');
      if (!dropdown) return;

      var btn = dropdown.querySelector('.user-profile');

      btn.addEventListener('click', function (e) {
        e.stopPropagation();
        dropdown.classList.toggle('open');
      });

      document.addEventListener('click', function (e) {
        if (!dropdown.contains(e.target)) {
          dropdown.classList.remove('open');
        }
      });
    })();

    // Alternância Grade / Lista (apenas classe no body)
    (function () {
      var viewButtons = document.querySelectorAll('.view-toggle');
      if (!viewButtons.length) return;

      // aplica visualização salva
      var savedView = null;
      try {
        savedView = localStorage.getItem('appsView');
      } catch (e) {
        savedView = null;
      }
      if (savedView === 'list') {
        document.body.classList.add('apps-view-list');
        viewButtons.forEach(function (btn) {
          btn.classList.toggle('active', btn.getAttribute('data-view') === 'list');
        });
      }

      viewButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
          var view = btn.getAttribute('data-view');
          viewButtons.forEach(function (b) { b.classList.remove('active'); });
          btn.classList.add('active');

          if (view === 'list') {
            document.body.classList.add('apps-view-list');
          } else {
            document.body.classList.remove('apps-view-list');
          }

          try {
            localStorage.setItem('appsView', view);
          } catch (e) {}
        });
      });
    })();

    // pm2AppAction com SweetAlert2
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
  </script>
  <script src="<?= base_url('assets/js/s-lang.js'); ?>"></script>
</body>
</html>
