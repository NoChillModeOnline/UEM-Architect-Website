#!/bin/bash
# UEM Architect — Push multi-page site update to GitHub
# Run this once from inside the project folder, or double-click to execute.

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

echo "📥 Pulling latest changes from origin/main..."
git pull origin main

echo "📦 Staging all changed files..."
git add index.html index.css who-we-serve.html services.html our-process.html why-us.html contact.html blog.html

echo "✍️  Committing..."
git commit -m "Convert single-page site to multi-page: 6 dedicated pages, blog, real testimonials

- Split into 7 dedicated pages: who-we-serve, services, our-process, why-us, contact, blog
- Home page now shows abbreviated previews with Learn More links to each page
- Why Us page combines Why Us + Testimonials (Michael Gallagher & Sarah Mitchell photos)
- Contact page combines Contact form + Get Started options
- Blog page is a coming-soon placeholder with subscribe form and topic previews
- Blog added to main navigation on all pages
- Updated LinkedIn URL to linkedin.com/company/uem-architect-consulting
- Added page-banner, active nav highlight, and blog CSS to index.css"

echo "🚀 Pushing to origin/main..."
git push origin main

echo ""
echo "✅ Done! All changes are live on GitHub."
