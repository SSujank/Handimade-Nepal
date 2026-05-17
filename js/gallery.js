/* ============================================
   Handicraft Online Store — Gallery Lightbox & Filter
   ============================================ */

(function () {
    'use strict';

    const galleryItems = document.querySelectorAll('.gallery-item');
    const lightbox = document.getElementById('lightbox');
    if (galleryItems.length === 0 || !lightbox) return;

    const lightboxImage = lightbox.querySelector('.lightbox-image');
    const lightboxCaption = lightbox.querySelector('.lightbox-caption');
    const closeBtn = lightbox.querySelector('.lightbox-close');
    const prevBtn = lightbox.querySelector('.lightbox-prev');
    const nextBtn = lightbox.querySelector('.lightbox-next');

    let currentIndex = 0;
    let visibleItems = Array.from(galleryItems);

    function openLightbox(index) {
        currentIndex = index;
        const item = visibleItems[index];
        const src = item.getAttribute('data-full') || item.getAttribute('data-src');
        const caption = item.getAttribute('data-caption') || '';

        lightboxImage.src = src;
        lightboxImage.alt = caption;
        lightboxCaption.textContent = caption;

        lightbox.classList.add('open');
        lightbox.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
        closeBtn.focus();
    }

    function closeLightbox() {
        lightbox.classList.remove('open');
        lightbox.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
    }

    function showPrev() {
        currentIndex = (currentIndex - 1 + visibleItems.length) % visibleItems.length;
        openLightbox(currentIndex);
    }

    function showNext() {
        currentIndex = (currentIndex + 1) % visibleItems.length;
        openLightbox(currentIndex);
    }

    // Attach click/keyboard handlers to gallery items
    galleryItems.forEach(function (item, index) {
        // Make items keyboard-focusable
        if (!item.hasAttribute('tabindex')) {
            item.setAttribute('tabindex', '0');
        }
        item.setAttribute('role', 'button');

        item.addEventListener('click', function () {
            visibleItems = Array.from(document.querySelectorAll('.gallery-item:not(.hidden)'));
            const visibleIndex = visibleItems.indexOf(item);
            if (visibleIndex !== -1) openLightbox(visibleIndex);
        });

        item.addEventListener('keydown', function (e) {
            if (e.key === 'Enter' || e.key === ' ') {
                e.preventDefault();
                item.click();
            }
        });
    });

    // Close, prev, next controls
    closeBtn.addEventListener('click', closeLightbox);
    prevBtn.addEventListener('click', showPrev);
    nextBtn.addEventListener('click', showNext);

    // Close by clicking backdrop
    lightbox.addEventListener('click', function (e) {
        if (e.target === lightbox) closeLightbox();
    });

    // Keyboard navigation
    document.addEventListener('keydown', function (e) {
        if (!lightbox.classList.contains('open')) return;
        if (e.key === 'Escape') closeLightbox();
        if (e.key === 'ArrowLeft') showPrev();
        if (e.key === 'ArrowRight') showNext();
    });

    // Filter buttons
    const filterButtons = document.querySelectorAll('.filter-btn');
    filterButtons.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const category = btn.getAttribute('data-filter');

            filterButtons.forEach(function (b) {
                b.classList.remove('active');
                b.setAttribute('aria-pressed', 'false');
            });
            btn.classList.add('active');
            btn.setAttribute('aria-pressed', 'true');

            galleryItems.forEach(function (item) {
                const itemCategory = item.getAttribute('data-category');
                if (category === 'all' || itemCategory === category) {
                    item.classList.remove('hidden');
                } else {
                    item.classList.add('hidden');
                }
            });
        });
    });
})();
