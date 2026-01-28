/**
 * Scroll percentage tracker – clock face style
 * Fixed to bottom-left; a circle fills clockwise as you scroll (12 o’clock → 3 → 6 → 9 → 12).
 * Runs once on DOM ready.
 */
(function () {
  const TRACKER_CLASS = 'ebp-scroll-percentage-tracker';
  const PROGRESS_CLASS = 'ebp-scroll-percentage-progress';
  const R = 16;
  const CIRCUMFERENCE = 2 * Math.PI * R;

  function getScrollPercentage() {
    const html = document.documentElement;
    const body = document.body;
    const scrollHeight = Math.max(
      body.scrollHeight,
      body.offsetHeight,
      html.clientHeight,
      html.scrollHeight,
      html.offsetHeight,
    );
    const viewportHeight = window.innerHeight;
    const maxScroll = scrollHeight - viewportHeight;

    if (maxScroll <= 0) return 100;

    const scrolled = window.scrollY || window.pageYOffset || html.scrollTop;
    return Math.min(100, (scrolled / maxScroll) * 100);
  }

  function createTracker() {
    const wrap = document.createElement('div');
    wrap.className = TRACKER_CLASS;
    wrap.setAttribute('aria-live', 'polite');
    wrap.setAttribute('aria-label', 'Page scroll progress');

    const size = 40;
    const svg = document.createElementNS('http://www.w3.org/2000/svg', 'svg');
    svg.setAttribute('viewBox', `0 0 ${size} ${size}`);
    svg.setAttribute('width', size);
    svg.setAttribute('height', size);
    svg.setAttribute('role', 'img');
    svg.setAttribute('aria-hidden', 'true');

    // Background circle (clock face)
    const bg = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
    bg.setAttribute('cx', size / 2);
    bg.setAttribute('cy', size / 2);
    bg.setAttribute('r', R);
    bg.setAttribute('fill', 'none');
    bg.classList.add('ebp-scroll-percentage-face');

    // Progress circle – stroke draws clockwise from top (12 o’clock)
    const progress = document.createElementNS(
      'http://www.w3.org/2000/svg',
      'circle',
    );
    progress.setAttribute('cx', size / 2);
    progress.setAttribute('cy', size / 2);
    progress.setAttribute('r', R);
    progress.setAttribute('fill', 'none');
    progress.setAttribute('stroke-dasharray', String(CIRCUMFERENCE));
    progress.classList.add(PROGRESS_CLASS);

    svg.appendChild(bg);
    svg.appendChild(progress);
    wrap.appendChild(svg);
    document.body.appendChild(wrap);
    return { wrap, progress };
  }

  function updateTracker(state) {
    if (!state || !state.wrap.isConnected) return;
    const pct = getScrollPercentage();
    const offset = CIRCUMFERENCE * (1 - pct / 100);
    state.progress.setAttribute('stroke-dashoffset', String(offset));
  }

  function init() {
    const state = createTracker();
    let ticking = false;

    function onScroll() {
      if (ticking) return;
      ticking = true;
      requestAnimationFrame(function () {
        updateTracker(state);
        ticking = false;
      });
    }

    window.addEventListener('scroll', onScroll, { passive: true });
    updateTracker(state);
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
