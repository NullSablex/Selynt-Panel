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

  /* Tema claro */
  body.theme-light {
    --color-bg: #f9fafb;
    --color-bg-soft: #e5e7eb;
    --color-card-bg: #ffffff;
    --color-card-border: rgba(148, 163, 184, 0.45);

    --color-text: #111827;
    --color-text-muted: #4b5563;

    --shadow-soft: 0 18px 40px -24px rgba(15, 23, 42, 0.18);
  }

  body.theme-light .section-chip {
    background-color: #e5e7eb;           /* cinza claro */
    color: #111827;                      /* texto escuro */
    border-color: rgba(148, 163, 184, 0.9);
  }

  body.theme-light .section-chip i {
    color: #4b5563;                      /* ícone em cinza escuro */
  }

  /* Texto e ícone dos passos no tema claro */
  body.theme-light .step-item .step-label {
    color: #6b7280; /* cinza legível */
  }

  body.theme-light .step-item.active .step-label {
    color: #111827; /* bem escuro quando ativo */
  }

  body.theme-light .step-item.done .step-label {
    color: #166534; /* verde discreto para steps concluídos */
  }

  /* Ícone de concluído no tema claro */
  body.theme-light .step-item .step-icon-done {
    color: #16a34a; /* verde sucesso bem visível */
  }

  /* Melhor legibilidade dos indicadores de passo no tema claro */
  body.theme-light .step-item .step-index {
    background-color: #e5e7eb;   /* cinza claro visível no fundo branco */
    color: #111827;              /* texto bem escuro */
  }

  body.theme-light .step-item.active .step-index {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
    color: #f9fafb;              /* branco em cima do roxo */
  }

  body.theme-light .step-item.done .step-index {
    background-color: #22c55e;   /* verde sucesso */
    color: #ecfdf5;              /* quase branco verdinho */
  }

  /* Ajustes específicos para melhorar legibilidade no tema claro */
  body.theme-light .install-shell {
    background-color: #ffffff;
  }

  body.theme-light .step-item {
    background-color: #ffffff;
    border-color: rgba(148, 163, 184, 0.7);
  }

  body.theme-light .section-card {
    background-color: #ffffff;
    border-color: rgba(156, 163, 175, 0.8);
  }

  body.theme-light .form-control {
    background-color: #ffffff;
    border-color: rgba(148, 163, 184, 0.7);
    color: #111827;
  }

  body.theme-light .theme-toggle {
    border-color: rgba(148, 163, 184, 0.7);
    color: var(--color-text-muted);
    background-color: #f9fafb;
  }

  body.theme-light .theme-toggle:hover {
    background-color: #e5e7eb;
  }

  /* Status pills e extensões – cores um pouco mais fortes no claro */
  body.theme-light .install-status-ok {
    background-color: #ecfdf5;
    color: #15803d;
    border-color: rgba(22, 163, 74, 0.55);
  }

  body.theme-light .install-status-fail {
    background-color: #fef2f2;
    color: #b91c1c;
    border-color: rgba(220, 38, 38, 0.55);
  }

  body.theme-light .ext-status-ok,
  body.theme-light .ext-status-icon-ok {
    color: #15803d;
  }

  body.theme-light .ext-status-fail,
  body.theme-light .ext-status-icon-fail {
    color: #b91c1c;
  }

  body.theme-light .badge-hint {
    background-color: #edf2ff;
    color: #4b5563;
  }

  body.theme-light .alert-success {
    background-color: #ecfdf3;
    color: #166534;
    border-color: #4ade80;
  }

  body.theme-light .alert-warning {
    background-color: #fffbeb;
    color: #92400e;
    border-color: #fbbf24;
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

  .install-shell {
    width: 100%;
    max-width: 900px;
    background-color: var(--color-card-bg);
    border-radius: var(--radius-lg);
    border: 1px solid var(--color-card-border);
    box-shadow: var(--shadow-soft);
    padding: 18px 20px 16px;
  }

  .install-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    margin-bottom: 14px;
  }

  .install-title h1 {
    font-size: 1.05rem;
    text-transform: uppercase;
    letter-spacing: 0.06em;
  }

  .install-title p {
    margin-top: 4px;
    font-size: 0.85rem;
    color: var(--color-text-muted);
  }

  .install-header-right {
    display: inline-flex;
    align-items: center;
    gap: 8px;
  }

  .install-status-pill {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    border-radius: 999px;
    padding: 4px 10px;
    font-size: 0.78rem;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .install-status-ok {
    background-color: rgba(34, 197, 94, 0.18);
    color: #4ade80;
    border: 1px solid rgba(34, 197, 94, 0.65);
  }

  .install-status-fail {
    background-color: rgba(248, 113, 113, 0.18);
    color: #fecaca;
    border: 1px solid rgba(248, 113, 113, 0.65);
  }

  /* Botão de tema */
  .theme-toggle {
    width: 32px;
    height: 32px;
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.7);
    background: transparent;
    color: var(--color-text-muted);
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

  .theme-toggle:hover {
    background-color: rgba(148, 163, 184, 0.18);
    color: var(--color-text);
    box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.9);
    border-color: rgba(129, 140, 248, 0.9);
  }

  .theme-toggle .icon-sun {
    display: none;
  }

  body.theme-light .theme-toggle .icon-sun {
    display: inline-block;
  }

  body.theme-light .theme-toggle .icon-moon {
    display: none;
  }

  /* Stepper */
  .steps-nav {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 16px;
    flex-wrap: wrap;
  }

  .step-item {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 0.8rem;
    padding: 6px 10px;
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.5);
    color: var(--color-text-muted);
    background-color: rgba(15, 23, 42, 0.9);
  }

  .step-index {
    width: 18px;
    height: 18px;
    border-radius: 999px;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    font-size: 0.75rem;
    background-color: rgba(148, 163, 184, 0.35);
    color: #e5e7eb;
  }

  .step-label {
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .step-item.active {
    border-color: rgba(129, 140, 248, 0.95);
    color: var(--color-text);
    box-shadow: 0 10px 25px -18px rgba(129, 140, 248, 0.9);
  }

  .step-item.active .step-index {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
  }

  .step-item.done {
    border-color: rgba(34, 197, 94, 0.9);
    color: #bbf7d0;
  }

  .step-item.done .step-index {
    background-color: rgba(34, 197, 94, 0.95);
  }

  .step-icon-done {
    color: #4ade80;
    font-size: 0.8rem;
  }

  .install-body {
    margin-top: 8px;
  }

  .step-pane {
    display: none;
  }

  .step-pane.active {
    display: block;
  }

  .section-title {
    font-size: 0.9rem;
    margin-bottom: 6px;
    font-weight: 500;
  }

  .section-desc {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-bottom: 10px;
  }

  .section-list {
    margin: 6px 0 10px;
    padding-left: 18px;
    font-size: 0.8rem;
    color: var(--color-text-muted);
  }

  .section-list li {
    margin-bottom: 4px;
  }

  .section-list code {
    font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, Consolas, "Liberation Mono", "Courier New", monospace;
    font-size: 0.78rem;
  }

  .section-card {
    margin-top: 6px;
    padding: 12px 12px 10px;
    border-radius: 14px;
    background-color: rgba(15, 23, 42, 0.9);
    border: 1px solid rgba(148, 163, 184, 0.45);
  }

  body.theme-light .section-card {
    background-color: #ffffff;
    border-color: rgba(156, 163, 175, 0.8);
  }

  .section-card-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    margin-bottom: 6px;
  }

  .section-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 0.72rem;
    background-color: rgba(129, 140, 248, 0.16);
    color: #c7d2fe;
    text-transform: uppercase;
    letter-spacing: 0.08em;
  }

  .section-chip i {
    font-size: 0.75rem;
  }

  .section-card-header p {
    font-size: 0.78rem;
    color: var(--color-text-muted);
    text-align: right;
  }

  /* Info / extensões */
  .info-row {
    display: flex;
    justify-content: space-between;
    font-size: 0.85rem;
    padding: 6px 0;
    border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
  }

  .info-row:last-child {
    border-bottom: none;
  }

  .info-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--color-text-muted);
  }

  .info-label i {
    font-size: 0.85rem;
  }

  .info-value {
    font-weight: 500;
  }

  table.ext-table {
    width: 100%;
    border-collapse: collapse;
    font-size: 0.8rem;
    margin-top: 6px;
  }

  .ext-table th,
  .ext-table td {
    padding: 6px 4px;
    border-bottom: 1px solid rgba(148, 163, 184, 0.25);
    text-align: left;
  }

  .ext-table thead {
    text-transform: uppercase;
    letter-spacing: 0.08em;
    color: var(--color-text-muted);
    font-size: 0.75rem;
  }

  .ext-status-ok {
    color: #4ade80;
    font-weight: 500;
  }

  .ext-status-fail {
    color: #fecaca;
    font-weight: 500;
  }

  .ext-status-icon-ok {
    color: #4ade80;
  }

  .ext-status-icon-fail {
    color: #fecaca;
  }

  /* Form usuário (step 2) */
  .form-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 10px 16px;
    margin-bottom: 10px;
  }

  .form-group {
    display: flex;
    flex-direction: column;
    gap: 4px;
    font-size: 0.82rem;
  }

  .form-group label {
    color: var(--color-text-muted);
  }

  .form-control {
    border-radius: 999px;
    border: 1px solid rgba(148, 163, 184, 0.6);
    background-color: rgba(15, 23, 42, 0.9);
    color: var(--color-text);
    padding: 7px 10px;
    font-size: 0.85rem;
    outline: none;
    transition:
      border-color 0.15s ease,
      box-shadow 0.15s ease,
      background-color 0.15s ease;
  }

  .form-control:focus {
    border-color: rgba(129, 140, 248, 0.95);
    box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.7);
  }

  .form-error {
    font-size: 0.75rem;
    color: #fecaca;
  }

  .badge-hint {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 0.72rem;
    background-color: rgba(148, 163, 184, 0.12);
    color: var(--color-text-muted);
    margin-bottom: 8px;
  }

  .badge-hint i {
    font-size: 0.8rem;
  }

  .alert-success {
    margin-top: 8px;
    font-size: 0.8rem;
    padding: 6px 9px;
    border-radius: 10px;
    background-color: rgba(34, 197, 94, 0.12);
    color: #bbf7d0;
    border: 1px solid rgba(34, 197, 94, 0.6);
  }

  .alert-warning {
    margin-top: 8px;
    font-size: 0.8rem;
    padding: 7px 10px;
    border-radius: 10px;
    background-color: rgba(251, 191, 36, 0.14);
    color: #fbbf24;
    border: 1px solid rgba(251, 191, 36, 0.7);
    display: flex;
    align-items: flex-start;
    gap: 8px;
  }

  .alert-warning i {
    margin-top: 2px;
    font-size: 0.9rem;
  }

  /* Footer / botões */
  .wizard-footer {
    margin-top: 14px;
    display: flex;
    justify-content: space-between;
    gap: 8px;
    flex-wrap: wrap;
    font-size: 0.8rem;
    color: var(--color-text-muted);
    align-items: center;
  }

  .wizard-buttons {
    display: inline-flex;
    gap: 6px;
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
    transition:
      background-color 0.15s ease,
      color 0.15s ease,
      box-shadow 0.15s ease;
    text-decoration: none;
  }

  .btn-pill[disabled] {
    opacity: 0.5;
    cursor: not-allowed;
    box-shadow: none;
  }

  .btn-secondary {
    background-color: rgba(148, 163, 184, 0.14);
    color: var(--color-text);
  }

  .btn-secondary:hover:not([disabled]) {
    background-color: rgba(148, 163, 184, 0.26);
    box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.9);
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
    color: #f9fafb;
    box-shadow: 0 12px 25px -18px rgba(79, 70, 229, 0.9);
  }

  .btn-primary:hover:not([disabled]) {
    box-shadow: 0 18px 35px -22px rgba(79, 70, 229, 0.95);
  }

  @media (max-width: 640px) {
    .install-header {
      flex-direction: column;
      align-items: flex-start;
    }
    .wizard-footer {
      flex-direction: column-reverse;
      align-items: flex-start;
    }
    .section-card-header {
      flex-direction: column;
      align-items: flex-start;
    }
    .install-header-right {
      align-self: flex-end;
    }
  }
