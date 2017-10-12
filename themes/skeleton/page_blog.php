<?php
/**
 *  Template Name: Blog Page
 *
 */

get_header(); ?>

<?php include ("modules/secondary_menu.php"); ?>

<?php 

$newsArgs = array(
  'post_type'           => 'post',
  'posts_per_page'      => 10,
  'paged' => $paged,
);
$news = new WP_Query($newsArgs);

?>
<section id="main-section" class="main-section">
	<div id="primary" class="row-fluid">
		<div id="content" role="main" class="span8 offset2">

			<!-- The News Releases Section -->

			<section id="the-main-content" class="the-main-content">

				<div class="content-container with-sidebar">
						
					<div class="flex-container news-releases">

						<?php $i=0; while ( $news->have_posts() ) : $news->the_post(); $i++;  $arrow=""; ?>

							<div class="flex-col news-item full-width">
								<?php include ('modules/news_horizontal.php'); ?>
							</div>
						<?php endwhile; ?>
						
					
					</div>

					<div class="pager">

						<div class="previous-page"><?php previous_posts_link('Newer', $news->max_num_pages );?></div>
						<div class="next-page"><?php next_posts_link( 'Older', $news->max_num_pages ); ?></div>

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
