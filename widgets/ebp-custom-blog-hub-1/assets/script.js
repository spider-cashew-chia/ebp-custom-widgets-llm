/**
 * Blog Hub – animated text on touch devices
 *
 * On touch devices (.animated-text does not reveal on hover), this script
 * reveals .animated-text when each card (.ebp-custom-blog-hub-1__inner a)
 * scrolls into view, using that link as the ScrollTrigger.
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.warn(
        'GSAP or ScrollTrigger not loaded. Blog hub touch animations will not work.',
      );
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    const items = document.querySelectorAll('.ebp-custom-blog-hub-1__inner a');
    if (items.length === 0) return;

    // On touch devices: reveal .animated-text when each card scrolls into view
    if (window.matchMedia('(hover: none)').matches) {
      items.forEach(function (item) {
        const animatedText = item.querySelector('.animated-text');
        if (!animatedText) return;

        ScrollTrigger.create({
          trigger: item,
          start: 'top 85%',
          onEnter: function () {
            gsap.to(animatedText, {
              left: 0,
              duration: 0.3,
              ease: 'power2.inOut',
            });
          },
          toggleActions: 'play none none none',
        });
      });
    }
  });
})();
