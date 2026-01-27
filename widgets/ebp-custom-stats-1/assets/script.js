/**
 * Stats count-up animation on scroll
 * Animates numbers from 0 inside .ebp-custom-stats-1__item__text h3 when the block enters view.
 * Uses .e-con (Elementor container) as the ScrollTrigger.
 * Supports an optional % suffix (e.g. "99" or "99%").
 */

(function () {
  'use strict';

  document.addEventListener('DOMContentLoaded', function () {
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      return;
    }

    gsap.registerPlugin(ScrollTrigger);

    // Numbers live in the h3 inside each stat item text block
    const headingEls = document.querySelectorAll(
      '.ebp-custom-stats-1__item__text h3',
    );
    if (headingEls.length === 0) return;

    // Regex: leading number (digits, commas, dots), optional space, optional % at end
    const numberSuffixRe = /^([\d,.]+)\s*(%?)$/;

    // Group by closest .e-con (scroll trigger)
    const byCon = new Map();

    headingEls.forEach(function (h3) {
      const con = h3.closest('.e-con');
      if (!con) return;

      const raw = h3.textContent.replace(/\s+/g, ' ').trim();
      const match = raw.match(numberSuffixRe);
      if (!match) return;

      const endVal = parseFloat(match[1].replace(/,/g, ''), 10);
      const suffix = match[2];

      // Replace the h3's content with a span we animate
      const span = document.createElement('span');
      span.className = 'ebp-custom-stats-1__count';
      h3.textContent = '';
      h3.appendChild(span);

      if (!byCon.has(con)) {
        byCon.set(con, []);
      }
      byCon.get(con).push({
        span,
        endVal,
        suffix,
      });
    });

    // For each .e-con, run count-up when it enters view
    byCon.forEach(function (items, triggerEl) {
      items.forEach(function (item) {
        const obj = { n: 0 };
        gsap.to(obj, {
          n: item.endVal,
          duration: 2.5,
          delay: 0.3,
          ease: 'power2.out',
          onUpdate: function () {
            const display = String(Math.round(obj.n));
            item.span.textContent = display + item.suffix;
          },
          scrollTrigger: {
            trigger: triggerEl,
            start: 'top 85%',
            toggleActions: 'play none none none',
          },
        });
      });
    });
  });
})();
