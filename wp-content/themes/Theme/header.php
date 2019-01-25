<!doctype html>
<!--[if IE 9]> <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="<?php bloginfo('language') ?>"><!--<![endif]-->
<head>
	<?php wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-93234307-1"></script>
	<script>
  		window.dataLayer = window.dataLayer || [];
  		function gtag(){dataLayer.push(arguments);}
  		gtag('js', new Date());

  		gtag('config', 'UA-93234307-1');
	</script>
	<meta name="description" content="<?php bloginfo('description') ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<link href="https://fonts.googleapis.com/css?family=Crimson+Text:400,600|Muli:400,700" rel="stylesheet">
	<!-- FAVICONS -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/favicons/safari-pinned-tab.svg" color="#2760b6">
	<meta name="msapplication-TileColor" content="#2760b6">
	<meta name="theme-color" content="#ffffff">
    <!--[if IE 8]>
        <style>html.ie-force-pseudo-refresh :before,html.ie-force-pseudo-refresh :after {content : none !important;}</style>
        <script>window.attachEvent&&!window.addEventListener&&window.attachEvent("onload",function(){var a=document.documentElement,b=a.className;a.className=b+" ie-force-pseudo-refresh",setTimeout(function(){a.className=b},10)});</script>
    <![endif]-->
</head>
<body <?php body_class(); ?>>

<header class="header">
	<div class="l-container">

		<!-- Logo -->
		<a href="<?php bloginfo('url'); ?>" class="header__logo">GO Group</a>

		<!-- Menu Button -->
		<span class="header__nav-button">Menu</span>

		<!-- Menu -->
		<div class="header__menu">
			<?php
				wp_nav_menu( array(
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

		<!-- Contact Button -->
		<a href="#contact" class="header__contact contact-button">Get In Touch</a>
		<a href="<?php echo wp_login_url() ?>" class="header__login login-button">Partner Login</a>

	</div>
</header>

