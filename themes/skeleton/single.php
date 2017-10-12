<?php
/**
 * The template for displaying any single post.
 *
 */

get_header(); ?>

<?php
    if ($post->post_type == "location"){
        $address = get_field("location_address")."+".get_field("city")."+".get_field("state"); // Google HQ
        $prepAddr = str_replace(' ','+',$address);
        $geocode=file_get_contents('https://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
        $output= json_decode($geocode);
        $latitude = $output->results[0]->geometry->location->lat;
        $longitude = $output->results[0]->geometry->location->lng;
        update_post_meta( get_the_id(), 'latitude', $latitude );
        update_post_meta( get_the_id(), 'longitude', $longitude );
    }
?>

<section id="main-section" class="main-section">

<?php $news_post=array("news","post","in_the_news","event"); ?>

	<div id="primary" class="row-fluid">
		<div id="content" role="main" class="span8 offset2">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); $class=""; ?>

					<?php if (in_array($post->post_type, $news_post)) $class="with-sidebar"; ?>

					<section id="the-main-content" class="the-main-content">

						<div class="content-container <?php print $class; ?>">
						
							<article class="post">
									<?php if (in_array($post->post_type, $news_post)){
										if ($post->post_type == 'post') 
											$singular_name="Article"; 
										else {
											$obj = get_post_type_object( $post->post_type );
											$singular_name = $obj->labels->singular_name;
										}

										echo "<div class='newsroom-meta'>";


											if ($post->post_type != "event"){ ?>
												<div class="post-meta">
													<h6><?php the_time('F d, Y'); ?></h6>
													<span class="author">By <?php the_author(); ?></span>
												</div><!--/post-meta -->

											<?php } else { ?>
												
												<div class="post-meta event-dates">
													<h6><?php echo get_field('start_date'); ?>
													<?php if (get_field('end_date')){ ?>
													- <?php echo get_field('end_date'); ?>
													<?php } ?>
													</h6>
												</div><!--/post-meta -->
												
											<?php }

											if ( function_exists( 'ADDTOANY_SHARE_SAVE_KIT' ) ) { 
												echo "<div class='share-buttons'>Share This ".$singular_name.": ";
												ADDTOANY_SHARE_SAVE_KIT();
												echo "</div>"; } 

										echo "</div>";
									} ?>


									<?php if ($post->post_type == "location") { ?>
										<?php 

										if (get_field('location_address')){
											echo '<p class="with-label service-provided"><label>Project Location: </label>';
											echo get_field('location_address').", ".get_field('city').", ".get_field('state'); 
											echo '</p>';
										}

										 ?>

									<?php } ?>
									
									<div class="the-content">
										<h3 class="event-location"><?php echo get_field('location'); ?></h3>
										<?php the_content(); ?>
										
										<?php wp_link_pages(); ?>
									</div><!-- the-content -->

									<?php if (get_field('link')){ 
											echo '<a target="_blank" href="'.get_field("link").'">'.get_field("link").'</a>';
									 } ?>

									
									<div class="meta clearfix">
										<?php if (get_the_category_list()) { ?>
											<div class="category"><h6>Category</h6><?php echo get_the_category_list(); ?></div>
										<?php } ?>
										<?php if (get_the_tag_list()) { ?>
											<div class="tags"><h6>Tagged</h6><?php echo get_the_tag_list(); ?></div>
										<?php } ?>
									</div><!-- Meta -->
									
							</article>

						</div>

						

						<?php if (in_array($post->post_type, $news_post)) { ?>

							<section class="sidebar-right">

								<?php include('newsroom_sidebar.php'); ?>

							</section>

						<?php } ?>

						
					</section>
				

				<?php endwhile; ?>


			<?php else : ?>
				
				<article class="post error">
					<h1 class="404">Nothing has been posted like that yet</h1>
				</article>

			<?php endif;  ?>

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

	<?php include ("modules/modules.php"); ?>

</section>
<?php get_footer(); ?>
