<?php
/**
 * Template part for displaying single post pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package TM Arden
 * @since   1.0
 */
$university_id = get_post_meta(get_the_ID(), 'university', true);
echo get_user_meta($university_id, 'chapter_history', true);