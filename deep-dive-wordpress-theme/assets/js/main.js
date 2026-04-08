/* ═══════════════════════════════════════════════════
   The Deep Dive — WordPress Theme JS
   deepdive.uemarchitect.org
   ═══════════════════════════════════════════════════ */

(function () {
  'use strict';

  // ── Reading Progress Bar ───────────────────────────────────────────────────
  const progressWrap = document.getElementById('reading-progress');
  const progressBar  = document.getElementById('reading-progress-bar');

  if (progressWrap && progressBar) {
    const article = document.querySelector('.entry-content') || document.querySelector('.post-full-content');

    const updateProgress = () => {
      if (!article) return;
      const articleTop    = article.getBoundingClientRect().top + window.scrollY;
      const articleBottom = articleTop + article.offsetHeight;
      const progress      = Math.min(1, Math.max(0,
        (window.scrollY - articleTop) / (articleBottom - articleTop - window.innerHeight)
      ));

      progressBar.style.transform = `scaleX(${progress})`;
      progressWrap.classList.toggle('is-active', window.scrollY > 100);
    };

    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }


  // ── Sticky Header ─────────────────────────────────────────────────────────
  const header = document.getElementById('site-header');

  if (header) {
    window.addEventListener('scroll', () => {
      header.classList.toggle('site-header--scrolled', window.scrollY > 60);
    }, { passive: true });
  }


  // ── Mobile Nav ────────────────────────────────────────────────────────────
  const burger    = document.getElementById('site-burger');
  const mobileNav = document.getElementById('mobile-nav');

  if (burger && mobileNav) {
    const toggle = (open) => {
      burger.classList.toggle('is-open', open);
      burger.setAttribute('aria-expanded', String(open));
      mobileNav.hidden = !open;
    };

    burger.addEventListener('click', () => {
      toggle(burger.getAttribute('aria-expanded') !== 'true');
    });

    document.addEventListener('click', (e) => {
      if (!header || header.contains(e.target)) return;
      toggle(false);
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') toggle(false);
    });
  }


  // ── Scroll to Top ─────────────────────────────────────────────────────────
  const scrollTopBtn = document.getElementById('scroll-top');

  if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
      scrollTopBtn.classList.toggle('is-visible', window.scrollY > 500);
    }, { passive: true });

    scrollTopBtn.addEventListener('click', () => {
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  }


  // ── Scroll Reveal ─────────────────────────────────────────────────────────
  if ('IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting) {
            entry.target.classList.add('reveal--visible');
            observer.unobserve(entry.target);
          }
        });
      },
      { threshold: 0.08 }
    );
    document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
  } else {
    document.querySelectorAll('.reveal').forEach((el) => {
      el.classList.add('reveal--visible');
    });
  }


  // ── Share Button ──────────────────────────────────────────────────────────
  const shareBtn = document.getElementById('share-btn');

  if (shareBtn) {
    const shareSvg = shareBtn.querySelector('svg');
    const shareLabel = shareBtn.querySelector('span') || shareBtn.lastChild;

    shareBtn.addEventListener('click', async () => {
      const url   = shareBtn.dataset.url   || window.location.href;
      const title = shareBtn.dataset.title || document.title;

      if (navigator.share) {
        try { await navigator.share({ title, url }); } catch (_) { /* cancelled */ }
      } else {
        try {
          await navigator.clipboard.writeText(url);

          // Temporarily show "Copied!" using textContent only
          const originalText = shareSvg ? shareSvg.nextSibling?.textContent?.trim() : shareBtn.textContent.trim();
          if (shareSvg && shareSvg.nextSibling) {
            shareSvg.nextSibling.textContent = ' Copied!';
          } else {
            shareBtn.textContent = 'Copied!';
          }
          shareBtn.disabled = true;

          setTimeout(() => {
            if (shareSvg && shareSvg.nextSibling) {
              shareSvg.nextSibling.textContent = originalText ? ` ${originalText}` : ' Share';
            } else {
              shareBtn.textContent = originalText || 'Share';
            }
            shareBtn.disabled = false;
          }, 2000);
        } catch (_) { /* clipboard unavailable */ }
      }
    });
  }


  // ── Smooth Scroll ─────────────────────────────────────────────────────────
  document.querySelectorAll('a[href^="#"]').forEach((link) => {
    link.addEventListener('click', (e) => {
      const href = link.getAttribute('href');
      if (!href || href === '#') return;
      const target = document.querySelector(href);
      if (!target) return;

      e.preventDefault();
      const offset = (header ? header.offsetHeight : 0) + 16;
      window.scrollTo({
        top: target.getBoundingClientRect().top + window.scrollY - offset,
        behavior: 'smooth',
      });
    });
  });

})();
