<header class="header">
  <div class="l-container">

    <div class="header__content">
      <!-- Menu Button -->
      <span class="header__nav-button">
        <i class="fas fa-bars"></i>
        <span class="header__nav-button__button">Menu</span>
      </span>

      <div class="spacer"></div>

      <!-- Login/Logout Button -->
      <?php if (!is_user_logged_in()) : ?>
      <a href="<?php echo wp_login_url() ?>" class="header__login login-button">Partner Login</a>
      <?php else : ?>
      <a href="<?php echo wp_logout_url() ?>" class="header__login login-button">Log Out</a>
      <?php endif; ?>
      <!-- Contact Button -->
      <a href="#contact" class="header__contact contact-button">Get In Touch</a>
    </div>

    <!-- Logo -->
    <a href="<?php bloginfo('url'); ?>" class="header__logo">
      GO Group
    </a>

    <!-- Menu -->
    <div class="header__menu">
      <?php wp_nav_menu(
        array(
          'container' => 'nav',
          'container_class' => 'primary-nav',
          'theme_location' => 'primary',
          'menu_class' => 'primary-nav__items',
          'items_wrap' => '<h2 class="u-screen-reader">Main menu</h2><ul class="%2$s">%3$s</ul>',
          'depth' => 1
        )
      );
      ?>
      <span class="header__menu__close">Close</span>
    </div>
  </div>
</header>
