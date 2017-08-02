<?php
/**
 * The template for displaying all single posts.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package TM Arden
 * @since   1.0
 */
?>
<!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="profile" href="http://gmpg.org/xfn/11">
	<?php if ( is_singular() && pings_open( get_queried_object() ) ) : ?>
		<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">
	<?php endif; ?>
	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php Insight::body_attributes(); ?>>
<?php get_template_part( 'components/preloader' ); ?>
<div id="page" class="site">
	<div class="content-wrapper">
		<?php get_template_part( 'components/topbar' ); ?>
		<?php Insight_Templates::slider( 'below' ); ?>
		<header id="page-header" <?php Insight::header_class(); ?>>
			<?php $header_type = Insight::setting( 'header_type' ); ?>
			<?php get_template_part( 'components/header', $header_type ); ?>
			<?php Insight_Templates::slider( 'behind' ); ?>
		</header>
		<?php Insight_Templates::slider( 'above' ); ?>

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
