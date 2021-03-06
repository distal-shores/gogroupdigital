<footer class="footer">
	<div class="footer-top">
		<div class="l-container">
			<p class="footer-top__title">
				<span class="numeral"><?php the_field('data_points', 'option'); ?></span>
				<span class="text">Data Points</span><br>
				<span class="numeral"><?php the_field('accelerations', 'option'); ?></span>
				<span class="text">Accelerations</span><br>
				<span class="numeral"><?php the_field('industries', 'option'); ?></span>
				<span class="text">Industries</span><br>
			</p>
			<p class="footer-top__cta">Ready to go evolutionary to epic? <a href="#contact" class="contact-button">Get in Touch</a></p>
		</div>
	</div>

	<div class="footer-bottom">
		<div class="l-container">
			<a href="<?php bloginfo('url'); ?>" class="footer-bottom__logo">GO Group</a>

			<span class="footer-bottom__nav">
				<?php
					wp_nav_menu( array(
						'container' => 'nav',
						'container_class' => 'footer-nav',
						'theme_location' => 'footer',
						'menu_class' => 'footer-nav__items',
						'items_wrap' => '<h2 class="u-screen-reader">Main menu</h2><ul class="%2$s">%3$s</ul>',
						'depth' => 1
						)
					);
				?>
			</span>
			
			<span class="footer-bottom__social">
				<ul class="social">
					<li><a href="https://www.linkedin.com/company/go-group-digital/" target="_blank" class="social__item social__item--linkedin">LinkedIn</a></li>
					<li><a href="https://twitter.com/thegogroup" target="_blank" class="social__item social__item--twitter">Twitter</a></li>
				</ul>
				<p class="footer-bottom__copyright">&copy;GO GROUP DIGITAL <?php echo date('Y'); ?> ALL RIGHTS RESERVED.</p>
			</span>
		</div>
		<div class="l-container footer-bottom__partners">
			<h4>GLOBAL PARTNERS</h4>
			<div class="divider"></div>
			<div class="logos">
				<picture>
					<source media="(max-width: 801px)" srcset="<?php bloginfo('template_directory')?>/images/global-partners-mobile.png">
					<source media="(min-width: 801px)" srcset="<?php bloginfo('template_directory')?>/images/global-partners-desktop.png">
					<img src="<?php bloginfo('template_directory')?>/images/global-partners-desktop.png">
				</picture>
				<a id="conversion" href="https://conversion.com/" target="_blank" alt="CONVERSION" title="CONVERSION" /></a>
				<a id="conversionista" href="https://conversionista.com/" target="_blank" alt="CONVERSIONISTA!" title="CONVERSIONISTA!" /></a>
				<a id="konversionkraft" href="https://www.konversionskraft.de/" target="_blank" alt="konversionKRAFT" title="konversionKRAFT" /></a>
				<a id="newrepublique" href="https://newrepublique.com/" target="_blank" alt="new Republique" title="new Republique" /></a>
				<a id="optiphoenix" href="http://www.optiphoenix.com/" target="_blank" alt="OptiPhoenix" title="OptiPhoenix" /></a>
				<a id="uptilab" href="https://www.uptilab.com/en/welcome/" target="_blank" alt="uptilab" title="uptilab" /></a>
				<a id="widerfunnel" href="https://www.widerfunnel.com/" target="_blank" alt="widerfunnel" title="widerfunnel" /></a>
			</div>
		</div>
	</div>
</footer>

<!-- Contact Form Popup -->
<div class="contact-form">
	<div class="contact-form__form">
		<span class="contact-form__form__close">Close</span>
		<p class="contact-form__form__title">Ready to go evolutionary to epic?</p>
		<?php echo do_shortcode('[vfb id=1]'); ?>
	</div>
</div>

<?php wp_footer(); ?>
</body>
</html>
