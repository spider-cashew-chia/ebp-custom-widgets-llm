/**
 * GSAP Scroll Animation for Elementor Parent Containers
 *
 * This script finds all divs with class .e-parent and animates
 * their h2, h3, and h4 headings using SplitText to reveal from the bottom on scroll.
 */

(function () {
  'use strict';

  // Wait for DOM to be ready and GSAP/ScrollTrigger/SplitText to be loaded
  document.addEventListener('DOMContentLoaded', function () {
    // Check if GSAP, ScrollTrigger, and SplitText are available
    if (
      typeof gsap === 'undefined' ||
      typeof ScrollTrigger === 'undefined' ||
      typeof SplitText === 'undefined'
    ) {
      console.warn(
        'GSAP, ScrollTrigger, or SplitText not loaded. Scroll animations will not work.',
      );
      return;
    }

    // Register plugins with GSAP
    gsap.registerPlugin(ScrollTrigger);

    // Find all parent containers with class .e-parent
    const parentContainers = document.querySelectorAll('.e-parent');

    // If no containers found, exit early
    if (parentContainers.length === 0) {
      return;
    }

    // Loop through each parent container
    parentContainers.forEach(function (container) {
      // Find all h2, h3, and h4 elements within this container
      const headings = container.querySelectorAll('h2, h3, h4');

      // If no headings found in this container, skip it
      if (headings.length === 0) {
        return;
      }

      // Create a scroll-triggered animation for each heading
      headings.forEach(function (heading) {
        // Use SplitText to split the heading into words
        // This creates individual elements for each word that we can animate
        const split = new SplitText(heading, {
          type: 'words', // Split into words
          wordsClass: 'split-word', // CSS class for each word
        });

        // Get all the word elements that SplitText created
        const words = split.words;

        // Set initial state: hide all words using clip-path from bottom
        // Each word starts fully clipped (hidden from top)
        gsap.set(words, {
          clipPath: 'inset(100% 0% 0% 0%)', // Start fully clipped (hidden from top)
          opacity: 1, // Keep opacity at 1 so we only animate clip-path
        });

        // Animate all words with a stagger effect
        // This creates a cascading reveal effect where words appear one after another
        gsap.to(words, {
          clipPath: 'inset(0% 0% 0% 0%)', // End state: fully visible (no clipping)
          duration: 0.8, // Animation duration for each word
          ease: 'power2.out', // Easing function for smooth animation
          stagger: 0.05, // Delay between each word animation (50ms)
          scrollTrigger: {
            trigger: heading, // Element that triggers the animation
            start: 'top 85%', // Start animation when top of element is 85% down the viewport
            end: 'top 50%', // End animation when top of element is 50% down the viewport
            toggleActions: 'play none none none', // Only play on enter, no reverse
            // Optional: uncomment to see trigger points during development
            // markers: true
          },
        });
      });
    });
  });
})();
