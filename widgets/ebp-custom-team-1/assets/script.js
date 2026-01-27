/**
 * GSAP Scroll Animation for Team Widget
 *
 * This script animates team member items (.ebp-custom-team-1__item)
 * with a stagger reveal effect using clip-path on scroll.
 */

(function () {
  'use strict';

  // Wait for DOM to be ready and GSAP/ScrollTrigger to be loaded
  document.addEventListener('DOMContentLoaded', function () {
    // Check if GSAP and ScrollTrigger are available
    if (typeof gsap === 'undefined' || typeof ScrollTrigger === 'undefined') {
      console.warn(
        'GSAP or ScrollTrigger not loaded. Team animations will not work.',
      );
      return;
    }

    // Register ScrollTrigger plugin with GSAP
    gsap.registerPlugin(ScrollTrigger);

    // Find all team member items
    const teamItems = document.querySelectorAll('.ebp-custom-team-1__item');

    // If no items found, exit early
    if (teamItems.length === 0) {
      return;
    }

    // Set initial state: hide all items using clip-path from bottom
    teamItems.forEach(function (item) {
      gsap.set(item, {
        clipPath: 'inset(100% 0% 0% 0%)', // Start fully clipped (hidden from top)
        opacity: 1, // Keep opacity at 1 so we only animate clip-path
      });
    });

    // Use ScrollTrigger.batch to group items that come into view together
    // This will detect items in the same row and animate them with a stagger
    ScrollTrigger.batch(teamItems, {
      onEnter: function (elements) {
        // Animate all elements in this batch with a stagger effect
        gsap.to(elements, {
          clipPath: 'inset(0% 0% 0% 0%)', // End state: fully visible (no clipping)
          duration: 1.7, // Animation duration for each item
          ease: 'power2.out', // Easing function for smooth animation
          stagger: 0.3, // Delay between each item in the batch (200ms)
        });
      },
      start: 'top 85%', // Start animation when top of batch is 85% down the viewport
      end: 'top 50%', // End animation when top of batch is 50% down the viewport
      toggleActions: 'play none none none', // Only play on enter, no reverse
    });
  });
})();
