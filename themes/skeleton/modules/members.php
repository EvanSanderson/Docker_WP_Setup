<section id="module-<?php echo $i; ?>" class="news-module members-module">
	<div class="max-width flex-padding">

		<div class="news-module-header">
					
			<h2><?php echo get_sub_field('member_module_title'); ?></h2>
			<a class="view-all with-arrow" href="<?php echo get_sub_field('view_all_link'); ?>">View All</a>

		</div>
					
		<div class="flex-container news-posts">

			<?php 

			$members = get_sub_field('members');

			if( $members ): ?>
			    <?php foreach( $members as $post): // variable must be called $post (IMPORTANT) ?>
			        <?php setup_postdata($post); ?>
			        <?php include('member_item.php'); ?>
			    <?php endforeach; ?>
			    </ul>
			    <?php wp_reset_postdata(); // IMPORTANT - reset the $post object so the rest of the page works correctly ?>
			<?php endif; ?>
										
		</div>
	</div>
</section>
<?php wp_reset_query(); ?>