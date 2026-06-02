document.addEventListener('DOMContentLoaded', function () {
    console.log('✅ slider.js chargé');

    const slider = document.querySelector('.hero-slider');
    if (!slider) return;

    const slides = Array.from(slider.querySelectorAll('.slide'));
    const dotsContainer = slider.querySelector('.slider-dots');
    const speed = parseInt(slider.dataset.speed, 10) || 5000;

    if (!slides.length) return;

    let currentSlide = 0;
    let interval = null;
    let isTransitioning = false;

    function showSlide(index) {
        slides.forEach((slide, i) => {
            const image = slide.querySelector('.slide-image');

            slide.classList.toggle('active', i === index);
            slide.style.opacity = i === index ? '1' : '0';
            slide.style.visibility = i === index ? 'visible' : 'hidden';
            slide.style.zIndex = i === index ? '2' : '1';

            if (image) {
                image.style.opacity = '1';
                image.style.visibility = 'visible';
                image.style.display = 'block';
            }
        });

        document.querySelectorAll('.dot').forEach((dot, i) => {
            dot.classList.toggle('active', i === index);
        });

        currentSlide = index;
    }

    if (dotsContainer) {
        dotsContainer.innerHTML = '';

        slides.forEach((_, index) => {
            const dot = document.createElement('span');
            dot.className = 'dot';

            dot.addEventListener('click', function () {
                stopAutoplay();
                goToSlide(index);
                startAutoplay();
            });

            dotsContainer.appendChild(dot);
        });
    }

    function goToSlide(index) {
        if (isTransitioning || index === currentSlide) return;

        isTransitioning = true;

        const oldSlide = slides[currentSlide];
        const newSlide = slides[index];

        oldSlide.style.zIndex = '1';
        newSlide.style.zIndex = '2';
        newSlide.style.visibility = 'visible';
        newSlide.style.opacity = '1';

        oldSlide.classList.remove('active');
        newSlide.classList.add('active');

        setTimeout(() => {
            oldSlide.style.opacity = '0';
            oldSlide.style.visibility = 'hidden';

            showSlide(index);
            isTransitioning = false;
        }, 50);
    }

    function nextSlide() {
        goToSlide((currentSlide + 1) % slides.length);
    }

    function prevSlide() {
        goToSlide((currentSlide - 1 + slides.length) % slides.length);
    }

    const nextBtn = slider.querySelector('.slider-next');
    const prevBtn = slider.querySelector('.slider-prev');

    if (nextBtn) {
        nextBtn.addEventListener('click', function (e) {
            e.preventDefault();
            stopAutoplay();
            nextSlide();
            startAutoplay();
        });
    }

    if (prevBtn) {
        prevBtn.addEventListener('click', function (e) {
            e.preventDefault();
            stopAutoplay();
            prevSlide();
            startAutoplay();
        });
    }

    function startAutoplay() {
        stopAutoplay();
        interval = setInterval(nextSlide, speed);
    }

    function stopAutoplay() {
        if (interval) {
            clearInterval(interval);
            interval = null;
        }
    }

    slider.addEventListener('mouseenter', stopAutoplay);
    slider.addEventListener('mouseleave', startAutoplay);

    showSlide(0);
    startAutoplay();

    console.log('✅ Slider initialisé avec', slides.length, 'slides');
});