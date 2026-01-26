/**
 * Timeline Slider using Swiper.js
 * Shows 3 slides on desktop, 1 slide on mobile (under 767px)
 */

(function () {
  'use strict';

  // Wait for DOM to be ready and Swiper to be available
  document.addEventListener('DOMContentLoaded', function () {
    // Check if Swiper is available
    if (typeof Swiper === 'undefined') {
      console.warn('Swiper.js is not loaded');
      return;
    }

    // Find all timeline slider instances on the page
    const timelineSliders = document.querySelectorAll(
      '.ebp-custom-timeline-1__slider-container'
    );

    // Initialize each slider instance
    timelineSliders.forEach(function (container) {
      initTimelineSlider(container);
    });
  });

  /**
   * Initialize a single timeline slider with Swiper.js
   * @param {HTMLElement} container - The slider container element
   */
  function initTimelineSlider(container) {
    // Get the Swiper container
    const swiperEl = container.querySelector('.swiper');

    // Get navigation buttons
    const prevBtn = container.querySelector(
      '.ebp-custom-timeline-1__nav-btn--prev'
    );
    const nextBtn = container.querySelector(
      '.ebp-custom-timeline-1__nav-btn--next'
    );

    // Debug: Log button elements
    console.log('Timeline Slider - Buttons found:', {
      prevBtn: prevBtn,
      nextBtn: nextBtn,
      prevBtnClasses: prevBtn ? prevBtn.className : 'not found',
      nextBtnClasses: nextBtn ? nextBtn.className : 'not found',
    });

    // Check if swiper element exists
    if (!swiperEl) {
      console.warn('Timeline Slider - Swiper element not found');
      return;
    }

    // Initialize Swiper
    const swiper = new Swiper(swiperEl, {
      // Number of slides to show
      slidesPerView: 3,
      // Space between slides
      spaceBetween: 16,
      // Enable loop mode
      loop: true,
      // Responsive breakpoints
      breakpoints: {
        // Mobile: show 1 slide
        0: {
          slidesPerView: 1,
          spaceBetween: 8,
        },
        // Desktop: show 3 slides
        768: {
          slidesPerView: 3,
          spaceBetween: 16,
        },
      },
    });

    console.log('Timeline Slider - Swiper initialized:', {
      swiper: swiper,
      activeIndex: swiper.activeIndex,
      slides: swiper.slides.length,
    });

    // Manually add click handlers to ensure buttons work correctly
    // Check if buttons exist and add handlers
    if (prevBtn) {
      // Previous button - goes backward (to previous slide)
      prevBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('=== PREV BUTTON CLICKED ===');
        console.log('Event target:', e.target);
        console.log('Event currentTarget:', e.currentTarget);
        console.log('Button element:', prevBtn);
        console.log('Button classes:', prevBtn.className);
        console.log('Is same element?', e.currentTarget === prevBtn);
        console.log('Before slidePrev - activeIndex:', swiper.activeIndex);
        swiper.slidePrev();
        console.log('After slidePrev - activeIndex:', swiper.activeIndex);
      });
    } else {
      console.warn('Timeline Slider - Previous button not found');
    }

    if (nextBtn) {
      // Next button - goes forward (to next slide)
      nextBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        console.log('=== NEXT BUTTON CLICKED ===');
        console.log('Event target:', e.target);
        console.log('Event currentTarget:', e.currentTarget);
        console.log('Button element:', nextBtn);
        console.log('Button classes:', nextBtn.className);
        console.log('Is same element?', e.currentTarget === nextBtn);
        console.log('Before slideNext - activeIndex:', swiper.activeIndex);
        swiper.slideNext();
        console.log('After slideNext - activeIndex:', swiper.activeIndex);
      });
    } else {
      console.warn('Timeline Slider - Next button not found');
    }

    // Also check if buttons are actually different elements
    console.log('Button comparison:', {
      areSame: prevBtn === nextBtn,
      prevBtnId: prevBtn ? prevBtn.id || 'no-id' : 'not found',
      nextBtnId: nextBtn ? nextBtn.id || 'no-id' : 'not found',
    });
  }
})();
