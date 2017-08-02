<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package TM Arden
 * @since   1.0
 */
get_header();

?>
<?php get_template_part( 'components/title-bar' ); ?>
	<div id="page-content" class="page-content">
		<div class="container">
			<div class="row">

				<div class="page-main-content col-md-8">
					<?php
					while ( have_posts() ) : the_post();

						include 'chapter-content.php';

						if ( Insight::setting( 'single_post_pagination_enable' ) === '1' ) {
							the_post_navigation();
						}

						if ( Insight::setting( 'single_post_related_enable' ) ) {
							get_template_part( 'components/content', 'single-related-posts' );
						}

						// If comments are open or we have at least one comment, load 	up the comment template.
						if ( Insight::setting( 'single_post_comment_enable' ) === '1' && ( comments_open() || get_comments_number() ) ) :
							comments_template();
						endif;

					endwhile; // End of the loop.
					?>
				</div>

			</div>
		</div>
	</div>
<?php
get_footer();
