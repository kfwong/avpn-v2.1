<?php
/*
 * The Template for displaying all single posts.
 *
 * @package WordPress - Themonic Framework
 * @subpackage Iconic_One
 * @since Iconic One 1.0
 */

acf_form_head();
get_header(); ?>
	<div id="primary" class="site-content">
		<div id="content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
					<header class="entry-header">
						<h1 class="entry-title"><?php the_title(); ?></h1>
					</header><!-- .entry-header -->
					<div class="entry-content">
						<?php

						if((get_field('profile_moderators')[0]["ID"] == get_current_user_id() || current_user_can('administrator')) && $_GET['action'] == 'edit'){
							acf_form();
						}else{

						?>
						<div style="width:65%; float:left;">
							<p style="padding-right:20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quis tempor diam, sed rutrum ante. Morbi vitae iaculis orci, at mollis sapien. Vestibulum ut ante sit amet neque vulputate consequat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc non est in ipsum ullamcorper ultricies. Maecenas varius urna vel arcu varius, sit amet aliquam nisi congue. Suspendisse et mauris nec quam cursus interdum sit amet sed libero. Nunc pretium quam euismod tortor blandit auctor. Integer non quam dui. </p>
							<h2 style="color:#EE2E22;padding-right:20px;">Additional Information</h2>
							<p style="padding-right:20px;">Aenean et consectetur mauris, sed malesuada sapien. Sed hendrerit tellus urna, sit amet aliquam turpis auctor et. Sed eu justo sit amet ante vehicula ultricies ut vitae nunc. Sed pharetra aliquam bibendum. Integer id egestas arcu. Curabitur non dapibus ligula. Sed id nunc tristique, sollicitudin sem ut, consequat nisi. Nullam in semper felis, a dictum massa. </p>
						</div>
						<div style="width:35%; float:left;">
							<table>
								<tr>
									<td colspan="2" style="border:none;">
										<?php $image = get_field('featured_image');?>

										<img class="aligncenter" src="<?php echo $image['url']; ?>" alt="<?php echo $image['alt']; ?>" style="max-width:300px;max-height:150px;" />
									</td>
								</tr>
								<tr>
									<th>Membership Type</th>
									<td><?php the_field('avpn_membership_type'); ?></td>
								</tr>
								<tr>
									<th>Countries of Operation</th>
									<td><?php the_field('which_are_the_main_countries_that_your_company_operate_in'); ?></td>
								</tr>
								<tr>
									<th>Social Sector</th>
									<td><?php the_field('which_social_sectors_do_you_support'); ?></td>
								</tr>
								<tr>
									<th>Type of Financing</th>
									<td><?php the_field('what_main_types_of_financing_do_you_offer'); ?></td>
								</tr>
								<tr>
									<th>Target Organisation Types</th>
									<td><?php the_field('what_is_your_preferred_type_of_target_organisations'); ?></td>
								</tr>
								<tr>
									<th>Preferred Stage of Development</th>
									<td><?php the_field('what_is_the_preferred_stage_of_development_of_target_organisations'); ?></td>
								</tr>
								<tr>
									<th>Involvement with Investees</th>
									<td><?php the_field('how_would_you_rate_your_hands-on_involvement_with_investees'); ?></td>
								</tr>
								<tr>
									<th>Types of Services Provided</th>
									<td><?php the_field('what_types_of_services_do_you_provide'); ?></td>
								</tr>
							</table>
						</div>
					</div>
					<footer class="entry-meta">
						<?php if(get_field('profile_moderators')[0]["ID"] == get_current_user_id()){ ?>
							<span class="edit-link"><a class="post-edit-link" href="<?php echo get_permalink() . '?action=edit'; ?>">Edit</a></span>
						<?php }else if(current_user_can('administrator')){ ?>
							<?php edit_post_link( __( 'Edit', 'themonic' ), '<span class="edit-link">', '</span>' ); ?>
						<?php } ?>
					</footer>
				</article><!-- #post -->
				<nav class="nav-single">
					<div class="assistive-text"><?php _e( 'Post navigation', 'themonic' ); ?></div>
					<span class="nav-previous"><?php previous_post_link( '%link', '<span class="meta-nav">' . _x( '&larr;', 'Previous post link', 'themonic' ) . '</span> %title' ); ?></span>
					<span class="nav-next"><?php next_post_link( '%link', '%title <span class="meta-nav">' . _x( '&rarr;', 'Next post link', 'themonic' ) . '</span>' ); ?></span>
				</nav><!-- .nav-single -->

				<?php } ?>
				<?php comments_template( '', true ); ?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_footer(); ?>