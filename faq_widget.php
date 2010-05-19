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
		echo "QUA CI VANNO LE DOMANDE, a seconda dell'utente.";

		$tipo = isset($_SESSION['tipologia_utente']) ? $_SESSION['tipologia_utente'] : false;
		$menu_slug = '';
		if ( $tipo == 'pastore' )
			$menu_slug = $instance['menu_pastori'];
		else if ( $tipo == 'cacciatore' )
			$menu_slug = $instance['menu_cacciatori'];
		else if ( $tipo == 'turista' )
			$menu_slug = $instance['menu_turisti'];
		else
			$menu_slug = $instance['menu_generale'];

		$nav_menu = wp_get_nav_menu_object( $menu_slug );
		if ( !$nav_menu ) {
			echo "Menu non trovato";
			return;
		}
		wp_nav_menu( array( 'menu' => $nav_menu ) );


		/* After widget (definito dal tema). */
		echo $after_widget;
	}





	/* Form  per la configurazione del widget */
	function form( $instance ) {
		/* Impostazioni di default del widget */
		$defaults = array(
		  'title' => '',
		  'menu_generale' => '',
		  'menu_pastori' => '',
		  'menu_cacciatori' => '',
		  'menu_turisti' => '',
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

		<!-- FAQ Pastori -->
		<p>
			<label for="<?php echo $this->get_field_id( 'menu_pastori' ); ?>">Menu per le domande per i pastori:</label><br />
			<select id="<?php echo $this->get_field_id( 'menu_pastori' ); ?>" name="<?php echo $this->get_field_name( 'menu_pastori' ); ?>">
			<?php
			foreach(wp_get_nav_menus() as $menu)
				echo '<option value="'.$menu->slug.'" '.selected($menu->slug, $instance['menu_pastori'], false).'>'.$menu->name.'</option>';
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



<!-- ID pagine tipologie utenti -->
		<p>
			<label for="<?php echo $this->get_field_id( 'id_pagine_tipologie' ); ?>">ID delle pagine per <strong>pastori, cacciatori, turisti</strong>. Separati da virgola.</label><br />
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
		$instance['menu_pastori'] = $new_instance['menu_pastori'];
		$instance['menu_turisti'] = $new_instance['menu_turisti'];


		$instance['id_pagine_tipologie'] = preg_replace('/[^0-9,]/', '', $new_instance['id_pagine_tipologie']);
		update_option('gc_id_pagine_tipologie', $instance['id_pagine_tipologie']);

		return $instance;
	}
}
endif; /* Fine classe */




add_action( 'widgets_init', create_function( '', 'return register_widget( "GrandiCarnivori_FAQ" );' ) );

?>
