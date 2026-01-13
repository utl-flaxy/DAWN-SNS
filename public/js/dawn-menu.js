(function () {
  const btn = document.querySelector('[data-dawn-menu-button]');
  const menu = document.querySelector('[data-dawn-menu]');
  if (!btn || !menu) return;

  function openMenu() {
    menu.hidden = false;
    btn.setAttribute('aria-expanded', 'true');
  }
  function closeMenu() {
    menu.hidden = true;
    btn.setAttribute('aria-expanded', 'false');
  }
  function toggleMenu() {
    if (menu.hidden) openMenu();
    else closeMenu();
  }

  btn.addEventListener('click', (e) => {
    e.preventDefault();
    e.stopPropagation();
    toggleMenu();
  });

  document.addEventListener('click', () => closeMenu());
  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape') closeMenu();
  });

  // メニュー内クリックは閉じない（リンク遷移はする）
  menu.addEventListener('click', (e) => e.stopPropagation());

  closeMenu();
})();
