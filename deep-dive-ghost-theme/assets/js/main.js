'use strict';

document.documentElement.classList.remove('no-js');

// ── Reading Progress Bar ──────────────────────────────────────────────────────
const progressBar = document.getElementById('reading-progress-bar');
const progressWrap = document.getElementById('reading-progress');
const postContent = document.getElementById('post-content');

if (progressBar && postContent) {
  progressWrap.classList.add('is-active');

  const updateProgress = () => {
    const contentRect = postContent.getBoundingClientRect();
    const contentTop = window.scrollY + contentRect.top;
    const contentHeight = postContent.offsetHeight;
    const scrolled = window.scrollY - contentTop;
    const pct = Math.min(Math.max(scrolled / contentHeight, 0), 1);
    progressBar.style.transform = `scaleX(${pct})`;
  };

  window.addEventListener('scroll', updateProgress, { passive: true });
  updateProgress();
}

// ── Mobile Navigation ─────────────────────────────────────────────────────────
const burger = document.getElementById('burger');
const mobileNav = document.getElementById('mobile-nav');

if (burger && mobileNav) {
  burger.addEventListener('click', () => {
    const isOpen = burger.getAttribute('aria-expanded') === 'true';
    burger.setAttribute('aria-expanded', String(!isOpen));
    burger.classList.toggle('is-open', !isOpen);
    mobileNav.classList.toggle('is-open', !isOpen);
    mobileNav.setAttribute('aria-hidden', String(isOpen));
  });

  document.addEventListener('click', (e) => {
    if (!burger.contains(e.target) && !mobileNav.contains(e.target)) {
      burger.setAttribute('aria-expanded', 'false');
      burger.classList.remove('is-open');
      mobileNav.classList.remove('is-open');
      mobileNav.setAttribute('aria-hidden', 'true');
    }
  });

  mobileNav.querySelectorAll('a').forEach(link => {
    link.addEventListener('click', () => {
      burger.setAttribute('aria-expanded', 'false');
      burger.classList.remove('is-open');
      mobileNav.classList.remove('is-open');
      mobileNav.setAttribute('aria-hidden', 'true');
    });
  });
}

// ── Sticky Header ─────────────────────────────────────────────────────────────
const header = document.querySelector('.site-header');
if (header) {
  const onScroll = () => {
    header.classList.toggle('site-header--scrolled', window.scrollY > 60);
  };
  window.addEventListener('scroll', onScroll, { passive: true });
  onScroll();
}

// ── Scroll-to-Top ─────────────────────────────────────────────────────────────
const scrollTopBtn = document.getElementById('scroll-top');
if (scrollTopBtn) {
  window.addEventListener('scroll', () => {
    scrollTopBtn.classList.toggle('is-visible', window.scrollY > 500);
  }, { passive: true });

  scrollTopBtn.addEventListener('click', () => {
    window.scrollTo({ top: 0, behavior: 'smooth' });
  });
}

// ── Scroll Reveal ─────────────────────────────────────────────────────────────
if ('IntersectionObserver' in window) {
  const revealObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('reveal--visible');
        revealObserver.unobserve(entry.target);
      }
    });
  }, { threshold: 0.1, rootMargin: '0px 0px -40px 0px' });

  document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));
}

// ── Share Button ──────────────────────────────────────────────────────────────
const shareBtn = document.getElementById('share-btn');
if (shareBtn) {
  const shareBtnText = shareBtn.querySelector('span') || shareBtn.lastChild;
  const originalChildren = Array.from(shareBtn.childNodes).map(n => n.cloneNode(true));

  shareBtn.addEventListener('click', async () => {
    const title = document.title;
    const url = window.location.href;

    if (navigator.share) {
      try {
        await navigator.share({ title, url });
      } catch (_) { /* user cancelled */ }
    } else {
      try {
        await navigator.clipboard.writeText(url);
        // Use textContent to safely update button label — no HTML involved
        shareBtn.textContent = 'Copied!';
        shareBtn.disabled = true;
        setTimeout(() => {
          shareBtn.replaceChildren(...originalChildren.map(n => n.cloneNode(true)));
          shareBtn.disabled = false;
        }, 2000);
      } catch (_) { /* clipboard denied */ }
    }
  });
}

// ── Ghost Members: Subscribe form feedback ────────────────────────────────────
document.querySelectorAll('[data-members-form]').forEach(form => {
  form.addEventListener('submit', () => {
    const btn = form.querySelector('button[type="submit"]');
    if (btn) {
      btn.disabled = true;
      btn.textContent = 'Subscribing\u2026';
    }
  });
});

// ── Smooth Scroll for in-page links ──────────────────────────────────────────
document.querySelectorAll('a[href^="#"]').forEach(link => {
  const target = link.getAttribute('href');
  if (target === '#') return;

  link.addEventListener('click', (e) => {
    const el = document.querySelector(target);
    if (!el) return;
    e.preventDefault();
    const headerHeight = header ? header.offsetHeight : 0;
    const top = el.getBoundingClientRect().top + window.scrollY - headerHeight - 16;
    window.scrollTo({ top, behavior: 'smooth' });
    el.focus({ preventScroll: true });
  });
});
