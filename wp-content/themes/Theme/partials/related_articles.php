<?php
$excluded_posts = array(get_the_ID());
$categories = array_map(function ($category) { return $category->slug; }, get_the_category());

$args = array(
  'post_type' => 'blog_post',
  'post_status' => 'publish',
  'orderby' => 'date',
  'order' => 'DESC',
  'posts_per_page' => 3,
  'post__not_in' => $excluded_posts,
  'tax_query' => array(
    array(
      'taxonomy' => 'category',
      'field' => 'slug',
      'terms' => $categories,
    )
  ),
);
$loop = new WP_Query($args);
?>
<?php if ($loop->have_posts()) : ?>
  <div class="related-articles">
    <div class="related-articles__wrapper">
      <h2>Related Articles</h2>
      <ul id="recent-articles-list" class="blog-tiles">
        <?php
        while ($loop->have_posts()) {
          $loop->the_post();
          get_template_part('partials/listing', 'index');
        }
        ?>
      </ul>
    </div>
  </div>
<?php endif; ?>
<?php wp_reset_postdata(); ?>