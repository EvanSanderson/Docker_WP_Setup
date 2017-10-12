<?php get_header(); ?>

<?php include ("modules/secondary_menu.php"); ?>

<section id="main-section" class="main-section">
	<!-- Page Content Area -->
	<?php if ( have_posts() ) : ?>
		<?php while ( have_posts() ) : the_post(); ?>
			<?php if (get_the_content()){
				$class="";
				$children = get_pages( array( 'child_of' => $post->ID ) );
				if (( $post->post_parent )||(count( $children ) > 0)) { $class="with-sidebar"; } ?>

				<section id="the-main-content" class="the-main-content">

					<div class="content-container <?php print $class; ?>">
						<article class="post">
												
							<div class="the-content">
								<?php the_content(); ?>
								
								<?php wp_link_pages(); ?>
							</div><!-- the-content -->
							
							<div class="meta clearfix">
								<div class="category"><?php echo get_the_category_list(); ?></div>
								<div class="tags"><?php echo get_the_tag_list( '| &nbsp;', '&nbsp;' ); ?></div>
							</div><!-- Meta -->
							
						</article>
					</div><!-- .container -->

					<?php if ( $post->post_parent ) { ?>

						<section class="sidebar-right">
							<div class="padding-4">
							<?php	echo '<h6>'; echo get_post($post->post_parent)->post_title; echo '</h6>';
								wp_list_pages(array(
								    'child_of' => $post->post_parent,
								    'title_li' => "",
								    'depth' => 1 ,
							)); ?>
							</div>

						</section>

					<?php } else { ?>

						<?php if ( count( $children ) > 0) { ?>

							<section class="sidebar-right">
								<div class="padding-4">
								<?php	echo '<h6>'; echo the_title(); echo '</h6>';
									wp_list_pages(array(
									    'child_of' => $post->ID,
									    'title_li' => "",
									    'depth' => 1 ,
								)); ?>
								</div>

							</section>

						<?php } ?>

					<?php } ?>

				</section><!-- #main-content .content-area -->
			<?php  } ?>

		<?php endwhile; ?>

	<?php endif;  ?>


	<!-- Page Modules -->
	<?php include ("modules/modules.php"); ?>
</section>

<?php get_footer(); ?>
