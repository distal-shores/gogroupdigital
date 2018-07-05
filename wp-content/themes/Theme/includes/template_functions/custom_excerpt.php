<?php

	/**
	 * Generates the excerpt portion of what gets printed in the template
	 *
	 *
	 * @package theme
	 * @subpackage boilerplate-theme
	 *
	 * @param int $limit Character limit for excerpt
	 * @param int $id post ID
	 *
	 * @return string HTML of excerpt
	 * @todo Rewrite this whole thing. It was stoled from the internet 5 years ago and has only been maintained a little bit
	 *
	 */
	function theme_excerpt($limit, $id) {

		if ( has_excerpt($id) ) {
			$content = get_post_field('post_excerpt', $id);
		} else {
			$content = get_post_field('post_content', $id);
		}

		$excerpt = explode(' ', $content, $limit);

		if (count($excerpt)>=$limit) {
			array_pop($excerpt);
			$excerpt = implode(" ",$excerpt).'...';
		} else {
			$excerpt = implode(" ",$excerpt);
		}

		return strip_tags( $excerpt, '<h2><br><b><h3>' );

		$excerpt = preg_replace('`\[[^\]]*]`','',$excerpt);
		$excerpt = preg_replace("/<img(.*?)>/si", "", $excerpt);
		$excerpt = preg_replace("/<em(.*?)>/si", "", $excerpt);

		return $excerpt;preg_replace('`\[[^\]]*]`','',$excerpt);

	}

	/**
	 * Generate excerpt of a custom field
	 *
	 */
	function theme_custom_field_excerpt($excerpt_length, $custom_field) {
		$text = get_field($custom_field); 
		if ( '' != $text ) {
			$text = strip_shortcodes( $text );
			$text = apply_filters('get_the_content', $text);
			$text = str_replace(']]&gt;', ']]&gt;', $text);
			$text = html_entity_decode($text);
			$excerpt_more = apply_filters('excerpt_more', '' . '...');
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
		return apply_filters('get_the_excerpt', $text);
	}

	/**
	 * Generate excerpt of a custom subfield
	 *
	 */
	function theme_custom_subfield_excerpt($excerpt_length, $custom_field) {
		if( have_rows('modules') ):
		while ( have_rows('modules') ) : the_row(); 
		if( get_row_layout() == 'content_module' ):
			$text = get_sub_field($custom_field); 
		endif;
		endwhile;
		endif;
		if ( '' != $text ) {
			$text = strip_shortcodes( $text );
			$text = apply_filters('get_the_content', $text);
			$text = str_replace(']]&gt;', ']]&gt;', $text);
			$text = html_entity_decode($text);
			$excerpt_more = apply_filters('excerpt_more', '' . '...');
			$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
		}
		return apply_filters('get_the_excerpt', $text);
	}

	/**
	 * This function gets called in the template.
	 *
	 * ### Usage
	 * ```php
	 * theme_custom_excerpt($length=50,$more_txt='Read More',$echo=true);
	 * ```
	 *
	 * @package theme
	 * @subpackage boilerplate-theme
	 *
	 * @param int $length Excerpt length
	 * @param string $more_text Read more text
	 * @param bool $echo Echo or return the excerpt
	 * @param bool $id Get the excerpt by ID
	 *
	 * @uses theme_excerpt()
	 * @todo Rewrite this function to follow the pattern I've been using lately
	 * @return string|nill 	Echos the html or returns it
	 *
	 */
	function theme_custom_excerpt($length='',$more_txt='Read More',$echo=true, $id=false) {

		$post_id = $id ? $id : get_post()->ID;

		$default_length = 30;
		if (empty($length)) {
				$excerpt_length = $default_length;
			} else {
				$excerpt_length = $length;
			}
		$excerpt = theme_excerpt($excerpt_length, $post_id);

		if ( $more_txt ) {
			$link = '<a href="'.get_permalink(get_post()->ID).'" class="more_link">'.$more_txt.'</a>';
		}

		$output = $excerpt;
		if ( $more_txt ) {
			$output .= $link;
		}

		if ( $echo ) {
			echo wpautop($output, true);
		} else {
			return wpautop($output, true);
		}

	}
