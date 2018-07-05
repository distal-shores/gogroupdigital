<?php get_header(); ?>

<?php if ( theme_is_listing() ): ?>
	
	<div class="tile-articles l-container">

		<h1 class="section-title"><?php wp_title($sep = ''); ?></h1>

		<?php
			$args = array(
				'post_type' => 'news',
			);
			$loop = new WP_Query( $args );
			if ( $loop->have_posts() ): 

				include(locate_template('partials/listing.php', false, false));
				get_template_part( 'partials/pagination', get_post_type() );

			endif;
			wp_reset_postdata();
		?>

	</div>

<?php endif; ?>

<?php get_footer(); ?>