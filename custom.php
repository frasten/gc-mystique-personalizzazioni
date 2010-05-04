<?php
/*
Plugin Name: Mystique - Personalizzazioni
Plugin URI: http://polpoinodroidi.com/
Description: Personalizzazioni per Mystique
Version: 0.1
Author: Frasten
Author URI: http://polpoinodroidi.com
License: GPL3
*/


function mystique_stili_personalizzati() {
	wp_enqueue_style( 'my-mystique', plugins_url('styles.css?', __FILE__) );
}

add_action( 'template_redirect', 'mystique_stili_personalizzati' );

?>
