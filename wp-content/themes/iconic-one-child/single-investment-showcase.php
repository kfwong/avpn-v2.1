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
						<?php if(is_coauthor_for_post(get_current_user_id(), get_the_ID()) && $_GET['action'] == 'edit'){
							acf_form();
						}else{

						?>
						<div style="width:60%; float:left;">
							<h2 style="font-weight:bold;padding-right:20px;">The Situation</h2>
							<?php $the_situation = get_field('the_situation'); ?>
							<?php echo empty($the_situation)? "No information available." : get_field('the_situation'); ?>
							<h2 style="font-weight:bold;padding-right:20px;">The Intervention</h2>
							<?php $the_intervention = get_field('the_intervention'); ?>
							<?php echo empty($the_intervention)? "No information available." : get_field('the_intervention'); ?>
							<h2 style="font-weight:bold;padding-right:20px;">The Impact</h2>
							<?php $the_impact = get_field('the_impact'); ?>
							<?php echo empty($the_impact)? "No information available." : get_field('the_impact'); ?>
						</div>
						<div style="width:35%; float:right;">
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
						<?php 

						if(is_coauthor_for_post(get_current_user_id(), get_the_ID())){
							if(current_user_can('administrator')){ 
								edit_post_link( __( 'Edit', 'themonic' ), '<span class="edit-link">', '</span>' );
							}else{
							?>
								<span class="edit-link"><a class="post-edit-link" href="<?php echo get_permalink() . '?action=edit'; ?>">Edit</a></span>
							<?php
							}
						}
						
						?>
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