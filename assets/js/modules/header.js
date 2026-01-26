// Header scroll effect - because we need to feel something when scrolling
const header = document.querySelector('.elementor-location-header');
const scrollThreshold = 75;
window.addEventListener('scroll', () => {
  if (window.scrollY > scrollThreshold) {
    header.classList.add('scrolled');
  } else {
    header.classList.remove('scrolled');
  }
});
