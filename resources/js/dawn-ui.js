export function setupDawnUI() {
  // dropdown toggle
  document.querySelectorAll('[data-dropdown-toggle]').forEach((btn) => {
    btn.addEventListener('click', (e) => {
      e.preventDefault();
      const target = btn.getAttribute('data-dropdown-toggle');
      const el = document.querySelector(target);
      if (!el) return;
      el.classList.toggle('is-hidden');
    });
  });

  // click outside close
  document.addEventListener('click', (e) => {
    const dd = document.querySelector('#dawnDropdown');
    const toggle = document.querySelector('[data-dropdown-toggle="#dawnDropdown"]');
    if (!dd || !toggle) return;

    const within = dd.contains(e.target) || toggle.contains(e.target);
    if (!within) dd.classList.add('is-hidden');
  });

  // confirm
  document.querySelectorAll('form[data-confirm]').forEach((form) => {
    form.addEventListener('submit', (e) => {
      const msg = form.getAttribute('data-confirm') || '実行しますか？';
      if (!window.confirm(msg)) {
        e.preventDefault();
      }
    });
  });
}
