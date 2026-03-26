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
| `Image Materials for Website/` | Brand assets, service images, logos in multiple formats |

## Architecture

**Single-page layout** with these sections (in order): header → hero → audience → services → process → why → partners → testimonials → contact → footer.

**CSS design tokens** are defined in `:root` at the top of `index.css` — brand palette, gradients, spacing, shadows, radius, and transitions. Always use these tokens rather than raw values.

**JS modules** (all in `script.js` under `DOMContentLoaded`):
- Sticky header — toggles `header--scrolled` class at 60px scroll
- Mobile burger menu — toggles `open` / `active` classes on `#nav` and `#burger`
- Typing effect — rotates 4 phrases with human-like timing on `#typed-text`
- Scroll reveal — `IntersectionObserver` on `.reveal` elements, adds `.reveal--visible`; stagger delays via `.reveal--delay-1` through `.reveal--delay-6`
- Testimonial carousel — 3-slide carousel with dot navigation and 5s autoplay on `#testimonials-track`
- Smooth scroll — accounts for sticky header height offset
- Scroll-to-top — `#scroll-top` button visibility controlled by scroll position

**Known issues**:
- `script.js` lines 159–177: dead code block using `window.onscroll` that references `#scrollToTopBtn` (doesn't exist in HTML). This also overrides the earlier passive `scroll` event listener with a non-passive assignment. Safe to delete lines 158–177.

## Brand / Design Conventions

**Full `:root` token reference:**
- **Brand palette**: `--navy` (#2b4570), `--blue` (#00b4d8), `--light-blue` (#48cae4), `--sky` (#90e0ef), `--amber` (#f59e0b), `--amber-light` (#fbbf24), `--grey` (#94a3b8)
- **Dark backgrounds**: `--dark` (#0d1117), `--dark-mid` (#161b22) — used for hero and CTA sections
- **Light backgrounds**: `--off-white` (#f0f4f8), `--light-grey` (#e2e8f0)
- **Text**: `--text` (#1e293b), `--text-light` (#64748b)
- **Gradients**: `--grad-hero`, `--grad-card`, `--grad-cta`, `--grad-accent`, `--grad-amber`
- **Shadows**: `--shadow-sm/md/lg`, `--shadow-glow` (blue), `--shadow-amber`
- **Radius**: `--radius-sm` (8px) / `--radius-md` (12px) / `--radius-lg` (20px) / `--radius-xl` (28px)
- **Font**: Inter (Google Fonts) — weights 300–800
- **Section alternation**: even sections use `.section--alt` (off-white background)
- **Button variants**: `.btn--primary` (amber gradient) and `.btn--outline` (ghost/outline style)
- **Logo assets**: multiple variants in `Image Materials for Website/` — color/black/white, with/without wordmark, multiple sizes. The white-with-logo variant is used in the footer; color-with-logo-large in the header.

`index.css` is organized by component in order: reset/base → typography → layout utilities → header → hero → sections → cards → buttons → forms → testimonials → footer → scroll-to-top → animations → media queries.

## Contact / Social

- Email: info@uemarchitect.com
- Twitter/X: @UEMArchitect
- Location: Charlotte, NC
