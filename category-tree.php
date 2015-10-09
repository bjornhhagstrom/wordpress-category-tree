<?php
	// if is category
	if(is_category()){

		$this_term_id = get_query_var('cat');
		$this_term = get_category($this_term_id);

		// if category has parent
		if ($this_term->category_parent > 0){
			$category_parent_id = $this_term->category_parent;
			$category_parent = get_category($category_parent_id);

			// if category has grandparent
			if ($category_parent->category_parent > 0){
				$category_grandparent_id = $category_parent->category_parent;
				$category_grandparent = get_category($category_grandparent_id);

				// if category has greatgrandparent
				if ($category_grandparent->category_parent > 0){
					$category_greatgrandparent_id = $category_grandparent->category_parent;
					$category_greatgrandparent = get_category($category_grandparent_id);
					$top_level_term = $category_greatgrandparent_id;
				} else {
					$top_level_term = $category_grandparent_id;
				}

			// else use parent
			} else {
				$top_level_term = $category_parent_id;
			}

		// else if no parent, use this term
		} else {
			$top_level_term = $this_term_id;
		}

		echo '<ul class="category-list no-bullet">';
			echo '<li>';
			echo '<a href="' . esc_url( get_category_link( $top_level_term ) ) . '">';
			echo get_cat_name($top_level_term);
			echo '</a>';

			$sub_level_args = array(
				'orderby' => 'term_order',
				'hide_empty' => false,
				'parent' => $top_level_term
			);
			$sub_level_terms = get_terms( 'category', $sub_level_args );
			if ( ! empty( $sub_level_terms ) && ! is_wp_error( $sub_level_terms ) ){
				echo '<ul class="sub-category-list">';
				foreach ( $sub_level_terms as $sub_level_term ) {

					echo '<li>';
					echo '<a href="' . esc_url( get_category_link( $sub_level_term->term_id ) ) . '">';
					echo $sub_level_term->name;
					echo '</a>';

					$sub_sub_level_args = array(
						'orderby' => 'term_order',
						'hide_empty' => false,
						'parent' => $sub_level_term->term_id
					);
					$sub_sub_level_terms = get_terms( 'category', $sub_sub_level_args );
					if ( ! empty( $sub_sub_level_terms ) && ! is_wp_error( $sub_sub_level_terms ) ){
						echo '<ul class="sub-sub-category-list">';
						foreach ( $sub_sub_level_terms as $sub_sub_level_term ) {
							echo '<li>';
							echo '<a href="' . esc_url( get_category_link( $sub_sub_level_term->term_id ) ) . '">';
							echo $sub_sub_level_term->name;
							echo '</a>';

							$sub_sub_sub_level_args = array(
								'orderby' => 'term_order',
								'hide_empty' => false,
								'parent' => $sub_sub_level_term->term_id
							);
							$sub_sub_sub_level_terms = get_terms( 'category', $sub_sub_sub_level_args );
							if ( ! empty( $sub_sub_sub_level_terms ) && ! is_wp_error( $sub_sub_sub_level_terms ) ){
								echo '<ul class="sub-sub-sub-category-list">';
								foreach ( $sub_sub_sub_level_terms as $sub_sub_sub_level_term ) {
									echo '<li>';
									echo '<a href="' . esc_url( get_category_link( $sub_sub_sub_level_term->term_id ) ) . '">';
									echo $sub_sub_sub_level_term->name;
									echo '</a>';
									echo '</li>'; // end sub sub sub level category
								}
								echo '</ul>'; // end sub sub sub level category list
							}

							echo '</li>'; // end sub sub level category
						}
						echo '</ul>'; // end sub sub level category list
					}

					echo '</li>'; // end sub level category

				}
				echo '</ul>'; // end sub level category list
			}
			echo '</li>'; // end top level category
		echo '</ul>'; // end top level category list
	} // end if is category
	?>
