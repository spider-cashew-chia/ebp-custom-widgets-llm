/**
 * GSAP Scroll Animation for Elementor Parent Containers
 *
 * - h2, h3, h4, p, ul inside .e-parent: fade-up (25px, opacity 0→1). Footer skipped.
 * - .ebp-custom-text-image-1__image img, .ebp-custom-blog-hub-1__item-image img, .ebp-custom-feedback-1__content__image img: scale 1.3→1 on scroll (wrappers have overflow:hidden).
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.warn(
        'GSAP or ScrollTrigger not loaded. Scroll animations will not work.',
      );
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const parentContainers = document.querySelectorAll('.e-parent');
    if (parentContainers.length === 0) {
      return;
    }

    // Elements to animate: headings, paragraphs, and lists
    const selector = 'h2, h3, h4, p, li, a';

    parentContainers.forEach(function (container) {
      const elements = container.querySelectorAll(selector);
      if (elements.length === 0) {
        return;
      }

      elements.forEach(function (el) {
        // Skip elements inside the footer
        if (el.closest('footer')) {
          return;
        }
        // Start hidden and 25px lower; animate up and fade in
        gsap.fromTo(
          el,
          {
            y: 25,
            opacity: 0,
          },
          {
            y: 0,
            opacity: 1,
            duration: 0.6,
            ease: 'power2.out',
            scrollTrigger: {
              trigger: el,
              start: 'top 85%',
              toggleActions: 'play none none none',
            },
          },
        );
      });
    });

    // Image zoom-out on scroll: text-image-1, blog-hub-1, feedback-1 (scale 1.3 → 1)
    const zoomImgs = document.querySelectorAll(
      '.ebp-custom-text-image-1__image img, .ebp-custom-blog-hub-1__item-image img, .ebp-custom-feedback-1__content__image img',
    );
    zoomImgs.forEach(function (img) {
      const wrapper = img.closest(
        '.ebp-custom-text-image-1__image, .ebp-custom-blog-hub-1__item-image, .ebp-custom-feedback-1__content__image',
      );
      if (!wrapper) return;
      gsap.fromTo(
        img,
        { scale: 1.3 },
        {
          scale: 1,
          duration: 2.5,
          ease: 'power4.out',
          scrollTrigger: {
            trigger: wrapper,
            start: 'top 70%',
            toggleActions: 'play none none none',
          },
        },
      );
    });
  });
})();
