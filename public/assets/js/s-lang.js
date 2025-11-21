(function () {
  var LANG_ENDPOINT = '/langs/list';
  var LANG_CACHE_KEY = 'lang_list_cache_v1';
  var LANG_CACHE_TTL = 2 * 60 * 60 * 1000; // 2h em milissegundos

  var openBtn;
  var closeBtn;
  var modal;

  function getCachedLanguages() {
    try {
      var raw = localStorage.getItem(LANG_CACHE_KEY);
      if (!raw) return null;

      var cached = JSON.parse(raw);
      if (!cached || !cached.data || !cached.timestamp) return null;

      var expirou = (Date.now() - cached.timestamp) > LANG_CACHE_TTL;
      if (expirou) {
        localStorage.removeItem(LANG_CACHE_KEY);
        return null;
      }

      return cached.data;
    } catch (e) {
      console.error('Erro lendo cache de idiomas:', e);
      return null;
    }
  }

  function saveLanguagesToCache(data) {
    try {
      var payload = {
        timestamp: Date.now(),
        data: data
      };
      localStorage.setItem(LANG_CACHE_KEY, JSON.stringify(payload));
    } catch (e) {
      console.error('Erro salvando cache de idiomas:', e);
    }
  }

  function resetLanguagesCache() {
    try {
      localStorage.removeItem(LANG_CACHE_KEY);
    } catch (e) {
      console.error('Erro limpando cache de idiomas:', e);
    }
  }

  function bindClickToLangItem(item) {
    item.addEventListener('click', function () {
      var lang = this.getAttribute('data-lang');
      if (!lang) return;

      // limpa o cache antes de mudar o idioma
      resetLanguagesCache();

      window.location.href = '/lang/switch/' + encodeURIComponent(lang);
    });
  }

  function renderLanguages(langs) {
    var grid = document.querySelector('.lang-modal-grid');
    if (!grid) return;

    grid.innerHTML = '';

    langs.forEach(function (lang) {
      var btn = document.createElement('button');
      btn.type = 'button';
      btn.className = 'lang-item' + (lang.active ? ' active' : '');
      btn.setAttribute('data-lang', lang.code);
      btn.setAttribute('data-label', lang.sublabel || lang.label);

      btn.innerHTML =
        '<span class="lang-flag fi fi-' + lang.flag + '"></span>' +
        '<span class="lang-text">' +
          '<span class="lang-name">' + lang.label + '</span>' +
          '<span class="lang-variant">' + (lang.sublabel || '') + '</span>' +
        '</span>';

      bindClickToLangItem(btn);
      grid.appendChild(btn);
    });
  }

  function loadLanguages() {
    var cached = getCachedLanguages();
    if (cached) {
      renderLanguages(cached);
      return;
    }

    fetch(LANG_ENDPOINT, {
      method: 'GET',
      headers: {
        'Accept': 'application/json'
      }
    })
      .then(function (response) {
        if (!response.ok) {
          throw new Error('Erro HTTP ' + response.status);
        }
        return response.json();
      })
      .then(function (data) {
        renderLanguages(data);
        saveLanguagesToCache(data);
      })
      .catch(function (err) {
        console.error('Erro buscando idiomas:', err);
      });
  }

  function openModal() {
    if (!modal) return;
    modal.classList.add('open');
    document.body.classList.add('modal-open');
  }

  function closeModal() {
    if (!modal) return;
    modal.classList.remove('open');
    document.body.classList.remove('modal-open');
  }

  function initModal() {
    openBtn = document.getElementById('open-lang-modal');
    closeBtn = document.getElementById('close-lang-modal');
    modal = document.getElementById('langModal');

    var langItems = modal ? modal.querySelectorAll('.lang-item') : [];

    if (openBtn && modal) {
      openBtn.addEventListener('click', function () {
        openModal();
      });
    }

    if (closeBtn && modal) {
      closeBtn.addEventListener('click', function () {
        closeModal();
      });
    }

    if (modal) {
      modal.addEventListener('click', function (e) {
        if (e.target === modal) {
          closeModal();
        }
      });
    }

    langItems.forEach(function (item) {
      bindClickToLangItem(item);
    });

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && modal && modal.classList.contains('open')) {
        closeModal();
      }
    });
  }

  document.addEventListener('DOMContentLoaded', function () {
    initModal();
    loadLanguages();
  });
})();