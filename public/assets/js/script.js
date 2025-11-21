document.addEventListener("DOMContentLoaded", function (event) {
  // Mensagens de sucesso/erro
  function fire(type, data) {
    if (data === undefined || data === null || data === '') return;

    // string => usa como texto; objeto => usa exatamente o que vier
    const opts = (typeof data === 'object')
      ? { ...data, icon: type }          // pode conter title, text|html, confirmButtonText, footer, etc.
      : { icon: type, text: String(data) };

    Swal.fire(opts);
  }

  fire('success', window.success_message);
  fire('error',   window.error_message);
  fire('warning', window.warning_message);
  fire('info',    window.info_message);
});