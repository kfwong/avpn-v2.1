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

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<div class="form-thumbnail">
							<?php the_post_thumbnail();?>
						</div>
						<div class="form-group">
							<div class="form-title" style="float:left;padding 5px;width:35%;">
								<strong>Organisation Number</strong> 
							</div>
							<div class="form-entry" style="float:left; padding 5px;width:65%;">
								<?php the_field('organisation_registration_number'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="form-title" style="float:left;padding 5px;width:35%;">
								<strong>My organisation is registered as</strong> 
							</div>
							<div class="form-entry" style="float:left; padding 5px;width:65%;">
								<?php the_field('my_organisation_is_registered_as'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="form-title" style="float:left;padding 5px;width:35%;">
								<strong>AVPN Membership Type</strong> 
							</div>
							<div class="form-entry" style="float:left; padding 5px;width:65%;">
								<?php the_field('avpn_membership_type'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="form-title" style="float:left;padding 5px;width:35%;">
								<strong>Which social sectors do you support?</strong> 
							</div>
							<div class="form-entry" style="float:left; padding 5px;width:65%;">
								<?php the_field('which_social_sectors_do_you_support'); ?>
							</div>
						</div>
						<div class="form-group">
							<div class="form-title" style="float:left;padding 5px;width:35%;">
								<strong>Founder Member</strong> 
							</div>
							<div class="form-entry" style="float:left; padding 5px;width:65%;">
								<?php the_field('founder_member'); ?>
							</div>
						</div>
					</div>
					<footer class="entry-meta">
						<?php edit_post_link( __( 'Edit', 'themonic' ), '<span class="edit-link">', '</span>' ); ?>
					</footer>
				</article><!-- #post -->
				<nav class="nav-single">
					<div class="assistive-text"><?php _e( 'Post navigation', 'themonic' ); ?></div>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'themonic' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themonic' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>