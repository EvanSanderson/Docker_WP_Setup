<?php if( have_rows('module') ): $i=0;

		while( have_rows('module') ): the_row(); 

			$type = get_sub_field('module_type');

			if (($type != "hero")&&($type != "secondary_menu")){
				$i++;
				include ($type.'.php');


			}

		endwhile;

endif; ?>