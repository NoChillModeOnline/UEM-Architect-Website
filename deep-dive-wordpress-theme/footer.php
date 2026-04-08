</main><!-- /#site-main -->

<!-- ── Site Footer ── -->
<footer class="site-footer">
  <div class="container">
    <div class="site-footer__inner">

      <!-- Brand column -->
      <div class="site-footer__brand">
        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home" aria-label="<?php bloginfo( 'name' ); ?> — home">
          <?php if ( has_custom_logo() ) :
            the_custom_logo();
          else : ?>
            <span class="site-footer__logo-text"><?php bloginfo( 'name' ); ?></span>
          <?php endif; ?>
        </a>

        <p class="site-footer__description"><?php bloginfo( 'description' ); ?></p>

        <div class="site-footer__social">
          <a href="https://www.linkedin.com/company/uem-architect-consulting" target="_blank" rel="noopener noreferrer" aria-label="UEM Architect on LinkedIn">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" width="18" height="18" aria-hidden="true">
              <path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433c-1.144 0-2.063-.926-2.063-2.065 0-1.138.92-2.063 2.063-2.063 1.14 0 2.064.925 2.064 2.063 0 1.139-.925 2.065-2.064 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/>
            </svg>
          </a>
        </div>
      </div>

      <!-- Navigation columns -->
      <div class="site-footer__links">
        <!-- Primary nav -->
        <div>
          <h4 class="site-footer__heading"><?php esc_html_e( 'Navigation', 'deep-dive' ); ?></h4>
          <?php
          wp_nav_menu( [
              'theme_location'  => 'footer',
              'container'       => false,
              'fallback_cb'     => '__return_false',
          ] );
          ?>
        </div>

        <!-- UEM Architect links -->
        <div>
          <h4 class="site-footer__heading">UEM Architect</h4>
          <ul>
            <li><a href="https://www.uemarchitect.org/services.html" target="_blank" rel="noopener">Services</a></li>
            <li><a href="https://www.uemarchitect.org/who-we-serve.html" target="_blank" rel="noopener">Who We Serve</a></li>
            <li><a href="https://www.uemarchitect.org/our-process.html" target="_blank" rel="noopener">Our Process</a></li>
            <li><a href="https://www.uemarchitect.org/contact.html" target="_blank" rel="noopener">Contact</a></li>
          </ul>
        </div>
      </div>

      <!-- Subscribe -->
      <div class="site-footer__subscribe">
        <h4 class="site-footer__heading"><?php esc_html_e( 'Stay in the Loop', 'deep-dive' ); ?></h4>
        <p><?php esc_html_e( 'Get endpoint management insights delivered to your inbox.', 'deep-dive' ); ?></p>
        <?php if ( function_exists( 'mc4wp_show_form' ) ) : ?>
          <?php mc4wp_show_form(); ?>
        <?php else : ?>
          <form class="footer-subscribe" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>" method="post">
            <input type="hidden" name="action" value="deep_dive_subscribe" />
            <?php wp_nonce_field( 'deep_dive_subscribe', '_nonce' ); ?>
            <input type="email" name="email" placeholder="<?php esc_attr_e( 'your@email.com', 'deep-dive' ); ?>"
              required autocomplete="email" aria-label="<?php esc_attr_e( 'Email address', 'deep-dive' ); ?>" />
            <button type="submit" class="btn btn--primary"><?php esc_html_e( 'Subscribe', 'deep-dive' ); ?></button>
          </form>
        <?php endif; ?>
      </div>

    </div><!-- /.site-footer__inner -->

    <div class="site-footer__bottom">
      <p>&copy; <?php echo esc_html( gmdate( 'Y' ) ); ?> UEM Architect. <?php esc_html_e( 'All rights reserved.', 'deep-dive' ); ?></p>
      <nav aria-label="<?php esc_attr_e( 'Legal links', 'deep-dive' ); ?>">
        <a href="https://www.uemarchitect.org/privacy.html" target="_blank" rel="noopener"><?php esc_html_e( 'Privacy Policy', 'deep-dive' ); ?></a>
      </nav>
    </div>

  </div><!-- /.container -->
</footer><!-- /.site-footer -->

<!-- Scroll to top -->
<button class="scroll-top" id="scroll-top" type="button" aria-label="<?php esc_attr_e( 'Scroll back to top', 'deep-dive' ); ?>">
  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
    stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
    stroke-linejoin="round" aria-hidden="true" width="20" height="20">
    <polyline points="18 15 12 9 6 15"></polyline>
  </svg>
</button>

<?php wp_footer(); ?>
</body>
</html>
