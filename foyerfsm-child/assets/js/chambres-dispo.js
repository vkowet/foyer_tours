jQuery(document).ready(function($) {
    
    // Initialisation des Swiper (carrousels)
    if (typeof Swiper !== 'undefined') {
        $('.chambre-gallery').each(function() {
            new Swiper(this, {
                loop: true,
                autoplay: {
                    delay: 4000,
                    disableOnInteraction: false,
                },
                pagination: {
                    el: '.swiper-pagination',
                    clickable: true,
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
                effect: 'slide',
                speed: 800,
            });
        });
    }
    
    // Filtre de disponibilité
    let totalDisponibles = parseInt($('#total-disponibles').val()) || 0;
    $('#chambres-disponibles-count').text(totalDisponibles);
    
    $('.filtre-btn').on('click', function() {
        $('.filtre-btn').removeClass('active');
        $(this).addClass('active');
        
        const filter = $(this).data('dispo');
        
        if (filter === 'all') {
            $('.chambre-card-dispo').show();
        } else if (filter === 'disponible') {
            $('.chambre-card-dispo').hide();
            $('.chambre-card-dispo.disponible').show();
        }
    });
    
    // Ouverture du modal de demande
    $('.btn-demande:not(.disabled)').on('click', function() {
        const chambreId = $(this).data('chambre-id');
        const chambreTitre = $(this).data('chambre-titre');
        
        $('#form-chambre-id').val(chambreId);
        $('#modal-chambre-titre').text(chambreTitre);
        $('#demande-modal').addClass('active');
        $('body').css('overflow', 'hidden');
    });
    
    // Ouverture du modal des détails
    $('.btn-details').on('click', function() {
        const chambreId = $(this).data('chambre-id');
        
        // Charger les détails via AJAX
        $.ajax({
            url: chambresAjax.ajax_url,
            type: 'POST',
            data: {
                action: 'get_chambre_details',
                chambre_id: chambreId,
                nonce: chambresAjax.nonce
            },
            success: function(response) {
                if (response.success) {
                    $('#details-content').html(response.data.html);
                    $('#details-modal').addClass('active');
                    $('body').css('overflow', 'hidden');
                }
            }
        });
    });
    
    // Lightbox sur les images de galerie
    let currentImageIndex = 0;
    let currentImages = [];
    
    $('.chambre-gallery .swiper-slide').on('click', function(e) {
        e.stopPropagation();
        const gallery = $(this).closest('.chambre-gallery');
        const images = gallery.find('.swiper-slide img');
        
        currentImages = [];
        images.each(function() {
            currentImages.push($(this).attr('src'));
        });
        
        currentImageIndex = images.index($(this).find('img'));
        
        if (currentImages.length > 0) {
            $('#lightbox .lightbox-image').attr('src', currentImages[currentImageIndex]);
            $('#lightbox').addClass('active');
            $('body').css('overflow', 'hidden');
        }
    });
    
    // Fermeture des modals
    $('.modal-close, .lightbox-close').on('click', function() {
        $('.modal, #lightbox').removeClass('active');
        $('body').css('overflow', '');
    });
    
    // Fermeture en cliquant en dehors
    $(window).on('click', function(e) {
        if ($(e.target).hasClass('modal')) {
            $('.modal').removeClass('active');
            $('body').css('overflow', '');
        }
        if ($(e.target).hasClass('lightbox')) {
            $('#lightbox').removeClass('active');
            $('body').css('overflow', '');
        }
    });
    
    // Navigation lightbox
    $('.lightbox-prev').on('click', function() {
        currentImageIndex = (currentImageIndex - 1 + currentImages.length) % currentImages.length;
        $('#lightbox .lightbox-image').attr('src', currentImages[currentImageIndex]);
    });
    
    $('.lightbox-next').on('click', function() {
        currentImageIndex = (currentImageIndex + 1) % currentImages.length;
        $('#lightbox .lightbox-image').attr('src', currentImages[currentImageIndex]);
    });
    
    // Keyboard navigation
    $(document).on('keydown', function(e) {
        if ($('#lightbox').hasClass('active')) {
            if (e.key === 'ArrowLeft') {
                $('.lightbox-prev').click();
            } else if (e.key === 'ArrowRight') {
                $('.lightbox-next').click();
            } else if (e.key === 'Escape') {
                $('#lightbox').removeClass('active');
                $('body').css('overflow', '');
            }
        } else if ($('.modal').hasClass('active')) {
            if (e.key === 'Escape') {
                $('.modal').removeClass('active');
                $('body').css('overflow', '');
            }
        }
    });
    
    // Submission du formulaire via AJAX
    $('#demande-chambre-form').on('submit', function(e) {
        e.preventDefault();
        
        const formData = $(this).serialize();
        
        $.ajax({
            url: chambresAjax.ajax_url,
            type: 'POST',
            data: formData + '&ajax=1',
            success: function(response) {
                if (response.success) {
                    alert('✅ ' + response.data.message);
                    $('#demande-modal').removeClass('active');
                    $('#demande-chambre-form')[0].reset();
                    $('body').css('overflow', '');
                } else {
                    alert('❌ ' + response.data.message);
                }
            },
            error: function() {
                alert('Une erreur est survenue. Veuillez réessayer.');
            }
        });
    });
    
    // Mise à jour du compteur après filtre
    $('.filtre-btn').trigger('click');
});