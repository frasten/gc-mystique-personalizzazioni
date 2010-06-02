<?php


/* La class del widget */
if (! class_exists('GrandiCarnivori_FAQ') ):
class GrandiCarnivori_FAQ extends WP_Widget {

	/* Costruttore */
	function GrandiCarnivori_FAQ() {
		$widget_ops = array( 'classname' => 'gc-faq', 'description' => 'Permette di inserire le FAQ nella barra laterale a seconda della tipologia di utente.' );
		$control_ops = array( 'width' => 300, 'height' => 350, 'id_base' => 'gc-faq' );
		$this->WP_Widget( 'gc-faq', 'Domande Frequenti', $widget_ops, $control_ops );
	}




/* Mostro il widget vero e proprio */
function widget( $args, $instance ) {
		extract( $args );

		/* User-selected settings. */
		$title = apply_filters('widget_title', $instance['title'] );

		/* Before widget (definito dal tema). */
		echo $before_widget;

		/* Titolo del widget (before e after definiti dal tema). */
		if ( $title )
			echo $before_title . $title . $after_title;

		$opt = get_option('gc_id_pagine_tipologie');
		$ids = explode(',', $opt);


		$menu_slug = $instance['menu_generale'];
		if ( is_page() ) {
			/* Scelgo la lista di domande da mostrare, a seconda di dove mi trovo.*/
			if ($ids[0] && $this->figlio_di($ids[0])) // allevatori
				$menu_slug = $instance['menu_allevatori'];
			else if ($ids[1] && $this->figlio_di($ids[1])) // cacciatori
				$menu_slug = $instance['menu_cacciatori'];
			else if ($ids[2] && $this->figlio_di($ids[2])) // turisti
				$menu_slug = $instance['menu_turisti'];
			else if ($ids[3] && $this->figlio_di($ids[3])) // centro recupero fauna selvatica
				$menu_slug = $instance['menu_recupero'];
		}

		$nav_menu = wp_get_nav_menu_object( $menu_slug );
		if ( !$nav_menu ) {
			echo "Menu non trovato";
			return;
		}
		$menu_items = wp_get_nav_menu_items($nav_menu->term_id);
		echo "<ul>\n";
		foreach ($menu_items as $item) {
			echo "<li class='clear-block'>\n";
			mystique_post_thumb( 'post-thumbnail', $item->object_id );
			echo "<div" . (!empty( $item->description ) ? ' class="margine-sx" ' : '') .">\n";
			echo "<a href='" . esc_attr($item->url) . "'>" . esc_html($item->title) . "</a><br/>\n";
			if ( ! empty( $item->description ) ) {
				echo "<em>" . esc_html( $item->description ) . "</em>\n";
			}
			echo "</div>";
			echo "</li>\n";
		}
		echo "</ul>\n";
		//wp_nav_menu( array( 'menu' => $nav_menu ) );

		/* After widget (definito dal tema). */
		echo $after_widget;
	}


	/* Funzione ricorsiva per scoprire se una pagina e' figlia di un'altra.*/
	function figlio_di($id_cercato, $id = 0) {
		global $post;
		if ($id == 0) $id = $post->ID; // prima chiamata
		if ($id_cercato == $id) return true;

		$id_parent = $this->get_parent( $id );
		if ($id_parent == 0) return false;
		if ($id_parent == $id_cercato) return true;
		return $this->figlio_di($id_cercato, $id_parent);
	}


	function get_parent($id) {
		global $wpdb;
		if ($id == 0) return 0;

		$parent = $wpdb->get_row( $wpdb->prepare( "SELECT post_parent FROM $wpdb->posts WHERE ID = %d AND post_type = 'page' LIMIT 1", $id ) );
		if ( is_numeric( $parent->post_parent ) ) {
			return (int) $parent->post_parent;
		}
		else
			return 0;
	}


	/* Form  per la configurazione del widget */
	function form( $instance ) {
		/* Impostazioni di default del widget */
		$defaults = array(
		  'title' => '',
		  'menu_generale' => '',
		  'menu_allevatori' => '',
		  'menu_cacciatori' => '',
		  'menu_turisti' => '',
		  'menu_recupero' => '',
		);
		$instance = wp_parse_args( (array) $instance, $defaults );

		?>
		<p>
			<label for="<?php echo $this->get_field_id( 'title' ); ?>">Titolo:</label>
			<input id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo $instance['title']; ?>" style="width:100%;" />
		</p>

		<!-- FAQ Generali -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_generale' ); ?>">Menu per le domande generali:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_generale' ); ?>" name="<?php echo $this->get_field_name( 'menu_generale' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_generale'], false).'>'.$menu->name.'</option>';
			?>
			</select>
		</p>

		<!-- FAQ Allevatori -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_allevatori' ); ?>">Menu per le domande per gli allevatori:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_allevatori' ); ?>" name="<?php echo $this->get_field_name( 'menu_allevatori' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_allevatori'], false).'>'.$menu->name.'</option>';
			?>
			</select>
		</p>


		<!-- FAQ Cacciatori -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_cacciatori' ); ?>">Menu per le domande per gli cacciatori:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_cacciatori' ); ?>" name="<?php echo $this->get_field_name( 'menu_cacciatori' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_cacciatori'], false).'>'.$menu->name.'</option>';
			?>
			</select>
		</p>


		<!-- FAQ Turisti -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_turisti' ); ?>">Menu per le domande per i turisti:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_turisti' ); ?>" name="<?php echo $this->get_field_name( 'menu_turisti' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_turisti'], false).'>'.$menu->name.'</option>';
			?>
			</select>
		</p>


		<!-- FAQ Recupero -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_recupero' ); ?>">Menu per le domande per il recupero animali selvatici:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_recupero' ); ?>" name="<?php echo $this->get_field_name( 'menu_recupero' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_recupero'], false).'>'.$menu->name.'</option>';
			?>
			</select>
		</p>



<!-- ID pagine tipologie utenti -->
		<p>
			<label for="<?php echo $this->get_field_id( 'id_pagine_tipologie' ); ?>">ID delle pagine per <strong>allevatori, cacciatori, turisti, recupero</strong>. Separati da virgola.</label><br />
			<input type="text" id="<?php echo $this->get_field_id( 'id_pagine_tipologie' ); ?>" name="<?php echo $this->get_field_name( 'id_pagine_tipologie' ); ?>" value="<?php echo $instance['id_pagine_tipologie']?>">
		</p>
<?php
	}



	/* Funzione di salvataggio */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (se necessario) e modifica la configurazione del widget. */
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['menu_generale'] = $new_instance['menu_generale'];
		$instance['menu_cacciatori'] = $new_instance['menu_cacciatori'];
		$instance['menu_allevatori'] = $new_instance['menu_allevatori'];
		$instance['menu_turisti'] = $new_instance['menu_turisti'];
		$instance['menu_recupero'] = $new_instance['menu_recupero'];


		$instance['id_pagine_tipologie'] = preg_replace('/[^0-9,]/', '', $new_instance['id_pagine_tipologie']);
		update_option('gc_id_pagine_tipologie', $instance['id_pagine_tipologie']);

		return $instance;
	}
}
endif; /* Fine classe */




add_action( 'widgets_init', create_function( '', 'return register_widget( "GrandiCarnivori_FAQ" );' ) );

?>
