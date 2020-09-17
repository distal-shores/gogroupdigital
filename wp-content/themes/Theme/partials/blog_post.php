<?php

$user = wp_get_current_user();
$content = get_the_content();

$show_form = get_field('show_gravity_form') == true ? true : false;
$marketing_page = get_field('marketing_page') == true ? true : false;
$featured_image = get_field('featured_image');
$subtitle = get_field('subtitle');
$contributing_authors = get_field('contributing_authors');
$byline_authors = get_field('byline_authors');
$go_content = get_field('go_content_switch');

?>

<?php if ($show_form) : ?>
  <div class="landing-background" style="background-image:url(<?php echo $featured_image['sizes']['blog_large']; ?>)"></div>
  <div class="landing-background scrim"></div>
<?php endif; ?>

<?php if ($featured_image) : ?>
  <?php if ($show_form) : ?>
    <div class="blog-post__image">
    <?php else : ?>
      <div class="blog-post__image" style="background-image:url(<?php echo $featured_image['sizes']['blog_large']; ?>)">
      <?php endif; ?>
      <div class="overlay"></div>
      <div class="blog-post__header">
        <?php if (!$show_form) : ?>
          <p class="blog-post__header__date">
            <?php $post_date = get_the_date('F j, Y');
            echo $post_date; ?>
          </p>
        <?php endif; ?>
        <h1 class="blog-post__header__title"><?php the_title(); ?></h1>
        <?php if (!$marketing_page) : ?>
          <hr class="blog-post__header__hr__short-blue" />
          <p class="blog-post__header__byline">
            <?php if ($byline_authors != NULL) : ?>
              <span class="blog-post__header__byline__by">By</span>
              <?php foreach ($byline_authors as $a) : ?>
                <span class="blog-post__header__byline__name"><?= get_the_title($a->ID) ?></span>
              <?php endforeach; ?>
            <?php else : ?>
              <span class="blog-post__header__byline__by">By</span> GO Group Digital
            <?php endif; ?>
          </p>
        <?php endif; ?>
      </div>
      </div>
    <?php endif; ?>

    <div class="page-content">

      <div class="l-container blog-content">

        <?php
        $categories = [];
        $is_digest = false;
        foreach (get_the_category() as $category) {
          if ($category->slug == 'digest') {
            $is_digest = true;
          }
          $categories[] = '<span>' . $category->category_nicename . '</span>';
        }
        ?>
        <?php if (!$marketing_page && !$is_digest) : ?>
          <div class="blog-post__blog-content__categories">
            <?php foreach ($categories as $category) : ?>
              <?= $category; ?>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>

        <?php if ($subtitle) : ?>
          <h2 class="blog-post__subtitle">
            <?php echo $subtitle; ?>
          </h2>
        <?php endif; ?>

        <?php
        $privilege_levels = array_map(function ($level) {
          return $level->slug;
        }, wp_get_post_terms(get_the_ID(), 'privilege_level'));
        $is_admin = in_array('administrator', $user->roles);
        $can_view = $is_admin || empty($privilege_levels) || in_array_any($privilege_levels, (array) $user->roles);
        if ($can_view) {
          the_content();
        } else {
          $mailtoSubject = str_replace(' ', '%20', the_title('', ' Access', false));
        ?>
          <p style="text-align:left">
            This content is reserved for Go Partners. As a GO Partner, please <a href="<?= wp_login_url(); ?>">log in</a> to gain access.<br>
            Not a partner? Please <a href="#contact">contact us</a> to learn about exclusive access to the GO Group Digital Platform.
          </p>
        <?php
        }
        ?>

        <?php if (!$marketing_page) : ?>
          <?php if (!$show_form) : ?>
            <?= do_shortcode('[social-shares]'); ?>
          <?php endif; ?>

          <?php if ($contributing_authors || $byline_authors) : ?>
            <h4 class="blog-post__authors__header">Contributing Author(s)</h4>
            <?php
            $authors = array();
            if ($byline_authors) {
              $authors = array_merge($authors, $byline_authors);
            }
            if ($contributing_authors) {
              $authors = array_merge($authors, $contributing_authors);
            }
            ?>
            <ul class="blog-post__authors">
              <?php foreach ($authors as $a) : ?>
                <li>
                  <img class="blog-post__authors__headshot" src="<?= get_field('profile_image', $a->ID)["url"]; ?>">
                  <div class="blog-post__authors__details">
                    <span class="blog-post__authors__details__name"><?= get_the_title($a->ID) ?></span>
                    <span class="blog-post__authors__details__title"><?= get_field('title', $a->ID); ?></span>
                  </div>
                </li>
              <?php endforeach; ?>
            </ul>
          <?php endif; ?>
        <?php endif; ?>

      </div>

      <?php if ($show_form) : ?>
        <div class="form-overlay-wrapper">
          <div class="form-overlay">
            <?php gravity_form(get_field('gravity_form'), true, false) ?>
          </div>
          <?php echo do_shortcode('[social-shares]') ?>
        </div>
      <?php endif; ?>

      <div class="blog-post__contact <?= $marketing_page == true ? 'blog-post__contact__no-border' : '' ?>">
        <h4>Got Questions?</h4>
        <a href="#contact" class="contact-button">Reach Out to Us</a>
      </div>

      <?php if (!$marketing_page) : ?>
        <?php if (get_field('blog_post_about_go', 2) != NULL) : ?>
          <div class="blog-post__about">
            <?php echo get_field('blog_post_about_go', 2); ?>
          </div>
        <?php endif; ?>
      <?php endif; ?>

      <div class="blog-post__footnotes"></div>

    </div><!-- .page-content -->