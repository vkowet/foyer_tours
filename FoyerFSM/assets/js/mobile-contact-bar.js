document.addEventListener('DOMContentLoaded', () => {
  const bar = document.querySelector('.mobile-contact-bar');
  if (!bar) return;

  const TRIGGER_RATIO = 0.03; // 3 % de scroll
  const root = document.documentElement;

  /**
   * Applique l'espace bas de page via variable CSS
   * @param {number} px
   */
  function setBodySpace(px) {
    root.style.setProperty('--mobile-bar-space', `${px}px`);
  }

  /**
   * Hauteur réelle de la barre mobile
   */
  function getBarHeight() {
    return Math.ceil(bar.getBoundingClientRect().height || 0);
  }

  /**
   * Met à jour l'espace bas de page
   */
  function updateBodySpace() {
    if (bar.classList.contains('is-visible')) {
      setBodySpace(getBarHeight());
    } else {
      setBodySpace(0);
    }
  }

  /**
   * Gestion du scroll
   */
  function onScroll() {
    const scrollTop = window.scrollY;
    const maxScroll =
      document.documentElement.scrollHeight - window.innerHeight;

    if (maxScroll <= 0) return;

    const scrollRatio = scrollTop / maxScroll;
    const shouldShow = scrollRatio > TRIGGER_RATIO;

    bar.classList.toggle('is-visible', shouldShow);
    updateBodySpace();
  }

  /**
   * Listeners
   */
  window.addEventListener('scroll', onScroll, { passive: true });
  window.addEventListener('resize', updateBodySpace);
  window.addEventListener('orientationchange', updateBodySpace);

  /**
   * Init
   */
  setBodySpace(0);
});
