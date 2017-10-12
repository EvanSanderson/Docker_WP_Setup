<?php
/**
 * The template for displaying any single member.
 *
 */
get_header(); ?>

<section id="main-section" class="main-section">

	<div id="primary" class="row-fluid">
		<div id="content" role="main" class="span8 offset2">

			<?php if ( have_posts() ) : ?>

				<?php while ( have_posts() ) : the_post(); ?>


					<section id="the-main-content" class="the-main-content">

						
						
							<article class="post">
								<div class="flex-container">
									<div class="flex-col flex-1-3 flex-padding">
										<img src="<?php echo get_the_post_thumbnail_url();?>"/>
									</div>
									<div class="flex-col flex-2-3 flex-padding">
										<h2><?php the_title(); ?></h2>
										<div class="news-meta">								
											<h6><?php echo get_field('title'); ?></h6>
										</div>
										<div class="the-content">
											<?php the_content(); ?>
											
											<?php wp_link_pages(); ?>
										</div><!-- the-content -->

										<div class="meta clearfix">
											<?php if (get_the_category_list()) { ?>
												<div class="category"><h6>Category</h6><?php echo get_the_category_list(); ?></div>
											<?php } ?>
											<?php if (get_the_tag_list()) { ?>
												<div class="tags">Tagged<?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
											<?php } ?>
										</div><!-- Meta -->
									</div>
								</div>	
							</article>

						
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
