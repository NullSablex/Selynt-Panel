<style>
  .profile-shell {
    max-width: 960px;
    margin: 0 auto;
  }

  .profile-header {
    margin-bottom: 18px;
    display: flex;
    justify-content: space-between;
    gap: 10px;
    align-items: center;
  }

  .profile-header h1 {
    font-size: 1.1rem;
    letter-spacing: 0.04em;
    text-transform: uppercase;
  }

  .profile-header p {
    font-size: 0.85rem;
    color: var(--color-text-muted);
    margin-top: 4px;
  }

  .profile-grid {
    display: grid;
    grid-template-columns: minmax(260px, 320px) minmax(0, 1fr);
    gap: 20px;
    align-items: flex-start;
  }

  .profile-card,
  .avatar-card {
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

  .profile-card:hover,
  .avatar-card:hover {
    transform: translateY(-1px);
    box-shadow: 0 18px 35px -20px rgba(15, 23, 42, 0.9);
    border-color: rgba(129, 140, 248, 0.85);
  }

  /* Cabeçalho interno das seções */

  .profile-section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 8px;
    margin-bottom: 10px;
  }

  .profile-section-title {
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

  /* Card info do usuário */

  .profile-card-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 10px;
  }

  .profile-avatar-big {
    width: 64px;
    height: 64px;
    border-radius: 20px;
    overflow: hidden;
    border: 1px solid rgba(148, 163, 184, 0.5);
    background-color: rgba(15, 23, 42, 0.9);
    display: flex;
    align-items: center;
    justify-content: center;
  }

  .profile-avatar-big img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
  }

  body.theme-light .profile-avatar-big {
    background-color: #f9fafb;
    border-color: rgba(148, 163, 184, 0.55);
  }

  .profile-identity-title {
    font-size: 0.98rem;
    font-weight: 500;
  }

  .profile-identity-sub {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-top: 2px;
  }

  .profile-info-list {
    margin-top: 10px;
    display: flex;
    flex-direction: column;
    gap: 6px;
    font-size: 0.85rem;
  }

  .profile-info-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    padding-bottom: 4px;
    border-bottom: 1px dashed rgba(148, 163, 184, 0.35);
  }

  .profile-info-row:last-child {
    border-bottom: none;
  }

  .profile-info-label {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    color: var(--color-text-muted);
  }

  .profile-info-label i {
    font-size: 0.85rem;
  }

  .profile-info-value {
    font-weight: 500;
    font-size: 0.86rem;
    text-align: right;
    word-break: break-all;
  }

  .profile-hint {
    margin-top: 10px;
    font-size: 0.78rem;
    color: var(--color-text-muted);
  }

  /* Avatar selection */

  .avatar-card-header {
    margin-bottom: 10px;
  }

  .avatar-card-header h2 {
    font-size: 0.95rem;
  }

  .avatar-card-header p {
    font-size: 0.8rem;
    color: var(--color-text-muted);
    margin-top: 4px;
  }

  .avatar-hint-chip {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 3px 9px;
    border-radius: var(--radius-pill);
    font-size: 0.74rem;
    background-color: rgba(148, 163, 184, 0.12);
    color: var(--color-text-muted);
    margin-bottom: 8px;
  }

  .avatar-hint-chip i {
    font-size: 0.8rem;
  }

  body.theme-light .avatar-hint-chip {
    background-color: #e5e7eb;
    color: #4b5563;
  }

  .avatar-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
    gap: 10px;
    margin-top: 4px;
  }

  .avatar-option {
    position: relative;
  }

  .avatar-radio {
    position: absolute;
    opacity: 0;
    pointer-events: none;
  }

  .avatar-visual {
    border-radius: 14px;
    border: 1px solid rgba(148, 163, 184, 0.5);
    background-color: rgba(15, 23, 42, 0.9);
    padding: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition:
      border-color 0.15s ease,
      box-shadow 0.15s ease,
      background-color 0.15s ease,
      transform 0.12s ease;
    min-height: 72px;
  }

  .avatar-visual img {
    width: 58px;
    height: 58px;
    border-radius: 14px;
    object-fit: cover;
    display: block;
  }

  .avatar-option.selected .avatar-visual {
    border-color: rgba(129, 140, 248, 0.95);
    background-color: rgba(79, 70, 229, 0.16);
    box-shadow: 0 10px 28px -18px rgba(79, 70, 229, 0.9);
    transform: translateY(-1px);
  }

  .avatar-check {
    position: absolute;
    top: 6px;
    right: 6px;
    width: 18px;
    height: 18px;
    border-radius: 999px;
    background-color: rgba(22, 163, 74, 0.9);
    color: #ecfdf5;
    display: none;
    align-items: center;
    justify-content: center;
    font-size: 0.7rem;
  }

  .avatar-option.selected .avatar-check {
    display: inline-flex;
  }

  body.theme-light .avatar-visual {
    background-color: #f9fafb;
    border-color: rgba(148, 163, 184, 0.65);
  }

  body.theme-light .avatar-option.selected .avatar-visual {
    background-color: rgba(129, 140, 248, 0.08);
    box-shadow: 0 10px 28px -18px rgba(79, 70, 229, 0.5);
  }

  .avatar-footer {
    margin-top: 12px;
    display: flex;
    justify-content: flex-end;
    gap: 6px;
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
    .profile-grid {
      grid-template-columns: 1fr;
    }
  }

  @media (max-width: 640px) {
    .profile-card,
    .avatar-card {
      padding: 14px 14px 12px;
    }
  }
