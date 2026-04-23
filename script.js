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
            form submissions securely via Web3Forms. We don't use advertising or
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

  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  if (typedEl && prefersReducedMotion) {
    typedEl.textContent = phrases[0];
  } else if (typedEl) {
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

  /* ── Web3Forms Handler ── */
  function handleWeb3Form(form, successMessage) {
    const submitBtn = form.querySelector('button[type="submit"]');
    if (!submitBtn) return;

    form.addEventListener('submit', async (e) => {
      e.preventDefault();

      const formData = new FormData(form);
      const originalText = submitBtn.textContent;

      submitBtn.textContent = 'Sending\u2026';
      submitBtn.disabled = true;

      try {
        if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.enterprise !== 'undefined') {
          const token = await new Promise((resolve) => {
            grecaptcha.enterprise.ready(async () => {
              resolve(await grecaptcha.enterprise.execute('6Le7mMYsAAAAABhCyqbN9SNJiIc_XbNSG09hcNo7', { action: 'contact' }));
            });
          });
          formData.append('g-recaptcha-response', token);
        }

        const response = await fetch('https://api.web3forms.com/submit', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        if (response.ok) {
          alert(successMessage);
          form.reset();
        } else {
          alert('Error: ' + data.message);
        }
      } catch {
        alert('Something went wrong. Please try again.');
      } finally {
        submitBtn.textContent = originalText;
        submitBtn.disabled = false;
      }
    });
  }

  const contactForm = document.getElementById('contact-form');
  if (contactForm) {
    handleWeb3Form(contactForm, 'Success! Your message has been sent.');
  }

  document.querySelectorAll('.footer__newsletter-form, .newsletter-subscribe-form').forEach(form => {
    handleWeb3Form(form, 'Thanks for subscribing!');
  });

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

  /* ── Assessment Quiz ── */
  (function initAssessmentQuiz() {
    const container = document.getElementById('quiz-container');
    if (!container) return;

    // esc() is applied defensively to every dynamic string used in template literals.
    // User form input (name, email, company) never appears in innerHTML —
    // it only goes into FormData for submission.
    function esc(v) {
      return String(v)
        .replace(/&/g, '&amp;')
        .replace(/</g, '&lt;')
        .replace(/>/g, '&gt;')
        .replace(/"/g, '&quot;');
    }

    const QUESTIONS = [
      {
        text: 'How confident are you in your current UEM tenant architecture?',
        answers: [
          'Fully confident \u2014 clean, documented, and deliberate',
          'Mostly confident \u2014 a few rough edges but solid overall',
          'Some inherited complexity I\u2019m still untangling',
          'Not sure what we have or why it\u2019s set up this way'
        ]
      },
      {
        text: 'Are your device enrollment flows documented and consistently enforced?',
        answers: [
          'Yes \u2014 fully documented and enforced across all platforms',
          'Mostly \u2014 some variation by platform, but generally solid',
          'Inconsistent \u2014 different teams do it differently',
          'It\u2019s tribal knowledge \u2014 nobody has written it down'
        ]
      },
      {
        text: 'How is identity integrated with your UEM platform?',
        answers: [
          'Entra ID or Workspace ONE Access with modern authentication',
          'Multiple IdPs in use (Okta, Google, etc.) \u2014 manageable',
          'Legacy Active Directory with some modern overlay',
          'Honestly not sure how it all connects'
        ]
      },
      {
        text: 'Are compliance policies actively enforced across all device types?',
        answers: [
          'Yes \u2014 enforced everywhere with conditional access tied in',
          'Mostly \u2014 some gaps in coverage across platforms',
          'Policies exist but enforcement is inconsistent',
          'Compliance isn\u2019t meaningfully implemented yet'
        ]
      },
      {
        text: 'How would you describe your current profile and policy structure?',
        answers: [
          'Clean and intentional \u2014 minimal overlap, clear ownership',
          'Some duplication, but manageable',
          'Significant overlap \u2014 hard to tell what does what',
          'It needs an archaeological expedition to understand'
        ]
      },
      {
        text: 'Are you using automation and intelligence within your UEM platform?',
        answers: [
          'Yes \u2014 alerts, automated workflows, and dashboards are running',
          'Basic reporting only \u2014 no active automation yet',
          'We have access but haven\u2019t really configured it',
          'We weren\u2019t aware this was a capability'
        ]
      },
      {
        text: 'How quickly can you identify non-compliant devices in your environment?',
        answers: [
          'Instantly \u2014 real-time visibility directly in the console',
          'Within a few minutes with some effort',
          'Requires manual exports and spreadsheet work',
          'We can\u2019t reliably identify them at all'
        ]
      },
      {
        text: 'Does your team have a designated owner for UEM architecture decisions?',
        answers: [
          'Yes \u2014 a dedicated person with clear accountability',
          'Shared ownership across a small team',
          'Informal \u2014 whoever knows the most handles it',
          'No real owner \u2014 it\u2019s whoever has time'
        ]
      },
      {
        text: 'When did you last conduct a formal review of your UEM platform?',
        answers: [
          'Within the last 6\u201312 months',
          '1\u20132 years ago',
          'More than 2 years ago',
          'We have never done a formal review'
        ]
      },
      {
        text: 'Overall, how confident are you in your endpoint management environment?',
        answers: [
          'Very confident \u2014 well-managed and well-understood',
          'Reasonably confident \u2014 some things I\u2019d like to improve',
          'There are gaps I\u2019m actively worried about',
          'We\u2019re surviving, but not in a good place'
        ]
      }
    ];

    const TIERS = {
      strong: {
        label: 'Strong Foundation',
        color: '#0369A1',
        headline: 'Your environment shows strong fundamentals.',
        body: 'You\u2019ve built something deliberate and well-structured. We can help identify the 10\u201320% of optimizations that would take your environment from good to excellent.',
        items: [
          'Targeted optimization opportunities most mature environments overlook',
          'Automation and intelligence workflows that add real operational leverage',
          'Security posture evaluation against current zero-trust benchmarks'
        ]
      },
      grow: {
        label: 'Room to Grow',
        color: '#b45309',
        headline: 'You\u2019ve got a working foundation with notable gaps.',
        body: 'These aren\u2019t catastrophic \u2014 but left unaddressed, they tend to compound. A structured review would give you a clear, prioritized roadmap.',
        items: [
          'Address policy and profile gaps before they create compliance failures',
          'Standardize enrollment flows to reduce support burden and security exposure',
          'Build toward real-time compliance visibility instead of reactive reporting'
        ]
      },
      attention: {
        label: 'Needs Attention',
        color: '#dc2626',
        headline: 'Your environment has meaningful risks worth addressing.',
        body: 'The good news: most of what we see in environments like yours is fixable with the right prioritization. Let\u2019s talk about where to start.',
        items: [
          'Establish clear architecture ownership to stop accumulating technical debt',
          'Implement baseline compliance enforcement before expanding device scope',
          'Get a clear picture of your current state \u2014 you can\u2019t fix what you can\u2019t see'
        ]
      }
    };

    function calcTier(score) {
      if (score >= 33) return TIERS.strong;
      if (score >= 21) return TIERS.grow;
      return TIERS.attention;
    }

    let answers = [];
    let currentQ = 0;

    // SVG donut chart: viewBox 128×128, center 64,64, r=52, strokeWidth=12
    const DONUT_CIRC = parseFloat((2 * Math.PI * 52).toFixed(2)); // ≈ 326.73

    function scrollToCard() {
      const top = container.getBoundingClientRect().top + window.scrollY - 100;
      window.scrollTo({ top: Math.max(0, top), behavior: 'smooth' });
    }

    function renderIntro() {
      container.innerHTML = `
        <div class="quiz-intro quiz-step-enter">
          <div class="quiz-intro__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="40" height="40"><path d="M9 12h3.75M9 15h3.75M9 18h3.75m3 .75H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08m-5.801 0c-.065.21-.1.433-.1.664 0 .414.336.75.75.75h4.5a.75.75 0 0 0 .75-.75 2.25 2.25 0 0 0-.1-.664m-5.8 0A2.251 2.251 0 0 1 13.5 2.25H15c1.012 0 1.867.668 2.15 1.586m-5.8 0c-.376.023-.75.05-1.124.08C9.095 4.01 8.25 4.973 8.25 6.108V8.25m0 0H4.875c-.621 0-1.125.504-1.125 1.125v11.25c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V9.375c0-.621-.504-1.125-1.125-1.125H8.25ZM6.75 12h.008v.008H6.75V12Zm0 3h.008v.008H6.75V15Zm0 3h.008v.008H6.75V18Z"/></svg>
          </div>
          <h2 class="quiz-intro__heading">Is your UEM environment working for you?</h2>
          <p class="quiz-intro__sub">
            This 10-question assessment gives you an honest, scored picture of where your endpoint
            environment stands \u2014 and a personalized recommendation for what to focus on next.
            Takes about 5 minutes.
          </p>
          <ul class="quiz-intro__list" aria-label="What to expect">
            <li><span aria-hidden="true">\u2713</span> 10 questions about your current environment</li>
            <li><span aria-hidden="true">\u2713</span> Scored results with a clear tier and next steps</li>
            <li><span aria-hidden="true">\u2713</span> No obligation \u2014 just clarity</li>
          </ul>
          <button class="btn btn--primary quiz-start-btn" data-action="start">
            Start the Assessment
          </button>
        </div>
      `;
    }

    function renderQuestion(n) {
      const q = QUESTIONS[n - 1];
      const prevPct = ((n - 1) / QUESTIONS.length) * 100;
      const currPct = (n / QUESTIONS.length) * 100;
      const isLast = n === QUESTIONS.length;
      const answersHTML = q.answers.map((text, i) => `
        <button class="quiz-answer" data-value="${4 - i}" type="button" role="radio" aria-checked="false">
          <span class="quiz-answer__radio" aria-hidden="true"></span>
          <span class="quiz-answer__text">${esc(text)}</span>
        </button>
      `).join('');

      container.innerHTML = `
        <div class="quiz-step-wrap quiz-step-enter">
          <div class="quiz-progress-wrap" aria-label="Quiz progress">
            <div class="quiz-progress-row">
              <span class="quiz-progress-label">Question ${esc(n)} of ${esc(QUESTIONS.length)}</span>
              <span class="quiz-progress-pct">${esc(Math.round(prevPct))}% complete</span>
            </div>
            <div class="quiz-progress-track" role="progressbar"
              aria-valuenow="${esc(Math.round(prevPct))}"
              aria-valuemin="0" aria-valuemax="100" aria-label="Quiz progress">
              <div class="quiz-progress-fill" style="width:${esc(prevPct)}%"></div>
            </div>
          </div>
          <h2 class="quiz-question" id="quiz-question-heading" tabindex="-1">${esc(q.text)}</h2>
          <div class="quiz-answers" role="radiogroup" aria-labelledby="quiz-question-heading">
            ${answersHTML}
          </div>
          <div class="quiz-nav">
            <button class="btn btn--primary" data-action="next" disabled
              aria-label="${isLast ? 'Finish and see results' : 'Next question'}">
              ${isLast ? 'See My Results' : 'Next Question'}
            </button>
          </div>
        </div>
      `;

      requestAnimationFrame(() => {
        const fill = container.querySelector('.quiz-progress-fill');
        if (fill) fill.style.width = currPct + '%';
      });

      const heading = container.querySelector('#quiz-question-heading');
      if (heading) setTimeout(() => heading.focus(), 50);
    }

    function renderLead() {
      container.innerHTML = `
        <div class="quiz-lead-wrap quiz-step-enter">
          <div class="quiz-lead__icon" aria-hidden="true">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" width="36" height="36"><path d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75"/></svg>
          </div>
          <h2 class="quiz-lead__heading">Almost there \u2014 where should we send your results?</h2>
          <p class="quiz-lead__sub">
            Enter your details below and we\u2019ll show your personalized score and recommendations
            right here on the page \u2014 plus email you a copy to keep.
          </p>
          <form id="quiz-lead-form" class="quiz-lead__form" novalidate>
            <input type="hidden" name="access_key" value="1db59c16-cd9a-4d51-9058-1d89b49b8189" />
            <input type="hidden" name="subject" value="" />
            <input type="hidden" name="score" value="" />
            <input type="hidden" name="tier" value="" />
            <div class="quiz-lead__fields">
              <div class="contact-form__group">
                <label for="lead-name">Full Name</label>
                <input type="text" id="lead-name" name="name" placeholder="Jane Smith" required autocomplete="name" />
              </div>
              <div class="contact-form__group">
                <label for="lead-email">Work Email</label>
                <input type="email" id="lead-email" name="email" placeholder="jane@company.com" required autocomplete="email" />
              </div>
              <div class="contact-form__group">
                <label for="lead-company">Company</label>
                <input type="text" id="lead-company" name="company" placeholder="Acme Corp" autocomplete="organization" />
              </div>
            </div>
            <p class="quiz-lead__privacy">
              We\u2019ll only use your contact info to send your results and follow up if relevant.
              See our <a href="privacy.html">Privacy Policy</a>.
            </p>
            <button type="button" class="btn btn--primary quiz-submit-btn" data-action="submit-lead">
              Show My Results
            </button>
          </form>
        </div>
      `;

      const nameInput = container.querySelector('#lead-name');
      if (nameInput) setTimeout(() => nameInput.focus(), 50);
    }

    function renderResults(score, tier) {
      const itemsHTML = tier.items.map(item => `<li>${esc(item)}</li>`).join('');

      container.innerHTML = `
        <div class="quiz-results-wrap quiz-step-enter">
          <div class="quiz-results__score-area">
            <div class="quiz-results__score-visual" id="quiz-score-visual"></div>
            <span class="quiz-results__tier-label" style="color:${esc(tier.color)}">${esc(tier.label)}</span>
          </div>
          <h2 class="quiz-results__headline">${esc(tier.headline)}</h2>
          <p class="quiz-results__body">${esc(tier.body)}</p>
          <div class="quiz-results__items-wrap">
            <h3 class="quiz-results__items-heading">What this means for your environment:</h3>
            <ul class="quiz-results__items" aria-label="Recommendations">
              ${itemsHTML}
            </ul>
          </div>
          <div class="quiz-results__ctas">
            <a href="https://zeeg.me/uemarch-pso/lets-meet-and-discuss-your-needs" target="_blank" rel="noopener noreferrer" class="btn btn--primary">
              Book a Free 30-Min Review
            </a>
            <a href="contact.html" class="btn btn--outline-dark">
              Send Us a Message
            </a>
          </div>
          <div id="quiz-results-enhancements"></div>
          <p class="quiz-results__restart">
            Want to try again?
            <button type="button" class="quiz-restart-link" data-action="restart">Retake the assessment</button>
          </p>
        </div>
      `;
      initResultsEnhancements(score, tier);
    }

    // Builds the animated donut chart and appended lead-capture form via DOM methods
    // (avoids innerHTML for new dynamic content — no user input touches the DOM here)
    function initResultsEnhancements(score, tier) {
      const svgNS = 'http://www.w3.org/2000/svg';
      const pct = score / 40;
      const targetOffset = DONUT_CIRC * (1 - pct);

      // ── Donut chart ──
      const scoreVisual = document.getElementById('quiz-score-visual');
      if (scoreVisual) {
        const donutWrap = document.createElement('div');
        donutWrap.className = 'quiz-results__donut-wrap';

        const svg = document.createElementNS(svgNS, 'svg');
        svg.setAttribute('viewBox', '0 0 128 128');
        svg.setAttribute('width', '140');
        svg.setAttribute('height', '140');
        svg.setAttribute('role', 'img');
        svg.setAttribute('aria-label', 'Score: ' + score + ' out of 40');
        svg.classList.add('quiz-results__donut');

        const track = document.createElementNS(svgNS, 'circle');
        track.setAttribute('cx', '64'); track.setAttribute('cy', '64'); track.setAttribute('r', '52');
        track.setAttribute('fill', 'none'); track.setAttribute('stroke', '#e2e8f0'); track.setAttribute('stroke-width', '12');
        svg.appendChild(track);

        const progress = document.createElementNS(svgNS, 'circle');
        progress.setAttribute('cx', '64'); progress.setAttribute('cy', '64'); progress.setAttribute('r', '52');
        progress.setAttribute('fill', 'none'); progress.setAttribute('stroke', tier.color);
        progress.setAttribute('stroke-width', '12'); progress.setAttribute('stroke-linecap', 'round');
        progress.setAttribute('stroke-dasharray', String(DONUT_CIRC));
        progress.setAttribute('stroke-dashoffset', String(DONUT_CIRC));
        progress.setAttribute('transform', 'rotate(-90 64 64)');
        progress.classList.add('quiz-results__donut-progress');
        svg.appendChild(progress);

        const scoreText = document.createElementNS(svgNS, 'text');
        scoreText.setAttribute('x', '64'); scoreText.setAttribute('y', '57');
        scoreText.setAttribute('text-anchor', 'middle'); scoreText.setAttribute('dominant-baseline', 'middle');
        scoreText.setAttribute('font-family', 'Plus Jakarta Sans, sans-serif');
        scoreText.setAttribute('font-size', '22'); scoreText.setAttribute('font-weight', '800');
        scoreText.setAttribute('fill', tier.color);
        scoreText.textContent = String(score);
        svg.appendChild(scoreText);

        const maxText = document.createElementNS(svgNS, 'text');
        maxText.setAttribute('x', '64'); maxText.setAttribute('y', '76');
        maxText.setAttribute('text-anchor', 'middle'); maxText.setAttribute('dominant-baseline', 'middle');
        maxText.setAttribute('font-family', 'Plus Jakarta Sans, sans-serif');
        maxText.setAttribute('font-size', '11'); maxText.setAttribute('font-weight', '600');
        maxText.setAttribute('fill', '#94a3b8');
        maxText.textContent = '/40';
        svg.appendChild(maxText);

        donutWrap.appendChild(svg);
        scoreVisual.appendChild(donutWrap);

        // Animate fill after paint
        requestAnimationFrame(() => {
          requestAnimationFrame(() => {
            progress.style.transition = 'stroke-dashoffset 1.2s cubic-bezier(0.16, 1, 0.3, 1)';
            progress.style.strokeDashoffset = String(targetOffset);
          });
        });
      }

      // ── Lead-capture form (email results) ──
      const enhancementsSlot = document.getElementById('quiz-results-enhancements');
      if (!enhancementsSlot) return;

      const divider = document.createElement('div');
      divider.className = 'quiz-results__lead-divider';
      const dividerSpan = document.createElement('span');
      dividerSpan.textContent = 'Get your personalized report by email';
      divider.appendChild(dividerSpan);

      const leadWrap = document.createElement('div');
      leadWrap.className = 'quiz-results__lead';
      leadWrap.id = 'quiz-results-lead';

      const sub = document.createElement('p');
      sub.className = 'quiz-results__lead-sub';
      sub.textContent = 'Enter your details and we\u2019ll email you a copy of these results with your full recommendations.';
      leadWrap.appendChild(sub);

      const form = document.createElement('form');
      form.id = 'quiz-lead-form';
      form.className = 'quiz-lead__form';
      form.setAttribute('novalidate', '');

      function mkHidden(name, value) {
        const i = document.createElement('input');
        i.type = 'hidden'; i.name = name; i.value = value;
        return i;
      }
      form.appendChild(mkHidden('access_key', '1db59c16-cd9a-4d51-9058-1d89b49b8189'));
      form.appendChild(mkHidden('subject', 'UEM Assessment Results \u2014 ' + tier.label + ' (' + score + '/40)'));
      form.appendChild(mkHidden('score', String(score)));
      form.appendChild(mkHidden('tier', tier.label));

      const fields = document.createElement('div');
      fields.className = 'quiz-lead__fields';

      function mkField(id, labelText, type, name, placeholder, autocomplete, required) {
        const group = document.createElement('div');
        group.className = 'contact-form__group';
        const lbl = document.createElement('label');
        lbl.htmlFor = id; lbl.textContent = labelText;
        const inp = document.createElement('input');
        inp.type = type; inp.id = id; inp.name = name;
        inp.placeholder = placeholder; inp.autocomplete = autocomplete;
        if (required) inp.required = true;
        group.appendChild(lbl); group.appendChild(inp);
        return group;
      }
      fields.appendChild(mkField('lead-name', 'Full Name', 'text', 'name', 'Jane Smith', 'name', true));
      fields.appendChild(mkField('lead-email', 'Work Email', 'email', 'email', 'jane@company.com', 'email', true));
      fields.appendChild(mkField('lead-company', 'Company', 'text', 'company', 'Acme Corp', 'organization', false));
      form.appendChild(fields);

      const privacy = document.createElement('p');
      privacy.className = 'quiz-lead__privacy';
      privacy.textContent = 'We\u2019ll only use your contact info to send your results and follow up if relevant. See our ';
      const privLink = document.createElement('a');
      privLink.href = 'privacy.html'; privLink.textContent = 'Privacy Policy';
      privacy.appendChild(privLink);
      privacy.appendChild(document.createTextNode('.'));
      form.appendChild(privacy);

      const btn = document.createElement('button');
      btn.type = 'button'; btn.className = 'btn btn--primary quiz-submit-btn';
      btn.dataset.action = 'submit-lead'; btn.style.width = '100%';
      btn.textContent = 'Email Me My Results';
      form.appendChild(btn);

      leadWrap.appendChild(form);
      enhancementsSlot.appendChild(divider);
      enhancementsSlot.appendChild(leadWrap);
    }

    function handleClick(e) {
      const target = e.target;
      const actionEl = target.dataset.action ? target : target.closest('[data-action]');
      const action = actionEl ? actionEl.dataset.action : null;

      if (action === 'start') {
        currentQ = 1;
        answers = [];
        renderQuestion(1);
        scrollToCard();
        return;
      }

      if (action === 'next') {
        const selected = container.querySelector('.quiz-answer--selected');
        if (!selected) return;
        answers.push(parseInt(selected.dataset.value, 10));
        if (currentQ < QUESTIONS.length) {
          currentQ++;
          renderQuestion(currentQ);
        } else {
          const total = answers.reduce((sum, v) => sum + v, 0);
          renderResults(total, calcTier(total));
        }
        scrollToCard();
        return;
      }

      if (action === 'submit-lead') {
        submitLead();
        return;
      }

      if (action === 'restart') {
        currentQ = 0;
        answers = [];
        renderIntro();
        scrollToCard();
        return;
      }

      const answerBtn = target.classList.contains('quiz-answer')
        ? target
        : target.closest('.quiz-answer');

      if (answerBtn) {
        container.querySelectorAll('.quiz-answer').forEach(a => {
          a.classList.remove('quiz-answer--selected');
          a.setAttribute('aria-checked', 'false');
        });
        answerBtn.classList.add('quiz-answer--selected');
        answerBtn.setAttribute('aria-checked', 'true');
        const nextBtn = container.querySelector('[data-action="next"]');
        if (nextBtn) nextBtn.disabled = false;
      }
    }

    async function submitLead() {
      const form = document.getElementById('quiz-lead-form');
      if (!form) return;

      const nameInput = form.querySelector('[name="name"]');
      const emailInput = form.querySelector('[name="email"]');

      if (!nameInput.value.trim()) {
        nameInput.focus();
        nameInput.reportValidity();
        return;
      }
      if (!emailInput.value.trim() || !emailInput.checkValidity()) {
        emailInput.focus();
        emailInput.reportValidity();
        return;
      }

      const submitBtn = container.querySelector('.quiz-submit-btn');
      const originalText = submitBtn.textContent;
      submitBtn.textContent = 'Sending\u2026';
      submitBtn.disabled = true;

      const formData = new FormData(form);
      try {
        if (typeof grecaptcha !== 'undefined' && typeof grecaptcha.enterprise !== 'undefined') {
          const token = await new Promise((resolve) => {
            grecaptcha.enterprise.ready(async () => {
              resolve(await grecaptcha.enterprise.execute('6Le7mMYsAAAAABhCyqbN9SNJiIc_XbNSG09hcNo7', { action: 'assessment' }));
            });
          });
          formData.append('g-recaptcha-response', token);
        }
      } catch {
        // proceed without token if reCAPTCHA unavailable
      }

      fetch('https://api.web3forms.com/submit', {
        method: 'POST',
        body: formData
      })
        .then(response => response.json().then(data => ({ ok: response.ok, data })))
        .then(({ ok, data }) => {
          if (ok) {
            const leadSection = document.getElementById('quiz-results-lead');
            if (leadSection) {
              const successDiv = document.createElement('div');
              successDiv.className = 'quiz-lead__success';
              const checkIcon = document.createElement('span');
              checkIcon.setAttribute('aria-hidden', 'true');
              checkIcon.textContent = '\u2713';
              const msg = document.createElement('p');
              msg.textContent = 'Results sent! Check your inbox for your personalized assessment report.';
              successDiv.appendChild(checkIcon);
              successDiv.appendChild(msg);
              leadSection.replaceChildren(successDiv);
            }
          } else {
            alert('Error: ' + data.message);
            submitBtn.textContent = originalText;
            submitBtn.disabled = false;
          }
        })
        .catch(() => {
          alert('Something went wrong. Please try again.');
          submitBtn.textContent = originalText;
          submitBtn.disabled = false;
        });
    }

    container.addEventListener('click', handleClick);
    renderIntro();
  })();

});
