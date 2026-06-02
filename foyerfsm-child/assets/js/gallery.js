/**
 * Galerie - Version finale
 */

document.addEventListener('DOMContentLoaded', function() {
    
    console.log('=== GALERIE JS ACTIVE ===');
    
    // ============================================
    // GALERIE PAGE D'ACCUEIL
    // ============================================
    
    const lightbox = document.getElementById('gallery-lightbox');
    const lightboxImg = document.getElementById('lightbox-image');
    const closeBtn = document.querySelector('.lightbox-close');
    const prevBtn = document.querySelector('.lightbox-prev');
    const nextBtn = document.querySelector('.lightbox-next');
    
    if (lightbox && lightboxImg) {
        let currentImages = [];
        let currentIndex = 0;
        
        const allImages = document.querySelectorAll('.gallery-advanced-link');
        
        allImages.forEach((link) => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                
                const activeCategories = document.querySelectorAll('.gallery-category.active');
                if (activeCategories.length) {
                    currentImages = [];
                    activeCategories.forEach(cat => {
                        const imgs = cat.querySelectorAll('.gallery-advanced-link');
                        imgs.forEach(img => currentImages.push(img));
                    });
                } else {
                    currentImages = Array.from(allImages);
                }
                
                currentIndex = currentImages.indexOf(this);
                lightboxImg.src = currentImages[currentIndex].href;
                lightbox.classList.add('active');
                document.body.style.overflow = 'hidden';
            });
        });
        
        if (prevBtn) {
            prevBtn.addEventListener('click', function() {
                if (!currentImages.length) return;
                currentIndex = (currentIndex - 1 + currentImages.length) % currentImages.length;
                lightboxImg.src = currentImages[currentIndex].href;
            });
        }
        
        if (nextBtn) {
            nextBtn.addEventListener('click', function() {
                if (!currentImages.length) return;
                currentIndex = (currentIndex + 1) % currentImages.length;
                lightboxImg.src = currentImages[currentIndex].href;
            });
        }
        
        if (closeBtn) {
            closeBtn.addEventListener('click', function() {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        lightbox.addEventListener('click', function(e) {
            if (e.target === lightbox) {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
        });
        
        document.addEventListener('keydown', function(e) {
            if (!lightbox.classList.contains('active')) return;
            if (e.key === 'Escape') {
                lightbox.classList.remove('active');
                document.body.style.overflow = '';
            }
            if (e.key === 'ArrowLeft' && prevBtn) prevBtn.click();
            if (e.key === 'ArrowRight' && nextBtn) nextBtn.click();
        });
    }
    
    // ============================================
    // FILTRES
    // ============================================
    
    const filterBtns = document.querySelectorAll('.gallery-advanced-filters .filter-btn');
    const categories = document.querySelectorAll('.gallery-category');
    
    if (filterBtns.length && categories.length) {
        filterBtns.forEach(btn => {
            btn.addEventListener('click', function() {
                filterBtns.forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                
                const filter = this.dataset.filter;
                
                categories.forEach(cat => {
                    if (cat.dataset.category === filter || filter === 'all') {
                        cat.classList.add('active');
                    } else {
                        cat.classList.remove('active');
                    }
                });
            });
        });
        
        const allBtn = document.querySelector('.gallery-advanced-filters .filter-btn[data-filter="all"]');
        if (allBtn) allBtn.click();
    }
    
    console.log('=== GALERIE JS TERMINÉ ===');
});