</style>

<section class="profile-shell">
  <header class="profile-header">
    <div>
      <h1><?= lang('Site.perfil') ?></h1>
      <p><?= lang('Site.informacoes_basicas_da...') ?></p>
    </div>
  </header>

  <div class="profile-grid">
    <!-- Card de informações -->
    <article class="profile-card">
      <div class="profile-section-header">
        <div class="profile-section-title">
          <?= lang('Site.dados_da_conta') ?>
        </div>
        <div class="section-chip">
          <i class="fa-solid fa-user-shield"></i>
          <?= lang('Site.identidade') ?>
        </div>
      </div>

      <header class="profile-card-header">
        <div class="profile-avatar-big">
          <img
            src="<?= esc(base_url('assets/img/avatars/'.$session->get('user_avatar').'.png')) ?>"
            alt="Avatar atual"
            id="profileAvatarPreview"
          >
        </div>
        <div>
          <div class="profile-identity-title">
            <?= esc($user['name'] !== '' ? $user['name'] : 'Usuário') ?>
          </div>
          <div class="profile-identity-sub">
            <?= lang('Site.dados_vinculados_a_sua...') ?>
          </div>
        </div>
      </header>

      <div class="profile-info-list">
        <?php if ($user_nick !== ''): ?>
          <div class="profile-info-row">
            <div class="profile-info-label">
              <i class="fa-solid fa-user"></i>
              <span><?= lang('Site.nome_de_usuario') ?></span>
            </div>
            <div class="profile-info-value">
              <?= esc($user_nick) ?>
            </div>
          </div>
        <?php endif; ?>

        <div class="profile-info-row">
          <div class="profile-info-label">
            <i class="fa-solid fa-id-card"></i>
            <span><?= lang('Site.como_voce_e_chamado') ?></span>
          </div>
          <div class="profile-info-value">
            <?= esc($user['name'] !== '' ? $user['name'] : '—') ?>
          </div>
        </div>
      </div>

      <p class="profile-hint">
        <?= lang('Site.alteracoes_em_nome_so...') ?>
      </p>
    </article>

    <!-- Card de seleção de avatar -->
    <article class="avatar-card">
      <div class="profile-section-header">
        <div class="profile-section-title">
          <?= lang('Site.imagem_de_perfil') ?>
        </div>
        <div class="section-chip">
          <i class="fa-solid fa-image"></i>
          <?= lang('Site.visual') ?>
        </div>
      </div>

      <header class="avatar-card-header">
        <div>
          <h2><?= lang('Site.escolha_de_avatar') ?></h2>
          <p><?= lang('Site.selecione_um_dos_avatares') ?></p>
        </div>
      </header>

      <form method="post" action="<?= url_to('user.profile.update') ?>" id="avatarForm">
        <?= csrf_field() ?>

        <div class="avatar-hint-chip">
          <i class="fa-solid fa-circle-info"></i>
          <?= lang('Site.as_imagens_sao_predefinidas...') ?>
        </div>

        <div class="avatar-grid" id="avatarGrid">
          <?php foreach ($avatars as $avatar): ?>
            <?php
              $id       = $avatar['id'];
              $isActive = ($id === $session->get('user_avatar'));
            ?>
            <label class="avatar-option <?= $isActive ? 'selected' : '' ?>">
              <input
                type="radio"
                class="avatar-radio"
                name="avatar"
                value="<?= esc($id) ?>"
                <?= $isActive ? 'checked' : '' ?>
              >
              <div class="avatar-visual">
                <img src="<?= esc($avatar['file']) ?>" alt="Avatar">
              </div>
              <div class="avatar-check">
                <i class="fa-solid fa-check"></i>
              </div>
            </label>
          <?php endforeach; ?>
        </div>

        <div class="avatar-footer">
          <button type="submit" class="btn-pill btn-primary">
            <i class="fa-solid fa-floppy-disk"></i>
            <?= lang('Site.salvar_alteracoes') ?>
          </button>
        </div>
      </form>
    </article>
  </div>
</section>

<script>
  (function () {
    var grid   = document.getElementById('avatarGrid');
    var avatarPreview = document.getElementById('profileAvatarPreview');
    if (!grid || !avatarPreview) return;

    grid.addEventListener('click', function (event) {
      var option = event.target.closest('.avatar-option');
      if (!option) return;

      var radio = option.querySelector('.avatar-radio');
      if (radio) {
        radio.checked = true;
      }

      var allOptions = grid.querySelectorAll('.avatar-option');
      allOptions.forEach(function (opt) {
        opt.classList.remove('selected');
      });

      option.classList.add('selected');

      var img = option.querySelector('img');
      if (img && img.src) {
        avatarPreview.src = img.src;
      }
    });
  })();
</script>