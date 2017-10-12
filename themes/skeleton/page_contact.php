<?php
/**
 * Template Name: Contact Us template
 */
 ?>

<?php include ("modules/secondary_menu.php"); ?>

	<section id="main-section" class="main-section">

		<?php get_header(); ?>

		<section id="the-main-content" class="the-main-content">

			<div class="content-container with-sidebar">
				<article class="post">						
					<?php wd_form_maker(1); ?>	
				</article>
			</div><!-- .container -->

			<section class="sidebar-right">
				<div class="padding-4">
					<div class="the-content">
						<?php while ( have_posts() ) : the_post(); ?>
							<?php the_content(); ?>
						<?php endwhile; ?>
								
						<?php wp_link_pages(); ?>
					</div><!-- the-content -->
				</div>

			</section>
		</section>

		<?php include ("modules/modules.php"); ?>

	</section>

<?php get_footer(); ?>