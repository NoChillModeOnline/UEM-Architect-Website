#!/bin/bash
# UEM Architect — Push latest site updates to GitHub
# Run from Terminal: bash git-push.sh

set -e

SCRIPT_DIR="$(cd "$(dirname "${BASH_SOURCE[0]}")" && pwd)"
cd "$SCRIPT_DIR"

echo "⚙️  Configuring git identity..."
git config user.email "contact@uemarchitect.org"
git config user.name "ZombieSlayer"

echo "📦 Staging all site files..."
git add index.html index.css script.js \
        who-we-serve.html services.html our-process.html \
        why-us.html contact.html blog.html privacy.html \
        Images/businessman.png Images/businesswoman.png

echo "✍️  Committing..."
git commit -m "Add GDPR cookie consent banner and Privacy Policy page

- script.js: Auto-injecting cookie consent banner on all pages via IIFE;
  stores user choice (all / essential-only) in localStorage under
  uema_cookie_consent; slides up from bottom with CSS transition
- index.css: Cookie banner styles (dark themed, responsive mobile stack),
  footer__legal link styles, and privacy page prose styles
- privacy.html: Full GDPR-compliant Privacy & Cookie Policy page covering
  data collection, legal basis, cookie inventory, third-party services,
  data retention, user rights, and contact details
- All 7 page footers updated with Privacy & Cookie Policy link in footer__bottom

Co-Authored-By: Claude Sonnet 4.6 <noreply@anthropic.com>"

echo "🚀 Pushing to origin/main..."
git push origin main

echo ""
echo "✅ Done! All changes are live on GitHub."
