<?php
/**
 *  Template Name: Newsroom
 *
 */

get_header(); ?>

<?php include ("modules/secondary_menu.php"); ?>

<?php 

$newsArgs = array(
  'post_type'           => 'news',
  'posts_per_page'      => 5,
);
$news = new WP_Query($newsArgs);

?>

<section id="main-section" class="main-section">
<?php $news_post=array("news","post","in_the_news","awards","events"); ?>

	<div id="primary" class="row-fluid">
		<div id="content" role="main" class="span8 offset2">

			<!-- The News Releases Section -->

			<section id="the-main-content" class="the-main-content">

				<div class="content-container with-sidebar">
						
					<div class="flex-container news-releases">

						<?php $i=0; while ( $news->have_posts() ) : $news->the_post(); $i++;  $arrow=""; ?>

							<div class="flex-col flex-1-2 news-item">
							
								<?php if (get_the_post_thumbnail_url()) { $arrow = "arrow-top"; ?>
									<div class="item-thumb" style="background:url('<?php print get_the_post_thumbnail_url(); ?>') no-repeat center center;background-size:cover;">
										<?php //the_post_thumbnail() ?>
									</div>
								<?php } ?>

								<div class="news-teaser <?php echo $arrow; ?>">

									<?php $type = get_post_type_object( $post->post_type ); ?>
									
									<div class="news-meta">
										
										<span class="news-type"><?php echo $type->labels->singular_name; ?></span>
										<span class="news-date"><?php the_time('F d, Y'); ?></span>
									</div>

								    <?php the_title( '<h3 class="entry-title"><a href="' . get_permalink() . '" title="' . the_title_attribute( 'echo=0' ) . '">', '</a></h3>' ); ?>

								    <div class="entry-content">
								        <?php if ($i==1) echo wp_trim_words(get_the_excerpt(), 50); else echo wp_trim_words(get_the_excerpt(), 20); ?>
								    </div>
								</div>

								<a class="learn-more with-arrow" href="<?php print get_permalink(); ?>">Read More</a>
							</div>

						<?php endwhile; ?>
						
						<a class="view-all with-arrow" href="/newsroom/news-releases/">View All</a>			
					
					</div>

					

				</div>

						
				<section class="sidebar-right">
					<?php include('newsroom_sidebar.php'); ?>
				</section>

						
			</section>

<?php wp_reset_query(); ?>

<?php if ( have_posts() ) : ?>
	<?php while ( have_posts() ) : the_post(); 
	
		include ("modules/modules.php");

	endwhile;

endif; ?>

				

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->
</section>
<?php get_footer(); ?>
