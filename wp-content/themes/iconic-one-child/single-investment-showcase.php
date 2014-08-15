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
						<?php if((get_field('profile_moderators')[0]["ID"] == get_current_user_id() || current_user_can('administrator')) && $_GET['action'] == 'edit'){
							acf_form();
						}else{

						?>
						<div style="width:65%; float:left;">
							<p style="padding-right:20px;">Sed bibendum tellus eget nisl venenatis gravida. Proin quis lectus nisl. Sed orci arcu, aliquam at accumsan at, facilisis quis tellus. Nunc accumsan sit amet nibh eget adipiscing. Duis adipiscing diam elit, non pretium lacus interdum at. Nam bibendum urna ut gravida feugiat. Sed vel erat facilisis, convallis justo eu, pharetra magna. Curabitur aliquam sapien quis felis mattis, in euismod lectus sollicitudin. Sed eget est at nisl convallis iaculis. </p>
							<h2 style="color:#EE2E22;padding-right:20px;">The Situation</h2>
							<p style="padding-right:20px;">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nulla quis tempor diam, sed rutrum ante. Morbi vitae iaculis orci, at mollis sapien. Vestibulum ut ante sit amet neque vulputate consequat. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Nunc non est in ipsum ullamcorper ultricies. Maecenas varius urna vel arcu varius, sit amet aliquam nisi congue. Suspendisse et mauris nec quam cursus interdum sit amet sed libero. Nunc pretium quam euismod tortor blandit auctor. Integer non quam dui. </p>
							<h2 style="color:#EE2E22;padding-right:20px;">The Intervention</h2>
							<p style="padding-right:20px;">Aenean et consectetur mauris, sed malesuada sapien. Sed hendrerit tellus urna, sit amet aliquam turpis auctor et. Sed eu justo sit amet ante vehicula ultricies ut vitae nunc. Sed pharetra aliquam bibendum. Integer id egestas arcu. Curabitur non dapibus ligula. Sed id nunc tristique, sollicitudin sem ut, consequat nisi. Nullam in semper felis, a dictum massa. </p>
							<h2 style="color:#EE2E22;padding-right:20px;">The Impact</h2>
							<p style="padding-right:20px;">Quisque vitae feugiat diam, sit amet malesuada eros. Nunc vitae sem leo. Suspendisse et risus at felis egestas vestibulum. Cras imperdiet felis ut enim commodo, eu viverra velit pretium. Phasellus eleifend sapien eu cursus malesuada. Nullam varius massa lorem, sed feugiat tellus cursus at. Proin nec dolor magna. Etiam rhoncus nec augue vel mollis. Nullam luctus sit amet risus eu interdum. Morbi auctor enim nec sem commodo dictum. Morbi et volutpat augue. Morbi enim risus, tincidunt in pulvinar eget, laoreet laoreet libero. Pellentesque non urna id dui fringilla volutpat non pharetra metus. Curabitur aliquet turpis ac ipsum fermentum auctor. Nullam placerat elit mi, et tempus ligula dignissim a. Morbi a ante nec mi vehicula hendrerit scelerisque eu mi. </p>
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
									<th>Organisation Type</th>
									<td><?php the_field('type_of_organisation'); ?></td>
								</tr>
								<tr>
									<th>Stage of Development</th>
									<td><?php the_field('stage_of_development'); ?></td>
								</tr>
								<tr>
									<th>Country</th>
									<td><?php the_field('country'); ?></td>
								</tr>
								<tr>
									<th>Sector</th>
									<td><?php the_field('social_sector'); ?></td>
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
					</div>
				</article>

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