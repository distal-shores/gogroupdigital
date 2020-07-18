<?php

// Template functions. If order is important, replace this and require each file separately.
foreach (glob(dirname(__FILE__) . '/includes/template_functions/*.php') as $filename) {
    require_once($filename);
}

// Includes
include_once 'includes/utility.php';
include_once 'includes/customizer.php';
include_once 'includes/admin_favicon.php'; // adds favicon to the admin backend
include_once 'includes/admin_styling.php'; // Custom styles in admin
include_once 'includes/body_class.php'; // Expand body classes
include_once 'includes/clean_up.php'; // Remove all commented code from showing
include_once 'includes/conceal_settings.php'; // Conceal Settings
include_once 'includes/cpt_archives.php'; // Add custom post types to wp_get_archives
include_once 'includes/custom_editor_styles.php'; // Add stylesheet to apply styles to editor
include_once 'includes/custom_shortcodes.php'; // Add stylesheet to apply styles to editor
include_once 'includes/edit_class.php'; // Expand edit link classes
include_once 'includes/image_sizes.php'; // image size definitions
include_once 'includes/image_strip.php'; // Strip <p> from images
include_once 'includes/login_page.php'; // Customize admin login
include_once 'includes/menu_classes.php'; // Expand menu classes
include_once 'includes/menus.php'; // core menu registration
include_once 'includes/post_classes.php'; // Expand post classes
include_once 'includes/post_image_classes.php'; // Post classes for images
include_once 'includes/responsive_iframes.php'; // Make all iframe responisve
include_once 'includes/scripts.php'; // Enqued Scripts
include_once 'includes/sidebars.php'; // core sidebar registration
include_once 'includes/sub_menu.php'; // Expand sub menu functionality
include_once 'includes/theme_setup.php'; // stylesheet_uri, after_setup_theme, cleanup head

// Allow for the USC plugin to work for custom posts of the type Blog Posts
add_filter('USC_allowed_post_types', 'usc_filter_post_types');
function usc_filter_post_types($types)
{
    $types[] = 'blog_post';
    return $types;
}

// check if the user is one of the `Go Members`
function is_go_member()
{
    $user = wp_get_current_user();
    $role = current($user->roles);
    $is_go_member = in_array($role, ['managing_partner', 'strategic_partner', 'associate_partner']);
    return $is_go_member;
}

// Prevent 'Go Members' from accessing the WP dashboard
function blockusers_init()
{
    if (is_admin() && is_go_member() && !(defined('DOING_AJAX') && DOING_AJAX)) {
        wp_redirect(home_url());
        exit;
    }
}
add_action('init', 'blockusers_init');

// remove admin bar for 'Go Members'
function remove_admin_bar()
{
    if (is_go_member()) {
        show_admin_bar(false);
    }
}
add_action('after_setup_theme', 'remove_admin_bar');

// Simple function for checking multiple user role types at once
function in_array_any($needles, $haystack)
{
    return !!array_intersect($needles, $haystack);
}

function admin_default_page()
{
    $url = home_url() . '/insights';
    return $url;
}
add_filter('login_redirect', 'admin_default_page');

function my_enqueue_scripts()
{
    wp_enqueue_script('footnote-append',  get_stylesheet_directory_uri() . '/js/footnote-append.js', array('jquery'), '1.0', true);
    wp_enqueue_script('accept-cookies',  get_stylesheet_directory_uri() . '/js/accept-cookies.js', array(), '1.0', true);

    if (is_page('insights')) {
        wp_enqueue_script('ajax-fetch',  get_stylesheet_directory_uri() . '/js/ajax-fetch.js', array('jquery'), '1.0', true);

        $post__not_in = array();
        if (isset($featured_post)) {
            array_push($post__not_in, $featured_post->ID);
        }
        $args = array(
            'post_type' => 'blog_post',
            'orderby' => 'date',
            'order' => 'DESC',
            'posts_per_page' => 3,
            'post__not_in' => $post__not_in,
            'tax_query' => array(
                array(
                    'taxonomy' => 'category', // Taxonomy, in my case I need default post categories
                    'field'    => 'slug',
                    'terms'    => 'groupx', // Your category slug (I have a category 'interior')
                ),
            )
        );
        $loop = new WP_Query($args);
        wp_localize_script('ajax-fetch', 'ajaxfetch', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'query_vars' => json_encode($loop->query)
        ));
    }
}

add_action('wp_enqueue_scripts', 'my_enqueue_scripts');

add_action('wp_ajax_nopriv_ajax_fetch', 'my_ajax_fetch');
add_action('wp_ajax_ajax_fetch', 'my_ajax_fetch');

function my_ajax_fetch()
{
    $query_vars = json_decode(stripslashes($_POST['query_vars']), true);
    $posts = new WP_Query($query_vars);
    $GLOBALS['wp_query'] = $posts;
    if (!$posts->have_posts()) {
        get_template_part('content', 'none');
    } else {
        while ($posts->have_posts()) {
            $posts->the_post();
            include(locate_template('partials/listing-index.php', false, false));
        }
    }
    die();
}

function acf_load_vfb_form_field_choices( $field )
{
    // reset the choices
    $field['choices'] = array();

	global $wpdb;
	$forms = $wpdb->get_results("
			SELECT id, title
			FROM wp_vfbp_forms
			WHERE status = 'publish'
    ");
    
    if (is_array($forms)) {
        foreach ($forms as $form) {
            $field['choices'][$form->id] = $form->title;
        }
    }

    return $field;
} 
add_filter( 'acf/load_field/name=vfb_form', 'acf_load_vfb_form_field_choices' );

function acf_load_gravity_form_field_choices( $field )
{
    $field['choices'] = array();

    $forms = GFAPI::get_forms();
    if ( count( $forms ) > 0 ) {
        foreach ( $forms as $form ) {
            $field['choices'][$form['id']] = $form['title'];
        }
    }

    return $field;
}
add_filter( 'acf/load_field/name=gravity_form', 'acf_load_gravity_form_field_choices' );
