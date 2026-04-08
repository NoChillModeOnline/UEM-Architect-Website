# UEM Architect Website

Source code for **UEM Architect Consulting** — an Omnissa Silver Partner & Solution Reseller helping organizations architect, implement, and operate secure, scalable UEM environments.

This repository contains two projects:

| Project | Directory | Purpose |
|---|---|---|
| Marketing Site | `/` (root) | Static HTML/CSS/JS marketing website at uemarchitect.org |
| The Deep Dive — WordPress Theme | `deep-dive-wordpress-theme/` | WordPress theme for deepdive.uemarchitect.org |

---

## 🌐 Live Sites

- **Main site:** [uemarchitect.org](https://www.uemarchitect.org)
- **The Deep Dive:** [deepdive.uemarchitect.org](https://deepdive.uemarchitect.org)

---

## 📁 Repository Structure

```
UEM-Architect-Website/
│
├── index.html                  # Home page
├── who-we-serve.html           # Personas & industries
├── services.html               # Service offerings
├── our-process.html            # 4-phase engagement process
├── why-us.html                 # Differentiators & testimonials
├── contact.html                # Contact form & booking
├── privacy.html                # GDPR Privacy & Cookie Policy
├── index.css                   # All styles — design tokens, components
├── script.js                   # All interactivity
│
└── deep-dive-wordpress-theme/  # WordPress theme for The Deep Dive
    ├── style.css               # WordPress theme header
    ├── functions.php           # Theme setup, enqueue, helpers, meta box
    ├── header.php              # Navigation + mobile drawer
    ├── footer.php              # Footer + newsletter form
    ├── home.php                # Blog index — featured hero + post grid
    ├── single.php              # Single post — reading progress, share, related posts
    ├── page.php                # Static page
    ├── archive.php             # Category/tag/date archives
    ├── author.php              # Author archive
    ├── search.php              # Search results
    ├── comments.php            # Comment list + form
    ├── index.php               # WordPress fallback template
    ├── template-parts/
    │   └── post-card.php       # Reusable post card (16:9, tag, reading time)
    └── assets/
        ├── css/screen.css      # Full stylesheet (design tokens + Gutenberg blocks)
        ├── js/main.js          # Reading progress, share, reveal animations
        └── images/favicon.svg  # SVG favicon
```

---

## 1 — Marketing Site

Fully static multi-page site. No build tools, no dependencies — open any `.html` file directly in a browser.

### Pages

| Page | File | Description |
|---|---|---|
| Home | `index.html` | Hero, stats, partners marquee, Omnissa partner section, CTA |
| Who We Serve | `who-we-serve.html` | IT Leader / HR & Ops / MSP personas, industries, FAQ |
| Services | `services.html` | 6 service offerings with deliverables and engagement models |
| Our Process | `our-process.html` | Discover → Architect → Implement → Maintain |
| Why Us | `why-us.html` | Differentiator cards + testimonial carousel |
| Contact | `contact.html` | Formspree contact form, booking link, office info |
| Privacy Policy | `privacy.html` | GDPR-compliant Privacy & Cookie Policy |

### Technologies

- **HTML5** — semantic markup with ARIA landmarks
- **CSS3** — vanilla CSS with design tokens, responsive layout, `prefers-reduced-motion`
- **JavaScript (ES6)** — `IntersectionObserver`, typing effect, carousel, GDPR cookie banner

### Design Tokens

| Token | Value | Usage |
|---|---|---|
| `--navy` | `#2b4570` | Primary brand navy |
| `--blue` | `#0369A1` | Primary accent |
| `--light-blue` | `#38BDF8` | Lighter accent |
| `--amber` | `#f59e0b` | Highlight / CTA |
| `--dark` | `#0d1117` | Hero dark backgrounds |

Font: **Plus Jakarta Sans** (Google Fonts, weights 300–800)

### Pre-Deployment Checklist

| File | Placeholder | Replace With |
|---|---|---|
| All HTML | `og:image` meta tag | Full URL to OG image (1200×630 px) |
| `contact.html` | `YOUR_FORM_ID` | Formspree contact form ID |
| All HTML | `YOUR_NEWSLETTER_ID` | Formspree newsletter form ID |

---

## 2 — The Deep Dive WordPress Theme

Dark editorial WordPress theme for `deepdive.uemarchitect.org`. Built with the same design language as the marketing site.

**Design:** `DM Serif Display` + `Figtree`, dark surface color system, reading progress bar, scroll reveal animations.

### Features

- **Featured post hero** — mark any post as featured via the "Featured Post" meta box in the post editor
- **Reading progress bar** — appears on single posts
- **Related posts** — tag-matched posts pulled automatically on single post view
- **Comments** — styled dark comment thread with reply support
- **Gutenberg compatible** — `entry-content` styles cover all core blocks (image, quote, code, table, embed, gallery, button, separator, pullquote, cover)
- **Custom nav walker** — active-state classes on menu items
- **Newsletter form** — MC4WP-compatible; falls back to a plain HTML form
- **Admin bar offset** — sticky header respects WordPress admin bar height

### Template Hierarchy

| Template | Activates On |
|---|---|
| `home.php` | Blog index (`/?page_id=X` set as Posts page) |
| `single.php` | Individual posts |
| `page.php` | Static pages |
| `archive.php` | Category, tag, date, and custom taxonomy archives |
| `author.php` | Author archives |
| `search.php` | Search results (`/?s=query`) |
| `404.php` | Not found |
| `index.php` | WordPress fallback |

### Installing

1. Zip the `deep-dive-wordpress-theme/` folder
2. WordPress Admin → **Appearance → Themes → Add New → Upload Theme**
3. Activate

```bash
zip -r deep-dive-wordpress-theme.zip deep-dive-wordpress-theme/
```

### Recommended Plugins

| Plugin | Purpose |
|---|---|
| MC4WP: Mailchimp for WordPress | Newsletter subscribe form in footer |
| Yoast SEO or Rank Math | Meta titles, OG tags, sitemap |
| Advanced Custom Fields (ACF) | Tag/category cover images (used in `archive.php`) |

---

## 🎨 Shared Design System

Both the marketing site and The Deep Dive theme share the same brand palette:

| Token | Value |
|---|---|
| Navy | `#2b4570` |
| Blue | `#0369A1` |
| Light Blue | `#38BDF8` |
| Amber | `#f59e0b` |
| Dark | `#0d1117` |

---

## 🚀 Getting Started

```bash
git clone https://github.com/NoChillModeOnline/UEM-Architect-Website.git
cd UEM-Architect-Website

# Static site — open directly
open index.html

# WordPress theme — zip and upload to WP Admin
zip -r deep-dive-wordpress-theme.zip deep-dive-wordpress-theme/
```

---

## 📬 Contact

- **Email:** contact@uemarchitect.org
- **Schedule:** https://zeeg.me/uemarch-pso
- **LinkedIn:** https://www.linkedin.com/company/uem-architect-consulting

---

## 📄 License

See the [LICENSE](LICENSE) file for details.
