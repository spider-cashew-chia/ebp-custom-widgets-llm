/**
 * Side CTA Scroll Behavior
 *
 * After scrolling 75px from the top, removes any inline styles
 * to allow CSS to handle all styling behavior
 */

(function () {
  'use strict';

  // Get all side CTA div elements
  const sideCtaDivs = document.querySelectorAll('.side-ctas > a');

  // Check if any side CTA divs exist
  if (sideCtaDivs.length === 0) {
    return;
  }

  /**
   * Handles scroll events and removes inline styles when scrolled 75px or more
   * Also adds a body class to allow CSS to handle styling
   */
  function handleScroll() {
    // Get current scroll position from the top of the page
    const scrollY = window.scrollY || window.pageYOffset;

    // If scrolled 75px or more, remove inline style and add scrolled class
    if (scrollY >= 75) {
      // Remove inline style to allow CSS to take over
      sideCtaDivs.forEach((div) => {
        div.style.right = '';
      });
      // Add scrolled class to body for CSS targeting
      document.body.classList.add('scrolled');
    } else {
      // Remove scrolled class when back at top
      document.body.classList.remove('scrolled');
    }
  }

  // Add scroll event listener
  // Using passive: true for better performance
  window.addEventListener('scroll', handleScroll, { passive: true });
})();
