document.addEventListener('DOMContentLoaded', function () {

  const body = document.body;
  const toggle = document.querySelector('.mobile-menu-toggle');
  const overlay = document.querySelector('.mobile-menu-overlay');

  if (!toggle || !overlay) {
    console.warn('Menu mobile : éléments manquants');
    return;
  }

  toggle.addEventListener('click', function () {
    const isOpen = body.classList.toggle('menu-open');
    overlay.classList.toggle('is-open', isOpen);
    toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
  });

  // Fermer le menu au clic en dehors
  overlay.addEventListener('click', function (e) {
    if (e.target === overlay) {
      body.classList.remove('menu-open');
      overlay.classList.remove('is-open');
      toggle.setAttribute('aria-expanded', 'false');
    }
  });

});
