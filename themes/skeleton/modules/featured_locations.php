<section id="module-<?php echo $i; ?>" class="news-module featured-locations">
	<div class="news-posts max-width flex-padding">
		<h2 class="locations-header"><?php echo get_sub_field('locations_module_title'); ?></h2>
			
		<div class="flex-container">
						
			<?php 

			$locations = get_sub_field('locations');

			if( $locations ): ?>
			    <?php foreach( $locations as $post): $arrow=""; // variable must be called $post (IMPORTANT) ?>
			    	<div class="flex-col flex-1-3 news-item">							
				        <?php setup_postdata($post); ?>
				        <?php include('location_item.php'); ?>
			        </div>
			    <?php endforeach; ?>
			    </ul>
			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
										
		</div>
	</div>

</section>
<?php wp_reset_query(); ?>