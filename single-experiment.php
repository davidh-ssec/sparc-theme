<?php
/**
 * The Template for displaying all single posts
 *
 * Methods for TimberHelper can be found in the /functions sub-directory
 *
 * @package  WordPress
 * @subpackage  Timber
 * @since    Timber 0.1
 */

$context = Timber::get_context();
$post = Timber::query_post();
$context['post'] = $post;
$context['wp_title'] .= ' - ' . $post->title();
$context['comment_form'] = TimberHelper::get_comment_form();
//$context['status_reports'] = Timber::get_posts(array('post_type' => 'field_post', 'category_name' => 'daily_status'));
$context['status_reports'] = Timber::get_posts(array('post_type' => 'field_post',
'category_name' => 'status-reports',
'connected_type' => 'field_post_to_experiment',
'connected_items' => get_queried_object(),
'nopaging' => true,
'suppress_filters' => false));

$context['photos'] = Timber::get_posts(array('post_type' => 'field_post',
'category_name' => 'field_photos',
'connected_type' => 'field_post_to_experiment',
'connected_items' => get_queried_object(),
'nopaging' => true,
'suppress_filters' => false));

if (post_password_required($post->ID)){
	Timber::render('single-password.twig', $context);
} else {
	Timber::render(array('single-' . $post->ID . '.twig', 'single-' . $post->post_type . '.twig', 'single.twig'), $context);
}


