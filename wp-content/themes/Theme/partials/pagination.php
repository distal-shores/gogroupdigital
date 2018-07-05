<?php if ( $wp_query->max_num_pages > 1 ) : ?>

	<?php $page_number = get_query_var('paged'); ?>

		<?php the_posts_pagination( array(
			'mid_size'  => 3,
			'prev_text' => __( 'Previous', 'textdomain' ),
			'next_text' => __( 'Next', 'textdomain' ),
		) ); ?>

<?php endif; ?>
