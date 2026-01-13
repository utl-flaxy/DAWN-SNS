import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// confirm dialog for forms
function setupConfirm() {
  document.addEventListener('submit', (e) => {
    const form = e.target;
    if (!(form instanceof HTMLFormElement)) return;

    const msg = form.getAttribute('data-confirm');
    if (!msg) return;

    const ok = window.confirm(msg);
    if (!ok) e.preventDefault();
  });
}

setupConfirm();
