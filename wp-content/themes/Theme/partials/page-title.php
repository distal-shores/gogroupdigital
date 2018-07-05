<h1 class="page-title"><?php theme_page_title(); ?></h1>

<?php if ( !is_search() ): ?>
	<div class="page-title__section-nav">
		<?php get_template_part( 'partials/section-nav', get_post_type() ); ?>
	</div>
<?php endif; ?>
