<?php if( have_rows('module') ): 

		while( have_rows('module') ): the_row(); 

			$type = get_sub_field('module_type');

			if ($type == "secondary_menu"){ ?>
				<section id="secondary-nav" class="secondary-menu">
					<div class="flex-container center-aligned flex-padding">
						<?php if( have_rows('menu_item') ):

							while ( have_rows('menu_item') ) : the_row();

								echo '<div class="flex-col">';
									echo '<a href="#'.get_sub_field('module_id').'">'.get_sub_field('menu_item_name').'</a>';
								echo '</div>';

							endwhile;
						endif; ?>
					</div>
				</section>

			<?php } ?>

		<?php endwhile;

endif; ?>