# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Static single-page marketing website for UEM Architect Consulting — a Unified Endpoint Management consulting firm. No build tools, no dependencies, no package manager. Open `index.html` directly in a browser.

## File Structure

| File | Purpose |
|------|---------|
| `index.html` | Single-page layout — all sections and content |
| `index.css` | Vanilla CSS with design tokens, organized by component |
| `script.js` | Vanilla JS, all logic inside one `DOMContentLoaded` listener |
| `Image Materials for Website/` | Source brand assets and logos |
| `images/` | ⚠️ Referenced by HTML but **not yet created** — see Known Issues |

## Architecture

**Single-page layout** with these sections (in order):
`header` → `hero` → `#who-we-serve` → `#services` → `#process` → `#why-us` → `.partners` → `.cta-banner` → `#testimonials` → `#contact` → `footer`

The hero section has no `id`. Nav links target the above section IDs. The entire body is wrapped in `<main id="main-content">`.

**CSS design tokens** are defined in `:root` at the top of `index.css` — use these rather than raw values.

**JS modules** (all in `script.js` under `DOMContentLoaded`):
- Sticky header — toggles `header--scrolled` class at 60px scroll
- Mobile burger menu — toggles `open` / `active` on `#nav` / `#burger`; also closes on outside click; sets `aria-expanded`
- Typing effect — rotates 4 phrases with human-like timing on `#typed-text`
- Scroll reveal — `IntersectionObserver` on `.reveal` elements, adds `.reveal--visible`; stagger via `.reveal--delay-1` through `.reveal--delay-6`; gracefully falls back if API unavailable
- Testimonial carousel — `#testimonials-track`, dot nav via `#testimonials-dots button[data-index]`, 5s autoplay; pauses on `visibilitychange` (hidden tab)
- Smooth scroll — accounts for sticky header height; skips bare `#` hrefs
- Scroll-to-top — `#scroll-top` visible at 500px scroll, passive listener
- Footer year — `#footer-year` auto-set to `new Date().getFullYear()`
- All `scroll` listeners use `{ passive: true }`

## Brand / Design Conventions

**Full `:root` token reference:**
- **Brand palette**: `--navy` (#2b4570), `--blue` (#00b4d8), `--light-blue` (#48cae4), `--sky` (#90e0ef), `--amber` (#f59e0b), `--amber-light` (#fbbf24), `--grey` (#94a3b8)
- **Dark background**: `--dark` (#0d1117) — used for hero and CTA sections
- **Light backgrounds**: `--off-white` (#f0f4f8), `--light-grey` (#e2e8f0)
- **Text**: `--text` (#1e293b), `--text-light` (#64748b)
- **Gradients**: `--grad-hero`, `--grad-cta`, `--grad-accent` (blue), `--grad-amber`
- **Shadows**: `--shadow-sm/md/lg`, `--shadow-glow` (blue glow)
- **Radius**: `--radius-sm` (8px) / `--radius-md` (12px) / `--radius-lg` (20px) / `--radius-xl` (28px)
- **Transitions**: `--t-base` (0.3s), `--ease`
- **Font**: Inter (Google Fonts) — weights 300–800

**Button variants**: `.btn--primary` (blue `--grad-accent` gradient) and `.btn--outline` (ghost, white border — used on dark backgrounds only).

`index.css` is organized by component in order: reset/base → layout utilities → buttons → header → hero → sections → personas → services → process → why → partners → CTA banner → testimonials → contact → footer → scroll-to-top → reveal animations → media queries.

## Known Issues

1. **`images/` directory missing** — All image `src` attributes in `index.html` reference `images/xxx` (e.g. `images/logo.png`, `images/service-assessment.png`, `images/partner-omnissa.png`). This directory does not exist; source files are in `Image Materials for Website/`. Images must be renamed/optimized and placed into `images/` before the site renders correctly.

2. **Formspree placeholders** — Both forms use literal placeholder IDs:
   - Contact form: `action="https://formspree.io/f/YOUR_FORM_ID"`
   - Newsletter form: `action="https://formspree.io/f/YOUR_NEWSLETTER_ID"`

3. **OG / canonical placeholders** — `<meta property="og:url">`, `<meta property="og:image">`, and `<link rel="canonical">` all use `https://your-domain.com/` and need the real production domain.

## Contact / Social

- Email: contact@uemarchitect.org
- LinkedIn: linkedin.com/company/uem-architect
- Booking: zeeg.me/uemarch-pso
- Location: Charlotte, NC
