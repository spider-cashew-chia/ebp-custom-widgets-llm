/**
 * Character Split Animation for Hero H1 using GSAP SplitText
 *
 * This script uses GSAP SplitText to split the H1 heading by words
 * (to preserve line breaks) and then by characters, adding space
 * between each character so the heading compresses to its normal size.
 */

(function () {
  'use strict';

  // Wait for DOM to be ready and GSAP/SplitText to be loaded
  document.addEventListener('DOMContentLoaded', function () {
    // Check if GSAP and SplitText are available
    if (typeof gsap === 'undefined' || typeof SplitText === 'undefined') {
      console.warn(
        'GSAP or SplitText not loaded. Hero H1 character splitting will not work.',
      );
      return;
    }

    // Find all H1 elements within the hero widget
    const heroH1s = document.querySelectorAll('.ebp-custom-hero-1 h1');

    // If no H1 elements found, exit early
    if (heroH1s.length === 0) {
      return;
    }

    // Process each H1 element
    heroH1s.forEach(function (h1) {
      // Use SplitText to split by words and characters
      // This preserves line breaks (words) and splits each word into characters
      const split = new SplitText(h1, {
        type: 'words,chars', // Split into words first, then characters
        wordsClass: 'split-word', // CSS class for each word
        charsClass: 'split-char', // CSS class for each character
      });

      // Get all the character elements that SplitText created
      const chars = split.chars;

      // Set initial state: characters start with 1rem margin-right and are visible
      // This makes the heading expanded/spread out initially
      gsap.set(chars, {
        display: 'inline-block',
        marginRight: '1.3rem',
        opacity: 1,
      });

      // Animate margin-right from 1rem to 0 with a stagger effect
      // This compresses the heading down to its normal size
      gsap.to(chars, {
        marginRight: '0',
        duration: 1, // Animation duration for each character
        ease: 'back.out(1.7)', // Easing function for smooth animation
        delay: 0.3, // 1.5 second delay before animation starts
        stagger: 0.05, // Small stagger between each character (20ms)
      });
    });
  });
})();
