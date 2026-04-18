# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Multi-page static marketing website for UEM Architect Consulting — a Unified Endpoint Management consulting firm. No build tools, no dependencies, no package manager. Open any `.html` file directly in a browser.

## File Structure

| File | Purpose |
|------|---------|
| `index.html` | Home page — hero, services overview, partners, Omnissa partner section, CTA |
| `who-we-serve.html` | Persona/audience page — IT leaders, HR & ops teams, MSPs, industries, FAQ |
| `services.html` | Services detail page — 6 service areas + engagement formats + platforms |
| `our-process.html` | Engagement process page |
| `why-us.html` | Differentiators + testimonials |
| `contact.html` | Contact form page |
| `deep-dive.html` | "The Deep Dive" blog/resources — coming soon page (`noindex, nofollow`) |
| `privacy.html` | Privacy & Cookie Policy |
| `index.css` | Shared vanilla CSS with design tokens, organized by component |
| `script.js` | Shared vanilla JS, all logic inside one `DOMContentLoaded` listener |
| `Images/` | All brand assets, logos, service icons, and partner logos |
| `og-image.jpg` | 1200×630 Open Graph social share image |
| `robots.txt` | Crawl directives — allows all except `deep-dive.html`; references sitemap |
| `sitemap.xml` | XML sitemap with 6 indexable pages; submit to Google Search Console |

## Architecture

**Multi-page site** — each page is a standalone HTML file sharing `index.css` and `script.js`.

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
- Form handling — `handleWeb3Form()` targets `#contact-form`, `.footer__newsletter-form`, `.newsletter-subscribe-form`; posts to Web3Forms API asynchronously
- All `scroll` listeners use `{ passive: true }`

## Forms

All forms use **Web3Forms** (`https://api.web3forms.com/submit`) with access key `1747abac-6f54-40d0-bee6-9b7cd75b7fe5`. The key is embedded as a hidden `access_key` input on each form.

## SEO

Every page includes: `<title>`, `<meta name="description">`, canonical, Open Graph (`og:site_name`, `og:title`, `og:description`, `og:type`, `og:url`, `og:image`, `og:image:width/height`), and Twitter Card (`twitter:card`, `twitter:title`, `twitter:description`, `twitter:image`).

**JSON-LD structured data:**
- `index.html` — `Organization` + `ProfessionalService` schema
- `services.html` — `ItemList` schema (6 service offerings)
- `who-we-serve.html` — `FAQPage` schema (4 Q&As, eligible for SERP FAQ accordions)

**When adding a new page:**
1. Add full OG + Twitter Card block (copy pattern from any existing page)
2. Add `og:site_name` and `og:image:width/height`
3. Add self-referencing canonical
4. Add appropriate JSON-LD if the page has FAQ, service list, or article content
5. Add the URL to `sitemap.xml`
6. If it's a coming-soon or utility page, add `<meta name="robots" content="noindex, nofollow" />` and add to `robots.txt` Disallow

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
- **Font**: Plus Jakarta Sans (Google Fonts) — weights 300–800

**Button variants**: `.btn--primary` (blue `--grad-accent` gradient) and `.btn--outline` (ghost, white border — used on dark backgrounds only).

`index.css` is organized by component in order: reset/base → layout utilities → buttons → header → hero → sections → personas → services → process → why → partners → CTA banner → testimonials → contact → footer → scroll-to-top → reveal animations → media queries.

## Known Issues

None. All previously noted issues are resolved:
- Images are in `Images/` (capital I) and all HTML references match
- Forms migrated from Formspree to Web3Forms
- OG/canonical URLs use `https://www.uemarchitect.org/`
- `og-image.jpg` (1200×630) exists at the repo root

## Contact / Social

- Email: contact@uemarchitect.org
- LinkedIn: linkedin.com/company/uem-architect-consulting
- Booking: zeeg.me/uemarch-pso
- Location: Odessa, FL (confirm if this has changed)
