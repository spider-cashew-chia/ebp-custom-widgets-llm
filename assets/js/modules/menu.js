/**
 * Menu Toggle Animation
 * Handles the opening and closing of the custom menu container
 * Uses GSAP for smooth animations
 */

(function () {
  'use strict';

  // Wait for DOM to be ready
  document.addEventListener('DOMContentLoaded', function () {
    // Get the menu toggle button and menu container
    const menuToggle = document.querySelector('.menu-toggle');
    const menuContainer = document.querySelector('.custom-menu__container');

    // Check if both elements exist before proceeding
    if (!menuToggle || !menuContainer) {
      return;
    }

    // Create a GSAP timeline for the menu animation
    // This allows us to reverse the animation easily
    const menuTimeline = gsap.timeline({ paused: true });

    // Set up the animation
    // When played forward: opacity goes to 1, pointer-events becomes auto
    // When reversed: opacity goes to 0, pointer-events becomes none
    menuTimeline.to(menuContainer, {
      opacity: 1,
      pointerEvents: 'auto',
      duration: 0.4,
      ease: 'power2.out',
    });

    // Track whether menu is open or closed
    let isMenuOpen = false;

    // Add click event listener to the menu toggle button
    menuToggle.addEventListener('click', function () {
      // Toggle the menu state
      if (isMenuOpen) {
        // Menu is open, so close it by reversing the timeline
        menuTimeline.reverse();
        isMenuOpen = false;
      } else {
        // Menu is closed, so open it by playing the timeline forward
        menuTimeline.play();
        isMenuOpen = true;
      }
    });
  });
})();
