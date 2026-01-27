/**
 * Hero H1 word-split reveal using GSAP SplitText
 * Splits the H1 into words, hides each with clip-path from the bottom,
 * then reveals them with a staggered animation.
 */
(function () {
  'use strict';

  function runHeroReveal() {
    if (typeof gsap === 'undefined') {
      return;
    }

    const hero = document.querySelector('.ebp-custom-hero-1');
    if (!hero) return;

    // Hero image: start at scale 1.5, animate to 1
    const heroImg = hero.querySelector('.ebp-custom-hero-1__image img');
    if (heroImg) {
      gsap.fromTo(
        heroImg,
        { scale: 1.2 },
        {
          scale: 1,
          duration: 1.2,
          ease: 'power3.out',
          delay: 0.4,
        },
      );
    }

    if (typeof SplitText === 'undefined') {
      return;
    }

    const h1 = hero.querySelector('.wrapper-hero h1');
    if (!h1) return;

    if (!h1.textContent.trim()) return;

    // Use SplitText to split the H1 into word elements
    const split = new SplitText(h1, {
      type: 'words',
      wordsClass: 'hero-word',
    });

    const words = split.words;
    console.log('words length:', words.length);
    console.log(words);

    // Hide from bottom: clip the bottom 100% so nothing shows
    gsap.set(words, { display: 'inline-block' });

    gsap.fromTo(
      words,
      { yPercent: 25, opacity: 0 },
      {
        yPercent: 0,
        opacity: 1,
        duration: 0.8,
        ease: 'power3.out',
        delay: 0.7,
        stagger: 0.12, // for 4 words this reads nicely
      },
    );
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', runHeroReveal);
  } else {
    runHeroReveal();
  }
})();
