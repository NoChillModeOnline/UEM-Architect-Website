/* ═══════════════════════════════════════════════════
   UEM Architect — Interactivity & Animations
   ═══════════════════════════════════════════════════ */

/* ── Cookie Consent Banner (GDPR) ── */
(function () {
  const CONSENT_KEY = 'uema_cookie_consent';

  function buildBanner() {
    if (localStorage.getItem(CONSENT_KEY)) return;

    const banner = document.createElement('div');
    banner.id = 'cookie-banner';
    banner.className = 'cookie-banner';
    banner.setAttribute('role', 'dialog');
    banner.setAttribute('aria-modal', 'false');
    banner.setAttribute('aria-label', 'Cookie consent');
    banner.innerHTML = `
      <div class="cookie-banner__inner">
        <div class="cookie-banner__text">
          <p class="cookie-banner__title">🍪 We Use Cookies</p>
          <p class="cookie-banner__desc">
            We use essential cookies to keep this site running and to process contact
            form submissions securely via Formspree. We don't use advertising or
            tracking cookies. You can accept all cookies or continue with essential
            cookies only. <a href="privacy.html">Privacy &amp; Cookie Policy</a>
          </p>
        </div>
        <div class="cookie-banner__actions">
          <button id="cookie-btn-accept" class="btn btn--primary cookie-banner__btn">Accept All</button>
          <button id="cookie-btn-essential" class="cookie-banner__btn cookie-banner__btn--secondary">Essential Only</button>
        </div>
      </div>
    `;

    document.body.appendChild(banner);

    // Slide in after paint
    requestAnimationFrame(() =>
      requestAnimationFrame(() => banner.classList.add('cookie-banner--visible'))
    );

    function dismiss(choice) {
      localStorage.setItem(CONSENT_KEY, choice);
      banner.classList.remove('cookie-banner--visible');
      banner.addEventListener('transitionend', () => banner.remove(), { once: true });
    }

    banner.querySelector('#cookie-btn-accept').addEventListener('click', () => dismiss('all'));
    banner.querySelector('#cookie-btn-essential').addEventListener('click', () => dismiss('essential'));
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', buildBanner);
  } else {
    buildBanner();
  }
}());

