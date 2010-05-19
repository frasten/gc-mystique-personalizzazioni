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
		else if ( $tipo == 'allevatore' )
			$menu_slug = $instance['menu_allevatori'];
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
		  'menu_allevatori' => '',
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

<?php
	}



	/* Funzione di salvataggio */
	function update( $new_instance, $old_instance ) {
		$instance = $old_instance;

		/* Strip tags (se necessario) e modifica la configurazione del widget. */
		$instance['title'] = strip_tags( $new_instance['title'] );

		$instance['menu_generale'] = $new_instance['menu_generale'];
		$instance['menu_allevatori'] = $new_instance['menu_allevatori'];
		$instance['menu_pastori'] = $new_instance['menu_pastori'];
		$instance['menu_turisti'] = $new_instance['menu_turisti'];
		return $instance;
	}
}
endif; /* Fine classe */




add_action( 'widgets_init', create_function( '', 'return register_widget( "GrandiCarnivori_FAQ" );' ) );

?>
