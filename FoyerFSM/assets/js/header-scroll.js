document.addEventListener('DOMContentLoaded', function () {
  const header = document.querySelector('.site-header');

  if (!header) return;

  // Flag debug
  window.foyerHeaderScrollLoaded = true;

  function onScroll() {
    if (window.scrollY > 60) {
      header.classList.add('is-scrolled');
      header.classList.remove('is-hero');
    } else {
      header.classList.remove('is-scrolled');
      header.classList.add('is-hero');
    }
  }

  onScroll(); // état initial
  window.addEventListener('scroll', onScroll);
});
