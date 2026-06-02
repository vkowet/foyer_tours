/**
 * Custom JavaScript pour le thème Foyer FSM
 * À charger dans functions.php
 */
jQuery(document).ready(function($) {
    'use strict';

    // ===== 1. ANIMATIONS AU SCROLL =====
    function checkFadeIn() {
        $('.fade-in').each(function() {
            const elementTop = $(this).offset().top;
            const windowBottom = $(window).scrollTop() + $(window).height();
            const elementHeight = $(this).outerHeight();
            
            if (elementTop < windowBottom - (elementHeight / 3)) {
                $(this).addClass('visible');
            }
        });
    }
    
    // Initial check
    checkFadeIn();
    
    // Check on scroll with throttle pour performance
    let scrollTimeout;
    $(window).on('scroll', function() {
        if (!scrollTimeout) {
            scrollTimeout = setTimeout(function() {
                checkFadeIn();
                scrollTimeout = null;
            }, 50);
        }
    });

    // ===== 2. SMOOTH SCROLL POUR LES ANCRES =====
    $('a[href*="#"]:not([href="#"])').on('click', function(e) {
        if (location.pathname.replace(/^\//, '') === this.pathname.replace(/^\//, '') 
            && location.hostname === this.hostname) {
            
            const target = $(this.hash);
            if (target.length) {
                e.preventDefault();
                
                $('html, body').animate({
                    scrollTop: target.offset().top - 100
                }, 800, 'easeInOutCubic');
                
                // Update URL hash
                if (history.pushState) {
                    history.pushState(null, null, this.hash);
                }
            }
        }
    });

    // ===== 3. GALERIE LIGHTBOX SIMPLE =====
    $('.gallery-item a, .chambre-image a').on('click', function(e) {
        e.preventDefault();
        
        const imgSrc = $(this).attr('href');
        const imgAlt = $(this).find('img').attr('alt') || 'Image du foyer';
        
        const modalHTML = `
            <div class="foyer-lightbox">
                <div class="lightbox-overlay"></div>
                <div class="lightbox-content">
                    <span class="lightbox-close">&times;</span>
                    <img src="${imgSrc}" alt="${imgAlt}">
                </div>
            </div>
        `;
        
        $('body').append(modalHTML).css('overflow', 'hidden');
        
        // Fermeture
        $('.lightbox-close, .lightbox-overlay').on('click', function() {
            $('.foyer-lightbox').fadeOut(300, function() {
                $(this).remove();
                $('body').css('overflow', '');
            });
        });
        
        // Fermeture avec Echap
        $(document).on('keyup.lightbox', function(e) {
            if (e.key === 'Escape') {
                $('.foyer-lightbox').fadeOut(300, function() {
                    $(this).remove();
                    $('body').css('overflow', '');
                    $(document).off('keyup.lightbox');
                });
            }
        });
    });

    // ===== 4. VALIDATION FORMULAIRE EN TEMPS RÉEL =====
    function validateEmail(email) {
        const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
    
    function validatePhone(phone) {
        const re = /^[0-9+\-\s]{10,}$/;
        return re.test(phone.replace(/\s/g, ''));
    }
    
    $('.foyer-form input, .foyer-form textarea, .foyer-form select').on('blur', function() {
        const field = $(this);
        const value = field.val();
        const fieldName = field.attr('name');
        const type = field.attr('type');
        
        // Remove existing error
        field.removeClass('error');
        field.next('.error-msg').remove();
        
        if (value) {
            if (type === 'email' && !validateEmail(value)) {
                field.addClass('error');
                field.after('<span class="error-msg">Email invalide</span>');
            } else if (fieldName === 'telephone' && !validatePhone(value)) {
                field.addClass('error');
                field.after('<span class="error-msg">Téléphone invalide</span>');
            }
        }
    });

    // ===== 5. COMPTEUR DE CARACTÈRES =====
    $('textarea[maxlength]').on('input', function() {
        const max = $(this).attr('maxlength');
        const current = $(this).val().length;
        const remaining = max - current;
        
        let counter = $(this).next('.char-counter');
        if (!counter.length) {
            counter = $('<span class="char-counter"></span>').insertAfter($(this));
        }
        
        counter.text(`${remaining} caractères restants`);
        
        if (remaining < 20) {
            counter.css('color', '#C06B4A');
        } else {
            counter.css('color', '#666');
        }
    });

    // ===== 6. EFFET DE SURVOL SUR LES CARTES =====
    $('.chambre-card').on('mouseenter', function() {
        $(this).find('.chambre-image img').css('transform', 'scale(1.1)');
    }).on('mouseleave', function() {
        $(this).find('.chambre-image img').css('transform', 'scale(1)');
    });

    // ===== 7. FILTRE DES CHAMBRES (si nécessaire) =====
    $('.chambre-filter').on('change', function() {
        const filter = $(this).val();
        
        if (filter === 'all') {
            $('.chambre-card').fadeIn();
        } else {
            $('.chambre-card').each(function() {
                if ($(this).data('type') === filter) {
                    $(this).fadeIn();
                } else {
                    $(this).fadeOut();
                }
            });
        }
    });
});