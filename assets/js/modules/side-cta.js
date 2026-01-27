/**
 * Side CTA Scroll Behavior
 *
 * After scrolling 75px from the top, removes any inline styles
 * to allow CSS to handle all styling behavior
 * On mobile (under 767px), CTAs are collapsed by default
 */

(function () {
  'use strict';

  // Get all side CTA div elements
  const sideCtaDivs = document.querySelectorAll('.side-ctas > a');

  // Check if any side CTA divs exist
  if (sideCtaDivs.length === 0) {
    return;
  }

  // Breakpoint for mobile collapse behavior
  const MOBILE_BREAKPOINT = 767;

  /**
   * Checks if viewport is mobile size (under 767px)
   * @returns {boolean} True if viewport width is under 767px
   */
  function isMobile() {
    return window.innerWidth <= MOBILE_BREAKPOINT;
  }

  /**
   * Handles mobile collapse behavior
   * Adds or removes mobile-collapsed class based on viewport width
   */
  function handleMobileCollapse() {
    if (isMobile()) {
      // On mobile, add class to collapse CTAs by default
      document.body.classList.add('mobile-collapsed');
    } else {
      // On desktop, remove mobile collapse class
      document.body.classList.remove('mobile-collapsed');
    }
  }

  /**
   * Handles scroll events and removes inline styles when scrolled 75px or more
   * Also adds a body class to allow CSS to handle styling
   * Works on all screen sizes - mobile collapse is handled separately via mobile-collapsed class
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
      // Add scrolled class to body for CSS targeting (used by header and side-ctas)
      document.body.classList.add('scrolled');
    } else {
      // Remove scrolled class when back at top
      document.body.classList.remove('scrolled');
    }
  }

  // Check mobile state on page load
  handleMobileCollapse();

  // Handle resize events to maintain mobile collapse behavior
  window.addEventListener('resize', handleMobileCollapse, { passive: true });

  // Add scroll event listener
  // Using passive: true for better performance
  window.addEventListener('scroll', handleScroll, { passive: true });
})();
