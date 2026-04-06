# UEM Architect Website

Official website for **UEM Architect Consulting** — an Omnissa Silver Partner & Solution Reseller helping organizations architect, implement, and operate secure, scalable UEM environments tailored to how their teams actually work.

---

## 🌐 Live Site

> Update this link once deployed.

[https://your-domain.com](https://your-domain.com)

---

## 📋 Overview

Fully static multi-page marketing site built with vanilla HTML, CSS, and JavaScript — no frameworks, no build tools, no dependencies. Open any `.html` file directly in a browser.

---

## 📁 Project Structure

```
UEM-Architect-Website/
├── index.html           # Home — hero, stats strip, partners, Omnissa section, CTA banner
├── who-we-serve.html    # Personas, industries, and FAQ
├── services.html        # All 6 services with deliverables + engagement formats
├── our-process.html     # 4-phase process with timelines and differentiators
├── why-us.html          # Differentiators + client testimonials carousel
├── contact.html         # Contact form, booking link, and contact info
├── blog.html            # Coming soon placeholder with subscribe form
├── privacy.html         # GDPR-compliant Privacy & Cookie Policy
├── index.css            # All styles — design tokens, components, responsive
├── script.js            # All interactivity — nav, carousel, cookie banner, etc.
├── Images/              # Brand assets, logos, partner badges, and service images
├── git-push.sh          # Helper script for pushing to GitHub from local Terminal
└── README.md
```

---

## 🗂️ Pages

| Page | File | Description |
|---|---|---|
| Home | `index.html` | Hero, stats strip, partners marquee, Omnissa partner section, CTA banner |
| Who We Serve | `who-we-serve.html` | IT Leader / HR & Ops / MSP personas, industries served, FAQ |
| Services | `services.html` | 6 service offerings with deliverables, engagement models, platforms |
| Our Process | `our-process.html` | Discover → Architect → Implement → Maintain; timeline + differentiators |
| Why Us | `why-us.html` | Differentiator cards + client testimonial carousel |
| Contact | `contact.html` | Formspree contact form, booking link, office info |
| Blog | `blog.html` | Coming soon — subscribe form and topic preview cards |
| Privacy Policy | `privacy.html` | Full GDPR-compliant Privacy & Cookie Policy |

---

## 🛠️ Technologies

- **HTML5** — Semantic markup with ARIA landmarks and accessibility attributes
- **CSS3** — Vanilla CSS with design tokens (`:root` custom properties), responsive layout, `prefers-reduced-motion` support
- **JavaScript (ES6)** — Vanilla JS with `IntersectionObserver`, typing effect, testimonial carousel, GDPR cookie banner, smooth scroll

---

## ⚙️ JavaScript Modules

All logic lives inside a single `DOMContentLoaded` listener in `script.js`, plus a top-level IIFE for the cookie banner:

| Module | Description |
|---|---|
| Cookie banner | IIFE — injects GDPR consent banner on first visit; stores choice in `localStorage` under `uema_cookie_consent` |
| Sticky header | Toggles `header--scrolled` class at 60 px scroll |
| Mobile burger menu | Toggles `open` / `active` on `#nav` / `#burger`; closes on outside click |
| Typing effect | Rotates 4 phrases with human-like timing on `#typed-text`; skips animation when `prefers-reduced-motion` is set |
| Scroll reveal | `IntersectionObserver` on `.reveal` elements; stagger via `.reveal--delay-1` through `.reveal--delay-6` |
| Testimonial carousel | `#testimonials-track`, dot nav, 5 s autoplay, pauses on hidden tab |
| Smooth scroll | Accounts for sticky header height; skips bare `#` hrefs |
| Scroll-to-top | `#scroll-top` visible at 500 px scroll |
| Footer year | `#footer-year` auto-set to current year |

---

## 🎨 Design Tokens

All tokens are defined in `:root` at the top of `index.css`.

| Token | Value | Usage |
|---|---|---|
| `--navy` | `#2b4570` | Primary brand navy — small-text links, active nav states |
| `--blue` | `#0369A1` | Primary accent — buttons, borders, icon highlights |
| `--light-blue` | `#38BDF8` | Lighter accent |
| `--sky` | `#BAE6FD` | Lightest accent — hero badge text |
| `--amber` | `#f59e0b` | Highlight / CTA amber |
| `--dark` | `#0d1117` | Hero and CTA dark backgrounds |
| `--off-white` | `#f0f4f8` | Section light backgrounds |
| `--text` | `#1e293b` | Body text |
| `--text-light` | `#64748b` | Secondary text |
| `--grad-accent` | `135deg, #0369A1 → #38BDF8` | Primary buttons |
| `--grad-hero` | dark navy gradient | Hero section |
| `--shadow-glow` | `rgba(3, 105, 161, 0.2)` | Hover glow states |

Font: **Plus Jakarta Sans** (Google Fonts, weights 300–800 + italic)

---

## 🚀 Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/NoChillModeOnline/UEM-Architect-Website.git
   ```

2. Open any `.html` file in your browser — no build step required.

---

## ⚙️ Pre-Deployment Checklist

Before going live, update the following placeholders:

| File | Placeholder | Replace With |
|---|---|---|
| All HTML files | `https://your-domain.com/` | Your live domain |
| All HTML files | `og:image` meta tag | Full URL to your OG image (1200×630 px) |
| `contact.html` | `YOUR_FORM_ID` | Your Formspree contact form ID |
| All HTML files | `YOUR_NEWSLETTER_ID` | Your Formspree newsletter form ID |

---

## 🍪 GDPR / Cookie Compliance

The site includes a GDPR cookie consent banner (injected via `script.js`) and a full Privacy & Cookie Policy at `privacy.html`. The only cookies currently in use are:

- `uema_cookie_consent` — localStorage key storing the user's consent choice
- Formspree CSRF cookies — set by the form submission handler

No advertising, analytics, or third-party tracking cookies are used.

---

## 📬 Contact

- **Email:** contact@uemarchitect.org
- **Schedule a Meeting:** https://zeeg.me/uemarch-pso
- **LinkedIn:** https://www.linkedin.com/company/uem-architect-consulting
- **Location:** Odessa, FL — Serving Clients Globally

---

## 📄 License

See the [LICENSE](LICENSE) file for details.
