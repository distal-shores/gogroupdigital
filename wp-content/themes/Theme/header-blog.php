<!doctype html>
<!--[if IE 9]> <html class="no-js ie9"> <![endif]-->
<!--[if gt IE 9]><!-->
<html class="no-js" lang="<?php bloginfo('language') ?>"><!--<![endif]-->
<head>
	<?php global $post; wp_head(); ?>
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-93234307-1"></script>
	<script>
		window.dataLayer = window.dataLayer || [];
		function gtag(){dataLayer.push(arguments);}
		gtag('js', new Date());
		gtag('config', 'UA-93234307-1');
	</script>
	<meta name="description" content="<?php bloginfo('description') ?>">
	<meta http-equiv="content-type" content="<?php bloginfo('html_type') ?>; charset=<?php bloginfo('charset') ?>" />
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<!-- FAVICONS -->
	<link rel="apple-touch-icon" sizes="180x180" href="<?php bloginfo('template_directory'); ?>/favicons/apple-touch-icon.png">
	<link rel="icon" type="image/png" sizes="32x32" href="<?php bloginfo('template_directory'); ?>/favicons/favicon-32x32.png">
	<link rel="icon" type="image/png" sizes="16x16" href="<?php bloginfo('template_directory'); ?>/favicons/favicon-16x16.png">
	<link rel="manifest" href="<?php bloginfo('template_directory'); ?>/favicons/site.webmanifest">
	<link rel="mask-icon" href="<?php bloginfo('template_directory'); ?>/favicons/safari-pinned-tab.svg" color="#2760b6">
	<meta name="msapplication-TileColor" content="#2760b6">
	<meta name="theme-color" content="#ffffff">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta property="og:title" content="<?php echo get_the_title($post->ID);?>"/>
	<meta property="og:site_name" content="<?php echo get_bloginfo(); ?>"/>
	<!--[if IE 8]>
		<style>html.ie-force-pseudo-refresh :before,html.ie-force-pseudo-refresh :after {content : none !important;}</style>
		<script>window.attachEvent&&!window.addEventListener&&window.attachEvent("onload",function(){var a=document.documentElement,b=a.className;a.className=b+" ie-force-pseudo-refresh",setTimeout(function(){a.className=b},10)});</script>
	<![endif]-->
</head>
<body <?php body_class(); ?>>
<?php get_template_part('header', 'nav'); ?>

<!-- Load Facebook SDK for JavaScript -->
<div id="fb-root"></div>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v4.0&appId=670426330032456&autoLogAppEvents=1"></script>
