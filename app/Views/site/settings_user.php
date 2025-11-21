<style>
  .account-shell {
    max-width: 960px;
    margin: 0 auto;
  }

  .account-header {
    margin-bottom: 18px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
    align-items: center;
  }

  .account-header h1 {
    font-size: 1.1rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .account-header p {
    font-size: 0.85rem;
    color: var(--color-text-muted);
    margin-top: 4px;
  }

  .account-grid {
    display: grid;
    grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);
    gap: 20px;
    align-items: flex-start;
  }

  .account-col-right {
    display: flex;
    flex-direction: column;
    gap: 16px;
  }

  .account-card {
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

  .account-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 18px 35px -20px rgba(15, 23, 42, 0.9);
    border-color: rgba(129, 140, 248, 0.85);
  }

  .account-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .account-section-title {
    font-size: 0.9rem;
    font-weight: 500;
  }

  .section-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 0.74rem;
    background-color: rgba(148, 163, 184, 0.12);
    color: var(--color-text-muted);
  }

  .section-chip i {
    font-size: 0.8rem;
  }

  body.theme-light .section-chip {
    background-color: #e5e7eb;
    color: #4b5563;
  }

  .account-section-desc {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-bottom: 10px;
  }

  .badge-hint {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 9px;
    border-radius: 999px;
    font-size: 0.74rem;
    background-color: rgba(148, 163, 184, 0.12);
    color: var(--color-text-muted);
    margin-bottom: 8px;
  }

  .badge-hint i {
    font-size: 0.8rem;
  }

  /* Resumo / uso */

  .account-summary-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
  }

  .summary-avatar {
    width: 48px;
    height: 48px;
    border-radius: 16px;
    overflow: hidden;
    border: 1px solid rgba(148, 163, 184, 0.5);
    background-color: rgba(15, 23, 42, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .summary-avatar img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  .summary-name {
    font-size: 0.96rem;
    font-weight: 500;
  }

  .summary-sub {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-top: 2px;
  }

  .summary-list {
    margin-top: 8px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: 0.83rem;
  }

  .summary-row {
    display: flex;
    justify-content: space-between;
    gap: 8px;
    padding-bottom: 4px;
    border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
  }

  .summary-row:last-child {
    border-bottom: none;
  }

  .summary-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--color-text-muted);
  }

  .summary-label i {
    font-size: 0.82rem;
  }

  .summary-value {
    font-size: 0.84rem;
    text-align: right;
    word-break: break-all;
  }

  /* Campos de formulário */

  .settings-form-group {
    margin-bottom: 10px;
    font-size: 0.82rem;
  }

  .settings-form-group label {
    display: block;
    margin-bottom: 4px;
    color: var(--color-text-muted);
  }

  .settings-control {
    width: 100%;
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

  .settings-control:focus {
    border-color: rgba(129, 140, 248, 0.95);
    box-shadow: 0 0 0 1px rgba(129, 140, 248, 0.7);
  }

  body.theme-light .settings-control {
    background-color: #ffffff;
    color: #111827;
    border-color: rgba(148, 163, 184, 0.7);
  }

  .settings-hint {
    font-size: 0.76rem;
    color: var(--color-text-muted);
    margin-top: 3px;
  }

  .form-error {
    font-size: 0.75rem;
    color: #fecaca;
    margin-top: 3px;
  }

  .account-footer {
    margin-top: 14px;
    display: flex;
    justify-content: flex-end;
    gap: 8px;
    flex-wrap: wrap;
    font-size: 0.8rem;
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
  }

  .btn-secondary {
    background-color: rgba(148, 163, 184, 0.14);
    color: var(--color-text);
  }

  .btn-secondary:hover {
    background-color: rgba(148, 163, 184, 0.26);
    box-shadow: 0 8px 20px -14px rgba(15, 23, 42, 0.9);
  }

  .btn-primary {
    background: linear-gradient(135deg, var(--color-primary), var(--color-primary-dark));
    color: #f9fafb;
    box-shadow: 0 12px 25px -18px rgba(79, 70, 229, 0.9);
  }

  .btn-primary:hover {
    box-shadow: 0 18px 35px -22px rgba(79, 70, 229, 0.95);
  }

  @media (max-width: 900px) {
    .account-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 640px) {
    .account-card {
      padding: 14px 14px 12px;
    }
  }
</style>

<?php
  /** @var array $user */
  /** @var array|null $errors */

  $errors = $errors ?? [];
?>

<section class="account-shell">
  <header class="account-header">
    <div>
      <h1>Configurações da conta</h1>
      <p>Revise seus dados, preferências e segurança de acesso.</p>
    </div>
  </header>

  <form method="post" action="<?= url_to('user.settings.update') ?>">
    <?= csrf_field() ?>

    <div class="account-grid">
      <!-- Coluna esquerda: resumo / uso -->
      <div class="account-col-left">
        <article class="account-card">
          <div class="account-section-header">
            <div class="account-section-title">
              Resumo da conta
            </div>
            <div class="section-chip">
              <i class="fa-solid fa-circle-user"></i>
              Visão geral
            </div>
          </div>

          <div class="account-summary-header">
            <div class="summary-avatar">
              <img src="<?= base_url('assets/img/avatars/'. $session->get('user_avatar').'.png') ?>" alt="Avatar">
            </div>
            <div>
              <div class="summary-name">
                <?= esc($user['name'] !== '' ? $user['name'] : ($user_details['user'] ?? 'Usuário')) ?>
              </div>
              <div class="summary-sub">
                Informações principais da sua conta.
              </div>
            </div>
          </div>

          <div class="summary-list">
            <div class="summary-row">
              <div class="summary-label">
                <i class="fa-solid fa-user"></i>
                <span>Nome de usuário</span>
              </div>
              <div class="summary-value">
                <?= esc($user_details['user'] ?? '—') ?>
              </div>
            </div>

            <div class="summary-row">
              <div class="summary-label">
                <i class="fa-solid fa-id-card"></i>
                <span>Como você é chamado</span>
              </div>
              <div class="summary-value">
                <?= esc($user['name'] !== '' ? $user['name'] : '—') ?>
              </div>
            </div>

            <div class="summary-row">
              <div class="summary-label">
                <i class="fa-regular fa-calendar-plus"></i>
                <span>Conta criada em</span>
              </div>
              <div class="summary-value">
                <?= ! empty($user_details['created']) ? format_datetime($user_details['created'], ['time' => 'H:i']) : '—' ?>
              </div>
            </div>

            <div class="summary-row">
              <div class="summary-label">
                <i class="fa-regular fa-clock"></i>
                <span>Último acesso</span>
              </div>
              <div class="summary-value">
                <?= ! empty($user_details['last_login']) ? format_datetime($user_details['last_login'], ['time' => 'H:i']) : '—' ?>
              </div>
            </div>
          </div>

          <p class="settings-hint" style="margin-top:8px;">
            O nome de usuário é fixo e definido na criação da conta. Outros dados podem ser ajustados ao lado.
          </p>
        </article>
      </div>

      <!-- Coluna direita: dados + segurança -->
      <div class="account-col-right">
        <!-- Dados básicos editáveis -->
        <article class="account-card">
          <div class="account-section-header">
            <div class="account-section-title">
              Dados da conta
            </div>
            <div class="section-chip">
              <i class="fa-solid fa-user-pen"></i>
              Identidade
            </div>
          </div>

          <p class="account-section-desc">
            Ajuste como seu nome aparece no painel e qual e-mail está associado à sua conta.
          </p>

          <div class="settings-form-group">
            <label for="display_name">Como você é chamado</label>
            <input
              type="text"
              id="display_name"
              name="display_name"
              class="settings-control"
              maxlength="15"
              value="<?= esc($user['name'] ?? '') ?>"
              autocomplete="off"
            >
            <?php if (! empty($errors['display_name'])): ?>
              <div class="form-error"><?= esc($errors['display_name']) ?></div>
            <?php else: ?>
              <div class="settings-hint">
                Nome curto exibido no cabeçalho e em áreas do painel. Máximo de 15 caracteres.
              </div>
            <?php endif; ?>
          </div>

          <div class="settings-form-group">
            <label for="email">E-mail</label>
            <input
              type="email"
              id="email"
              name="email"
              class="settings-control"
              maxlength="100"
              value="<?= esc($user_details['email'] ?? '') ?>"
              autocomplete="off"
            >
            <?php if (! empty($errors['email'])): ?>
              <div class="form-error"><?= esc($errors['email']) ?></div>
            <?php else: ?>
              <div class="settings-hint">
                E-mail usado para comunicação e, futuramente, recuperação de acesso.
              </div>
            <?php endif; ?>
          </div>
        </article>

        <!-- Segurança / senha -->
        <article class="account-card">
          <div class="account-section-header">
            <div class="account-section-title">
              Segurança e senha
            </div>
            <div class="section-chip">
              <i class="fa-solid fa-shield-halved"></i>
              Acesso
            </div>
          </div>

          <p class="account-section-desc">
            Para alterar a senha, informe a senha atual e defina uma nova senha segura.
          </p>

          <div class="badge-hint">
            <i class="fa-solid fa-key"></i>
            A senha deve ter entre 8 e 128 caracteres. Deixe em branco se não quiser alterar.
          </div>

          <div class="settings-form-group">
            <label for="password_current">Senha atual</label>
            <input
              type="password"
              id="password_current"
              name="password_current"
              class="settings-control"
              autocomplete="current-password"
            >
            <?php if (! empty($errors['password_current'])): ?>
              <div class="form-error"><?= esc($errors['password_current']) ?></div>
            <?php else: ?>
              <div class="settings-hint">
                Necessária para confirmar qualquer mudança de senha.
              </div>
            <?php endif; ?>
          </div>

          <div class="settings-form-group">
            <label for="password">Nova senha</label>
            <input
              type="password"
              id="password"
              name="password"
              class="settings-control"
              minlength="8"
              maxlength="128"
              autocomplete="new-password"
            >
            <?php if (! empty($errors['password'])): ?>
              <div class="form-error"><?= esc($errors['password']) ?></div>
            <?php else: ?>
              <div class="settings-hint">
                Preencha apenas se quiser trocar a senha atual.
              </div>
            <?php endif; ?>
          </div>

          <div class="settings-form-group">
            <label for="password_confirm">Confirmar nova senha</label>
            <input
              type="password"
              id="password_confirm"
              name="password_confirm"
              class="settings-control"
              minlength="8"
              maxlength="128"
              autocomplete="new-password"
            >
            <?php if (! empty($errors['password_confirm'])): ?>
              <div class="form-error"><?= esc($errors['password_confirm']) ?></div>
            <?php endif; ?>
          </div>
        </article>
      </div>
    </div>

    <div class="account-footer">
      <button type="submit" class="btn-pill btn-primary">
        <i class="fa-solid fa-floppy-disk"></i>
        Salvar alterações
      </button>
    </div>
  </form>
</section>