document.addEventListener('DOMContentLoaded', () => {

  /* ── Sticky Header ── */
  const header = document.getElementById('header');
  const scrollThreshold = 60;

  function updateHeader() {
    if (!header) return;
    header.classList.toggle('header--scrolled', window.scrollY > scrollThreshold);
  }

  window.addEventListener('scroll', updateHeader, { passive: true });
  updateHeader();

  /* ── Mobile Menu Toggle ── */
  const burger = document.getElementById('burger');
  const nav = document.getElementById('nav');

  if (burger && nav) {
    burger.addEventListener('click', () => {
      const isOpen = burger.classList.toggle('active');
      nav.classList.toggle('open', isOpen);
      burger.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
    });

    nav.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        burger.classList.remove('active');
        nav.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
      });
    });

    document.addEventListener('click', (e) => {
      if (nav.classList.contains('open') &&
          !nav.contains(e.target) &&
          !burger.contains(e.target)) {
        burger.classList.remove('active');
        nav.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
      }
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && nav.classList.contains('open')) {
        burger.classList.remove('active');
        nav.classList.remove('open');
        burger.setAttribute('aria-expanded', 'false');
        burger.focus();
      }
    });
  }

  /* ── Typing Effect ── */
  const phrases = [
    'Architect Your Endpoint Strategy.',
    'Secure Every Device, Everywhere.',
    'Align Technology with Your Team.',
    'Built for How You Work.',
  ];

  const typedEl = document.getElementById('typed-text');

  if (typedEl) {
    let phraseIndex = 0;
    let charIndex = 0;
    let isDeleting = false;
    let typeSpeed = 60;

    function typeLoop() {
      const current = phrases[phraseIndex];

      if (!isDeleting) {
        typedEl.textContent = current.substring(0, charIndex + 1);
        charIndex++;

        if (charIndex === current.length) {
          isDeleting = true;
          typeSpeed = 2000;
        } else {
          typeSpeed = 55 + Math.random() * 40;
        }
      } else {
        typedEl.textContent = current.substring(0, charIndex - 1);
        charIndex--;

        if (charIndex === 0) {
          isDeleting = false;
          phraseIndex = (phraseIndex + 1) % phrases.length;
          typeSpeed = 400;
        } else {
          typeSpeed = 30;
        }
      }

      setTimeout(typeLoop, typeSpeed);
    }

    typeLoop();
  }

  /* ── Scroll Reveal (IntersectionObserver) ── */
  const revealEls = document.querySelectorAll('.reveal');

  if ('IntersectionObserver' in window) {
    const revealObserver = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.classList.add('reveal--visible');
            revealObserver.unobserve(entry.target);
          }
        });
      },
      {
        threshold: 0.15,
        rootMargin: '0px 0px -40px 0px',
      }
    );

    revealEls.forEach(el => revealObserver.observe(el));
  } else {
    revealEls.forEach(el => el.classList.add('reveal--visible'));
  }

  /* ── Testimonial Carousel ── */
  const track = document.getElementById('testimonials-track');
  const dots = document.querySelectorAll('#testimonials-dots button');

  if (track && dots.length > 0) {
    let currentSlide = 0;
    const totalSlides = dots.length;
    let autoplayTimer;

    function goToSlide(index) {
      currentSlide = index;
      track.style.transform = `translateX(-${currentSlide * 100}%)`;
      dots.forEach((dot, i) => {
        dot.classList.toggle('active', i === currentSlide);
        dot.setAttribute('aria-label', `Go to testimonial ${i + 1}${i === currentSlide ? ' (current)' : ''}`);
      });
    }

    function nextSlide() {
      goToSlide((currentSlide + 1) % totalSlides);
    }

    function resetAutoplay() {
      clearInterval(autoplayTimer);
      autoplayTimer = setInterval(nextSlide, 5000);
    }

    dots.forEach(dot => {
      dot.addEventListener('click', () => {
        const idx = parseInt(dot.dataset.index, 10);
        if (!Number.isNaN(idx)) {
          goToSlide(idx);
          resetAutoplay();
        }
      });
    });

    goToSlide(0);
    resetAutoplay();

    document.addEventListener('visibilitychange', () => {
      if (document.hidden) {
        clearInterval(autoplayTimer);
      } else {
        resetAutoplay();
      }
    });
  }

  /* ── Smooth Scroll for Anchor Links ── */
  document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', e => {
      const href = anchor.getAttribute('href');
      if (!href || href === '#') return;

      const target = document.querySelector(href);
      if (target) {
        e.preventDefault();
        const headerHeight = header ? header.offsetHeight : 0;
        const targetPos =
          target.getBoundingClientRect().top +
          window.scrollY -
          headerHeight -
          20;

        window.scrollTo({ top: targetPos, behavior: 'smooth' });
      }
    });
  });

  /* ── Scroll to Top ── */
  const scrollTop = document.getElementById('scroll-top');

  if (scrollTop) {
    window.addEventListener(
      'scroll',
      () => {
        if (window.scrollY > 500) {
          scrollTop.classList.add('visible');
        } else {
          scrollTop.classList.remove('visible');
        }
      },
      { passive: true }
    );

    scrollTop.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }

  /* ── Auto-update Footer Year ── */
  const footerYear = document.getElementById('footer-year');
  if (footerYear) {
    footerYear.textContent = new Date().getFullYear();
  }

  /* ── Stat Counter Count-Up ── */
  const statNumbers = document.querySelectorAll('.stat-number[data-target]');

  if (statNumbers.length > 0 && 'IntersectionObserver' in window) {
    const countObserver = new IntersectionObserver(
      entries => {
        entries.forEach(entry => {
          if (!entry.isIntersecting) return;
          const el = entry.target;
          const target = parseInt(el.dataset.target, 10);
          const duration = 1600;
          const start = performance.now();

          function tick(now) {
            const elapsed = now - start;
            const progress = Math.min(elapsed / duration, 1);
            // Ease out cubic
            const eased = 1 - Math.pow(1 - progress, 3);
            el.textContent = Math.round(eased * target);
            if (progress < 1) {
              requestAnimationFrame(tick);
            } else {
              el.textContent = target;
            }
          }

          requestAnimationFrame(tick);
          countObserver.unobserve(el);
        });
      },
      { threshold: 0.5 }
    );

    statNumbers.forEach(el => countObserver.observe(el));
  }

});
