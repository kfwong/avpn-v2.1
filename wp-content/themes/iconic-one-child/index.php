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
	<div class="widget-area" style="font-size:14px; line-height:22px;">
		<p style="padding-bottom:10px;">The Asian Venture Philanthropy Network (AVPN) is growing the venture philanthropy community across the Asia Pacific region.</p>
		<p style="padding-bottom:10px;">Building on the success of the European Venture Philanthropy Association, which has more than 140 members in 20 countries in Europe, we undertake field building activities in Asia and provide a range of services to support our members.</p>
		<p style="padding-bottom:10px;">We launched our first Member Directory in April 2012 and continue to recruit members (please visit the membership application page, it’s easy to apply).</p>
		<p style="padding-bottom:10px;">To find out more about AVPN’s events, click here.</p>
	</div>
	<div class="site-content">
		<iframe width="640" height="360" src="//www.youtube.com/embed/5HPCg9VHp1w?rel=0&autoplay=0&controls=0&showinfo=0&modestbranding=1" frameborder="0" allowfullscreen></iframe>
	</div>
	<div class="site-content" style="width:96%;">
		<h2 style="font-size:28px;font-weight:normal;color:#EE2E22;margin-bottom:22px;">Featured Investment Showcase</h2>
		<article style="width: 33%;float:left;line-height:22px;">
			<img src="http://placehold.it/300x150" style="margin-bottom: 10px;display:block;margin-left:auto;margin-right:auto;"/>
			<p style="width:300px;display:block;margin-left:auto;margin-right:auto;text-align:justify;"><strong>Turquoise Mountain Trust</strong><br/>Turquoise Mountain is leading the regeneration of Murad Khane – an area in the old town of Kabul – transforming it into a vibrant cultural, educational and economic hub.</p>
		</article>
		<article style="width: 33%;float:left;line-height:22px;">
			<img src="http://placehold.it/300x150" style="margin-bottom: 10px;display:block;margin-left:auto;margin-right:auto;"/>
			<p style="width:300px;display:block;margin-left:auto;margin-right:auto;text-align:justify;"><strong>Turquoise Mountain Trust</strong><br/>Turquoise Mountain is leading the regeneration of Murad Khane – an area in the old town of Kabul – transforming it into a vibrant cultural, educational and economic hub.</p>
		</article>
		<article style="width: 33%;float:left;line-height:22px;">
			<img src="http://placehold.it/300x150" style="margin-bottom: 10px;display:block;margin-left:auto;margin-right:auto;"/>
			<p style="width:300px;display:block;margin-left:auto;margin-right:auto;text-align:justify;"><strong>Turquoise Mountain Trust</strong><br/>Turquoise Mountain is leading the regeneration of Murad Khane – an area in the old town of Kabul – transforming it into a vibrant cultural, educational and economic hub.</p>
		</article>
	</div>
	<div id="primary" class="site-content">
		<div id="content" role="main">
		<?php if ( have_posts() ) : ?>
			<?php /* Start the Loop */ ?>
			<?php while ( have_posts() ) : the_post(); ?>
				<?php get_template_part( 'content', get_post_format() ); ?>
			<?php endwhile; ?>

			<?php themonic_content_nav( 'nav-below' ); ?>

		<?php else : ?>

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

		<?php endif; // end have_posts() check ?>

		</div><!-- #content -->
	</div><!-- #primary -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>