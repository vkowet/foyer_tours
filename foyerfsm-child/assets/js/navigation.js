document.addEventListener('DOMContentLoaded', function() {
    const header = document.querySelector('.site-header');
    if (!header) return;
    
    const isHomePage = document.body.classList.contains('home') || 
                      document.body.classList.contains('front-page');
    
    if (isHomePage) {
        function handleScroll() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        }
        handleScroll();
        window.addEventListener('scroll', handleScroll);
    } else {
        header.classList.add('scrolled');
    }
});