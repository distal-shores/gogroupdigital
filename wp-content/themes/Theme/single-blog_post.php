<?php get_header('blog'); ?>

<?php the_post(); ?>

<?php
$classes = ['l-body', 'blog-post'];
if (get_field('show_gravity_form') == true) {
	$classes[] = 'has-form';
}
foreach (get_the_category() as $category) {
	if ($category->slug == 'digest') {
		$classes[] = 'digest';
		break;
	}
}
?>

<div class="<?= implode(' ', $classes) ?>">
	<?php get_template_part('partials/blog_post'); ?>
	<?php get_template_part('partials/related_articles'); ?>
</div>


<?php get_footer(); ?>