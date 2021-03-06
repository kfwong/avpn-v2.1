<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * For example, it puts together the home page when no home.php file exists.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package WordPress 
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */

get_header(); ?>
	<div class="featured widget-area" style="font-size:14px; line-height:22px;">
		<?php dynamic_sidebar( 'featured-sidebar' ); ?>
	</div>
	<div class="featured site-content">
		<?php dynamic_sidebar( 'featured' ); ?>
	</div>
	<div id="primary" class="site-content">
		<div id="content" role="main">

		<?php 
		if ( is_home() ) {
			$query = new WP_Query(array(
					'posts_per_page'	=> 5,
					'tax_query'		=>	array(array(
							'taxonomy'	=>	'featured-posts',
							'field'		=>	'slug',
							'terms'		=>	'home'
						)
					)
				)
			);

			if ( $query->have_posts() ){
				while ( $query->have_posts() ) : $query->the_post();
					get_template_part( 'content', get_post_format() );
				endwhile;

				themonic_content_nav( 'nav-below' );
			}else{ ?>
				<article id="post-0" class="post no-results not-found">

				<?php if ( current_user_can( 'edit_posts' ) ) :
					// Show a different message to a logged-in user who can add posts.
				?>
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'No posts to display', 'themonic' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php printf( __( 'Ready to publish your first post? <a href="%s">Get started here</a>.', 'themonic' ), admin_url( 'post-new.php' ) ); ?></p>
					</div><!-- .entry-content -->

				<?php else :
					// Show the default message to everyone else.
				?>
					<header class="entry-header">
						<h1 class="entry-title"><?php _e( 'Nothing Found', 'themonic' ); ?></h1>
					</header>

					<div class="entry-content">
						<p><?php _e( 'Kindly search your topic below or browse the recent posts.', 'themonic' ); ?></p>
						<?php get_search_form(); ?>
					</div><!-- .entry-content -->
				<?php endif; // end current_user_can() check ?>

				</article><!-- #post-0 -->
			<?php } ?>

		<?php } ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>