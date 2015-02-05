<?php


get_header(); ?>
				<div id="primary" class="site-content" style="width:inherit;">
					<div id="content" role="main">
						<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

								<table id="newsletter-tbl">
									<tr>
										<td style="vertical-align:top;width:20%;border-right: 1px solid #F3F3F3;padding-right:20px;line-height:1.5em;">
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">Content</span>
												<ul style="list-style-type: square;list-style-position:inside;margin-top: 10px;clear:both;">
													<?php wp_reset_postdata(); ?>
													<?php wp_list_pages( array('title_li'=>'','include'=> get_post_top_ancestor_id(), 'post_type' => 'newsletter') ); ?>
   													<?php wp_list_pages( array('title_li'=>'','depth'=>1,'child_of'=>get_post_top_ancestor_id() , 'post_type' => 'newsletter') ); ?>
												</ul>
											</div>
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">AVPN Job</span>
												<ul style="list-style-type: square;list-style-position: inside;margin-top: 10px;">
													<?php
												        $lastposts = get_posts('posts_per_page=5&orderby=rand&category_name=career-avpn');
												        foreach($lastposts as $post) :
												        setup_postdata($post); ?>

												        <li style="margin-bottom:10px;"
												        	<?php if ( $post->ID == $wp_query->post->ID ) { echo ' class="current"'; } else {} ?>>
												            <?php echo get_the_post_thumbnail( $post->ID, array(64,64) ); ?>
												            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
												            
												        </li>

												    <?php endforeach; ?>
												</ul>
											</div>
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">Network Job</span>
												<ul style="list-style: square;list-style-position: inside;margin-top: 10px;">
													<?php
												        $lastposts = get_posts('posts_per_page=5&orderby=rand&category_name=career-network');
												        foreach($lastposts as $post) :
												        setup_postdata($post); ?>

												        <li style="margin-bottom:10px;"
												        	<?php if ( $post->ID == $wp_query->post->ID ) { echo ' class="current"'; } else {} ?>>
												            <?php echo get_the_post_thumbnail( $post->ID, array(64,64) ); ?>
												            <a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
												            
												        </li>

												    <?php endforeach; ?>
												</ul>
											</div>
										</td>
										<td style="vertical-align:top;padding:20px;">
											<?php wp_reset_postdata(); ?>
											<header class="entry-header">
												<h1 class="entry-title" style="font-weight:bold;font-size:36px;"><?php the_title(); ?></h1>
											</header><!-- .entry-header -->
											<div class="entry-content">
												<?php while ( have_posts() ) : the_post(); ?>
													<?php the_content(); ?>
												<?php endwhile;?>
											</div>
										</td>
										<td style="vertical-align:top;width:20%;border-left: 1px solid #F3F3F3;padding-left:20px;line-height:1.5em;">
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">Investment Showcase</span>
												<ul style="list-style: none;margin-top: 10px;">
													<?php
												        $lastposts = get_posts('posts_per_page=5&orderby=rand&post_type=investment-showcase');
												        foreach($lastposts as $post) :
												        setup_postdata($post); ?>

												        <li style="margin-bottom:5px;"
												        	<?php if ( $post->ID == $wp_query->post->ID ) { echo ' class="current"'; } else {} ?>>
												            <?php echo get_the_post_thumbnail( $post->ID, array(64,64) ); ?>
												            <p>
												            	<a href="<?php the_permalink() ?>"><?php the_title(); ?></a>
												            	<br/>
												            	<span>
												            	<?php

												            	$post_object = get_field('organisation_name');

																if( $post_object ){

																	// override $post
																	$post = $post_object;
																	setup_postdata( $post );

																	echo '<a href="' . get_permalink() . '"><small> -- ' . get_the_title() . '</small></a>';

																	wp_reset_postdata(); 
																}
												            	?>
												            	</span> 
												            </p>
												            <br style="clear:both;"/>
												        </li>

												    <?php endforeach; ?>
												</ul>
											</div>
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">AVPN Events</span>
												<div style="margin-top:10px;">
													<?php echo do_shortcode('[events_list category="avpn-event" limit=5]<p style="margin-bottom:5px;">#_EVENTLINK<br/><small>#_EVENTDATES<br/>#_LOCATIONLINK</small></p>[/events_list]'); ?>
												</div>
											</div>
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">Network Events</span>
												<div style="margin-top:10px;">
													<?php echo do_shortcode('[events_list category="network-event" limit=5]<p style="margin-bottom:5px;">#_EVENTLINK<br/><small>#_EVENTDATES<br/>#_LOCATIONLINK</small></p>[/events_list]'); ?>
												</div>
											</div>
											<div style="border-bottom: 1px solid #F3F3F3;padding: 20px 0px;">
												<span class="avpn-red" style="font-size:12pt;font-weight:bold;">Member Directory</span>
												<div style="margin-top:10px;">
													<ul style="list-style: none;margin-top: 10px;">

												        <li style="margin-bottom:5px;">
												            <a href=<?php echo home_url('/membership/list-of-members'); ?>>List of Members</a>
												        </li>
													</ul>
												</div>
											</div>
										</td>
									</tr>
								</table>

								<footer class="entry-meta">
									<?php 
									if(current_user_can('administrator')){ 
										edit_post_link( __( 'Edit', 'themonic' ), '<span class="edit-link">', '</span>' );
									}else if(is_coauthor_for_post(get_current_user_id(), get_the_ID())){
										
									?>
										<span class="edit-link"><a class="post-edit-link" href="<?php echo get_permalink() . '?action=edit'; ?>">Edit</a></span>
									<?php
									
									}
									
									?>
								</footer>
							</article><!-- #post -->

							<?php comments_template( '', true ); ?>

					</div><!-- #content -->
				</div><!-- #primary -->

<?php get_footer(); ?>
?>
