<?php
/**
 * Template part for displaying single post pages.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Omega Psi Utilities
 * @since   2.0.0
 */
$university_id = get_post_meta(get_the_ID(), 'university', true);
?>
	<article id="post-<?php the_ID(); ?>" <?php post_class( 'tm-box-content' ); ?>>
		<div class="entry-header">
				<div class="post-categories">Chapter</div>
				<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>
		</div>
		<div class="entry-content">
			<?php
			echo get_user_meta($university_id, 'chapter_history', true);
			the_content( sprintf( /* translators: %s: Name of current post. */
				             wp_kses( __( 'Continue reading %s <span class="meta-nav">&rarr;</span>', 'tm-arden' ), array( 'span' => array( 'class' => array() ) ) ), the_title( '<span class="screen-reader-text">"', '"</span>', false ) ) );

			Insight_Templates::page_links();
			?>
		</div>
		<div class="row">
			<div class="col-md-12">
				<div class="entry-footer">
					<div class="row row-xs-center">
						<div class="col-md-6">
						</div>
						<div class="col-md-6">
							<?php //if ( Insight::setting( 'single_post_share_enable' ) === '1' ) : ?>
								<?php //Insight_Templates::post_sharing(); ?>
							<?php //endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</article>