</style>

</head>
<body>
<?php
  $currentStep    = (int) ($currentStep ?? 1);
  $envOk          = ! empty($allOk) && $allOk;
  $userConfigured = ! empty($userConfigured);
?>
  <div class="install-shell">
    <header class="install-header">
      <div class="install-title">
        <h1>Assistente de instalação</h1>
        <p>Valide o ambiente, crie o usuário inicial e finalize a configuração.</p>
      </div>

      <div class="install-header-right">
        <!-- Botão de tema -->
        <button type="button" class="theme-toggle" aria-label="Alternar tema">
          <i class="fa-solid fa-moon icon-moon"></i>
          <i class="fa-solid fa-sun icon-sun"></i>
        </button>

        <?php if ($envOk): ?>
          <span class="install-status-pill install-status-ok">
            <i class="fa-solid fa-circle-check"></i>
            Requisitos ok
          </span>
        <?php else: ?>
          <span class="install-status-pill install-status-fail">
            <i class="fa-solid fa-triangle-exclamation"></i>
            Ajustes necessários
          </span>
        <?php endif; ?>
      </div>
    </header>

    <!-- Stepper -->
    <nav class="steps-nav">
      <div class="step-item step-1
        <?= $currentStep === 1 ? 'active' : ($envOk && $currentStep > 1 ? 'done' : '') ?>">
        <span class="step-index">1</span>
        <span class="step-label">Verificação do ambiente</span>
        <?php if ($envOk && $currentStep > 1): ?>
          <i class="fa-solid fa-circle-check step-icon-done"></i>
        <?php endif; ?>
      </div>

      <div class="step-item step-2
        <?= $currentStep === 2 ? 'active' : ($currentStep === 3 && $userConfigured ? 'done' : '') ?>">
        <span class="step-index">2</span>
        <span class="step-label">Usuário inicial</span>
        <?php if ($currentStep === 3 && $userConfigured): ?>
          <i class="fa-solid fa-circle-check step-icon-done"></i>
        <?php endif; ?>
      </div>

      <div class="step-item step-3 <?= $currentStep === 3 ? 'active' : '' ?>">
        <span class="step-index">3</span>
        <span class="step-label">Orientações finais</span>
        <?php if ($currentStep === 3 && $userConfigured): ?>
          <i class="fa-solid fa-circle-check step-icon-done"></i>
        <?php endif; ?>
      </div>
    </nav>

    <div class="install-body">
      <!-- STEP 1: Verificação do ambiente -->
      <section class="step-pane step-pane-1 <?= $currentStep === 1 ? 'active' : '' ?>">
        <h2 class="section-title">Verificação de requisitos</h2>
        <p class="section-desc">
          Confirme se a versão do PHP e as extensões principais estão disponíveis antes de continuar.
        </p>

        <div class="info-row">
          <div class="info-label">
            <i class="fa-brands fa-php"></i>
            Versão atual do PHP
          </div>
          <div class="info-value">
            <?= esc($currentPhp ?? 'desconhecida') ?>
          </div>
        </div>

        <div class="info-row">
          <div class="info-label">
            <i class="fa-solid fa-circle-info"></i>
            Versão mínima recomendada
          </div>
          <div class="info-value">
            <?= esc($requiredPhp ?? '8.1.0') ?>
            <?php if (! empty($phpOk) && $phpOk): ?>
              <span class="ext-status-ok" style="margin-left:6px;">
                <i class="fa-solid fa-check ext-status-icon-ok"></i>
              </span>
            <?php else: ?>
              <span class="ext-status-fail" style="margin-left:6px;">
                <i class="fa-solid fa-xmark ext-status-icon-fail"></i>
              </span>
            <?php endif; ?>
          </div>
        </div>

        <h3 class="section-title" style="margin-top:10px;">Extensões necessárias</h3>
        <p class="section-desc">
          Verifique se todas as extensões usadas pela aplicação estão carregadas no ambiente.
        </p>

        <table class="ext-table">
          <thead>
            <tr>
              <th>Extensão</th>
              <th>Status</th>
            </tr>
          </thead>
          <tbody>
            <?php if (! empty($extensions)): ?>
              <?php foreach ($extensions as $ext): ?>
                <tr>
                  <td><?= esc($ext['name']) ?></td>
                  <td>
                    <?php if (! empty($ext['loaded'])): ?>
                      <span class="ext-status-ok">
                        <i class="fa-solid fa-circle-check ext-status-icon-ok"></i>
                        carregada
                      </span>
                    <?php else: ?>
                      <span class="ext-status-fail">
                        <i class="fa-solid fa-circle-xmark ext-status-icon-fail"></i>
                        não carregada
                      </span>
                    <?php endif; ?>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="2">Nenhuma extensão configurada para verificação.</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>

        <div class="wizard-footer">
          <div>
            <?php if ($envOk): ?>
              Ambiente pronto. Você pode avançar para criar o usuário inicial.
            <?php else: ?>
              Ajuste a versão do PHP e/ou habilite as extensões faltantes antes de continuar.
            <?php endif; ?>
          </div>
          <div class="wizard-buttons">
            <button
              type="button"
              class="btn-pill btn-primary"
              id="goToStep2"
              <?= $envOk ? '' : 'disabled' ?>
            >
              <span>Continuar</span>
              <i class="fa-solid fa-arrow-right-long"></i>
            </button>
          </div>
        </div>
      </section>

      <!-- STEP 2: Usuário inicial -->
      <section class="step-pane step-pane-2 <?= $currentStep === 2 ? 'active' : '' ?>">
        <h2 class="section-title">Configuração de usuário inicial</h2>
        <p class="section-desc">
          Defina o usuário administrativo que terá acesso inicial ao painel.
        </p>

        <form method="post" action="<?= url_to('install.confirm') ?>" id="installUserForm">
          <?= csrf_field() ?>

          <div class="badge-hint">
            <i class="fa-solid fa-circle-info"></i>
            Esses dados podem ser alterados depois dentro da própria aplicação.
          </div>

          <div class="form-grid">
            <div class="form-group">
              <label for="username">Nome de usuário</label>
              <input
                type="text"
                id="username"
                name="username"
                class="form-control"
                minlength="5"
                maxlength="30"
                value="<?= esc($userData['username'] ?? '') ?>"
                autocomplete="off"
              >
              <?php if (! empty($userErrors['username'])): ?>
                <div class="form-error"><?= esc($userErrors['username']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="display_name">Como deseja ser chamado</label>
              <input
                type="text"
                id="display_name"
                name="display_name"
                class="form-control"
                maxlength="15"
                value="<?= esc($userData['display_name'] ?? '') ?>"
                autocomplete="off"
              >
              <?php if (! empty($userErrors['display_name'])): ?>
                <div class="form-error"><?= esc($userErrors['display_name']) ?></div>
              <?php else: ?>
                <div style="font-size:0.74rem; color:var(--color-text-muted);">
                  Máximo de 15 caracteres.
                </div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="email">E-mail</label>
              <input
                type="email"
                id="email"
                name="email"
                class="form-control"
                maxlength="100"
                value="<?= esc($userData['email'] ?? '') ?>"
                autocomplete="off"
              >
              <?php if (! empty($userErrors['email'])): ?>
                <div class="form-error"><?= esc($userErrors['email']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="password">Senha</label>
              <input
                type="password"
                id="password"
                name="password"
                class="form-control"
                minlength="8"
                maxlength="128"
                autocomplete="new-password"
              >
              <?php if (! empty($userErrors['password'])): ?>
                <div class="form-error"><?= esc($userErrors['password']) ?></div>
              <?php endif; ?>
            </div>

            <div class="form-group">
              <label for="password_confirm">Confirmar senha</label>
              <input
                type="password"
                id="password_confirm"
                name="password_confirm"
                class="form-control"
                minlength="8"
                maxlength="128"
                autocomplete="new-password"
              >
              <?php if (! empty($userErrors['password_confirm'])): ?>
                <div class="form-error"><?= esc($userErrors['password_confirm']) ?></div>
              <?php endif; ?>
            </div>
          </div>

          <div class="wizard-footer">
            <div>
              <?php if ($userConfigured): ?>
                <div class="alert-success">
                  <i class="fa-solid fa-circle-check"></i>
                  Usuário inicial configurado com sucesso. Você pode seguir para as orientações finais.
                </div>
              <?php else: ?>
                Preencha os dados do usuário inicial e confirme para concluir esta etapa.
              <?php endif; ?>
            </div>
            <div class="wizard-buttons">
              <button type="button" class="btn-pill btn-secondary" id="backToStep1">
                <i class="fa-solid fa-arrow-left-long"></i>
                Voltar
              </button>
              <button type="submit" class="btn-pill btn-primary">
                <i class="fa-solid fa-check"></i>
                Confirmar
              </button>
            </div>
          </div>
        </form>
      </section>

      <!-- STEP 3: Orientações finais (.env) -->
      <section class="step-pane step-pane-3 <?= $currentStep === 3 ? 'active' : '' ?>">
        <h2 class="section-title">Orientações finais</h2>
        <p class="section-desc">
          Para fechar a instalação com segurança, revise as configurações sensíveis feitas
          diretamente no arquivo <code>.env</code> e confirme que o instalador permanece desativado.
        </p>

        <div class="section-card">
          <div class="section-card-header">
            <div class="section-chip">
              <i class="fa-solid fa-shield-halved"></i>
              Segurança e configuração
            </div>
            <p>
              Ajuste apenas o que for realmente necessário.<br>
              Em caso de dúvida, teste primeiro em ambiente de desenvolvimento.
            </p>
          </div>

          <ul class="section-list">
            <li>
              <strong>Backup primeiro:</strong>
              antes de qualquer alteração, faça uma cópia do arquivo <code>.env</code>
              e guarde em local seguro.
            </li>

            <li>
              <strong>Idioma padrão:</strong>
              localize a chave responsável pelo idioma (por exemplo
              <code>app.defaultLocale</code>) e defina o valor desejado, como
              <code>pt-BR</code> ou <code>en</code>.
            </li>

            <li>
              <strong>Envio de e-mails:</strong>
              configure as opções de remetente e SMTP (host, porta, usuário e senha)
              de acordo com o servidor de e-mail que você utiliza. Use credenciais
              específicas para o sistema, não contas pessoais.
            </li>

            <li>
              <strong>Sessão de usuário:</strong>
              se precisar aumentar a duração da sessão, ajuste apenas o tempo de expiração
              indicado para sessão no <code>.env</code>, mantendo valores compatíveis
              com a política de segurança do ambiente.
            </li>

            <li>
              <strong>Evite mudanças aleatórias:</strong>
              não altere outras chaves do <code>.env</code> sem saber exatamente o impacto.
              Uma mudança incorreta pode impedir o painel de iniciar.
            </li>
          </ul>

          <div class="alert-warning">
            <i class="fa-solid fa-triangle-exclamation"></i>
            <div>
              <strong>Importante:</strong><br>
              Após concluir a instalação e criar o usuário inicial, mantenha o instalador
              desativado. Não reative o instalador manualmente em ambiente de produção,
              para evitar que terceiros tentem executar novamente o processo de instalação
              e criem novos acessos indevidos.
            </div>
          </div>
        </div>

        <div class="wizard-footer">
          <div>
            Se o ambiente está ok e o usuário inicial foi criado, a instalação está concluída.
          </div>
          <div class="wizard-buttons">
            <a href="<?= url_to('login') ?>" class="btn-pill btn-primary">
              <i class="fa-solid fa-right-to-bracket"></i>
              Ir para o login
            </a>
          </div>
        </div>
      </section>
    </div>
  </div>

  <script>
    // Navegação entre steps
    (function () {
      var goToStep2Btn   = document.getElementById('goToStep2');
      var backToStep1Btn = document.getElementById('backToStep1');

      var envOk = <?= $envOk ? 'true' : 'false' ?>;

      function setStep(step) {
        var pane1 = document.querySelector('.step-pane-1');
        var pane2 = document.querySelector('.step-pane-2');
        var pane3 = document.querySelector('.step-pane-3');

        var stepItem1 = document.querySelector('.step-1');
        var stepItem2 = document.querySelector('.step-2');
        var stepItem3 = document.querySelector('.step-3');

        if (step === 1) {
          if (pane1) pane1.classList.add('active');
          if (pane2) pane2.classList.remove('active');
          if (pane3) pane3.classList.remove('active');

          if (stepItem1) {
            stepItem1.classList.add('active');
            stepItem1.classList.remove('done');
          }
          if (stepItem2) stepItem2.classList.remove('active');
          if (stepItem3) stepItem3.classList.remove('active');
        } else if (step === 2) {
          if (!envOk) return;

          if (pane1) pane1.classList.remove('active');
          if (pane2) pane2.classList.add('active');
          if (pane3) pane3.classList.remove('active');

          if (stepItem1) {
            stepItem1.classList.remove('active');
            stepItem1.classList.add('done');
          }
          if (stepItem2) stepItem2.classList.add('active');
          if (stepItem3) stepItem3.classList.remove('active');
        }

        window.scrollTo({ top: 0, behavior: 'smooth' });
      }

      if (goToStep2Btn) {
        goToStep2Btn.addEventListener('click', function () {
          if (goToStep2Btn.hasAttribute('disabled')) return;
          setStep(2);
        });
      }

      if (backToStep1Btn) {
        backToStep1Btn.addEventListener('click', function () {
          setStep(1);
        });
      }
    })();

    // Alternância de tema (dark/light)
    (function () {
      var btn = document.querySelector('.theme-toggle');
      if (!btn) return;

      // Aplica o tema salvo, se existir
      try {
        var storedTheme = localStorage.getItem('panel_theme');
        if (storedTheme === 'light') {
          document.body.classList.add('theme-light');
        }
      } catch (e) {
        // se localStorage não estiver disponível, apenas ignora
      }

      btn.addEventListener('click', function () {
        var isLight = document.body.classList.toggle('theme-light');
        try {
          localStorage.setItem('panel_theme', isLight ? 'light' : 'dark');
        } catch (e) {}
      });
    })();
  </script>
</body>
</html>