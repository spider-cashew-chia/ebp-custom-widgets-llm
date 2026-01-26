/**
 * Accordion functionality
 * Handles opening and closing accordion items when buttons are clicked
 */

(function() {
    'use strict';

    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        // Find all accordion containers on the page
        const accordions = document.querySelectorAll('.ebp-custom-accordion-1');

        // Loop through each accordion container
        accordions.forEach(function(accordion) {
            // Find all accordion item buttons within this accordion
            const accordionButtons = accordion.querySelectorAll('.ebp-custom-accordion-1__item-title');

            // Add click event listener to each button
            accordionButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    // Get the parent accordion item
                    const accordionItem = this.closest('.ebp-custom-accordion-1__item');
                    
                    // Get the content div for this accordion item
                    const content = accordionItem.querySelector('.ebp-custom-accordion-1__item-content');

                    // Check if this accordion item is currently open
                    const isOpen = accordionItem.classList.contains('is-open');

                    // Close all accordion items in this accordion
                    const allItems = accordion.querySelectorAll('.ebp-custom-accordion-1__item');
                    allItems.forEach(function(item) {
                        item.classList.remove('is-open');
                        const itemButton = item.querySelector('.ebp-custom-accordion-1__item-title');
                        const itemContent = item.querySelector('.ebp-custom-accordion-1__item-content');
                        if (itemButton) {
                            itemButton.setAttribute('aria-expanded', 'false');
                        }
                    });

                    // If the clicked item wasn't open, open it now
                    if (!isOpen) {
                        accordionItem.classList.add('is-open');
                        button.setAttribute('aria-expanded', 'true');
                    }
                });
            });
        });
    });
})();
