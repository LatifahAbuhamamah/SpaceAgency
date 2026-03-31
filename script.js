/* =============================================
   script.js
   ============================================= */

/* ----- Mobile Menu Toggle ----- */
const hamburger = document.getElementById('hamburger');
const mobileMenu = document.getElementById('mobile-menu');

if (hamburger && mobileMenu) {
  hamburger.addEventListener('click', function () {
    mobileMenu.classList.toggle('open');
  });
}

/* ----- Scroll Reveal Animation ----- */
// Elements with class "reveal" fade in when scrolled into view
const revealItems = document.querySelectorAll('.reveal');

if (revealItems.length > 0) {
  const observer = new IntersectionObserver(
    function (entries) {
      entries.forEach(function (entry) {
        if (entry.isIntersecting) {
          entry.target.style.opacity = '1';
          entry.target.style.transform = 'translateY(0)';
          observer.unobserve(entry.target);
        }
      });
    },
    { threshold: 0.1 },
  );

  revealItems.forEach(function (el) {
    // Start hidden
    el.style.opacity = '0';
    el.style.transform = 'translateY(20px)';
    el.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
    observer.observe(el);
  });
}
