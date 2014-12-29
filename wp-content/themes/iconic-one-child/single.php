<?php
/*
 * The Template for displaying all single posts.
 *
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */

get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'get_post_format()' ); ?>
				<?php
				$post_terms = wp_get_object_terms( $post->ID,  array('geography', 'publishing-organisations', 'topics', 'practice-areas') );
// Default values
		$defaults = array(
			'before' 	=> __('Tags: ', 'simpletags'),
			'separator' => ', ',
			'after' 	=> '<br />',
			'post_id' 	=> 0,
			'inc_cats' 	=> 0,
			'xformat' 	=> __('<a href="%tag_link%" title="%tag_name_attribute%" %tag_rel%>%tag_name%</a>', 'simpletags'),
			'notagtext' => __('No tag for this post.', 'simpletags'),
			'number' 	=> 0,
			'format' 	=> ''
		);
		
		// Get values in DB
		$defaults['before'] = $options['tt_before'];
		$defaults['separator'] = $options['tt_separator'];
		$defaults['after'] = $options['tt_after'];
		$defaults['inc_cats'] = $options['tt_inc_cats'];
		$defaults['xformat'] = $options['tt_xformat'];
		$defaults['notagtext'] = $options['tt_notagstext'];
		$defaults['number'] = (int) $options['tt_number'];
		if ( empty($args) ) {
			$args = $options['tt_adv_usage'];
		}
		
		// Extract data in variables
		$args = wp_parse_args( $args, $defaults );
		extract($args);
		
		// If empty use default xformat !
		if ( empty($xformat) ) {
			$xformat = $defaults['xformat'];
		}
		
				if ( ! empty( $post_terms ) ) {
					if ( ! is_wp_error( $post_terms ) ) {

						foreach( $post_terms as $term ) {
							echo '<a href="' . esc_url(get_term_link($term)) .'">#' . $term->name . '</a>&nbsp;&nbsp;'; 
						}
						echo '<br/><br/><br/>';
					}
				}
				?>
				<nav class="nav-single">
					<div class="assistive-text"><?php _e( 'Post navigation', 'themonic' ); ?></div>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'themonic' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themonic' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>