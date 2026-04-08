# UEM Architect Website

Source code for **UEM Architect Consulting** — an Omnissa Silver Partner & Solution Reseller helping organizations architect, implement, and operate secure, scalable UEM environments.

This repository contains three projects:

| Project | Directory | Purpose |
|---|---|---|
| Marketing Site | `/` (root) | Static HTML/CSS/JS marketing website at uemarchitect.org |
| The Deep Dive — Ghost Theme | `deep-dive-ghost-theme/` | Ghost 5 theme for the editorial blog |
| The Deep Dive — WordPress Theme | `deep-dive-wordpress-theme/` | WordPress theme (active) for deepdive.uemarchitect.org |

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
├── deep-dive-ghost-theme/      # Ghost 5 theme (archived)
│   ├── default.hbs             # Master layout
│   ├── index.hbs               # Homepage (featured post + grid)
│   ├── post.hbs                # Single post
│   ├── page.hbs                # Static page
│   ├── tag.hbs                 # Tag archive
│   ├── author.hbs              # Author archive
│   ├── error.hbs               # 404 page
│   ├── package.json            # Ghost theme config
│   ├── partials/
│   │   ├── site-nav.hbs        # Navigation header
│   │   ├── site-footer.hbs     # Footer
│   │   └── post-card.hbs       # Post card partial
│   └── assets/
│       ├── css/screen.css      # Full stylesheet
│       ├── js/main.js          # Theme JS
│       └── images/favicon.svg  # SVG favicon
│
└── deep-dive-wordpress-theme/  # WordPress theme (active)
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

## 2 — The Deep Dive Ghost Theme

Ghost 5 Handlebars theme for `deepdive.uemarchitect.org`. Archived in favor of the WordPress theme below, but kept for reference.

**Design:** Dark editorial — `DM Serif Display` + `Figtree`, surface color system, reading progress bar, scroll reveal animations.

**Ghost features used:** `card_assets`, members (subscribe forms), `{{#get}}` for related posts, `{{navigation}}`, custom settings for color scheme and featured post toggle.

To install: zip `deep-dive-ghost-theme/` and upload via Ghost Admin → Design → Upload theme.

---

## 3 — The Deep Dive WordPress Theme

Active WordPress theme for `deepdive.uemarchitect.org`. Mirrors the Ghost theme design with full PHP template hierarchy.

### Features

- **Featured post hero** — mark any post as featured via the "Featured Post" meta box in the post editor; displays full-width on the homepage
- **Reading progress bar** — appears on single posts
- **Related posts** — tag-matched posts pulled automatically on single post view
- **Comments** — styled dark comment thread with reply support
- **Gutenberg compatible** — `.entry-content` styles cover all core blocks (image, quote, code, table, embed, gallery, button, separator, pullquote, cover)
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

### Recommended Plugins

| Plugin | Purpose |
|---|---|
| MC4WP: Mailchimp for WordPress | Newsletter subscribe form in footer |
| Yoast SEO or Rank Math | Meta titles, OG tags, sitemap |
| Advanced Custom Fields (ACF) | Tag/category cover images (used in `archive.php`) |

---

## 🎨 Shared Design System

Both themes share the same design tokens:

| Token | Value |
|---|---|
| `--navy` | `#2b4570` |
| `--blue` | `#0369A1` |
| `--light-blue` | `#38BDF8` |
| `--amber` | `#f59e0b` |
| `--dark` / `--surface-0` | `#0d1117` |
| Display font | DM Serif Display |
| Body font | Figtree |

---

## 🚀 Getting Started

```bash
git clone https://github.com/NoChillModeOnline/UEM-Architect-Website.git
cd UEM-Architect-Website

# Static site — open directly
open index.html

# WordPress theme — zip and upload
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
