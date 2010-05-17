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
	wp_enqueue_style( 'my-mystique', GRANDICARNIVORI_PLUGIN_URL . '/styles.css?' );
}


function mystique_custom_nav_icons($nav_extra)
{
	// N.B. le icone compaiono in ordine inverso rispetto a quanto imposto qui.

	$nav_extra = '<a href="'.get_bloginfo('rss2_url').'" class="nav-extra rss" title="RSS Feeds"><span>RSS Feeds</span></a>';
	//$nav_extra .= '<a href="http://www.twitter.com/phil_pendlebury" class="nav-extra twitter" title="Twitter"><span>Twitter</span></a>';
	//$nav_extra .= '<a href="http://www.myspace.com/philpendlebury" class="nav-extra myspace" title="MySpace"><span>MySpace</span></a>';
	//$nav_extra .= '<a href="http://uk.linkedin.com/in/pendlebury" class="nav-extra linkedin" title="LinkedIn"><span>LinkedIn</span></a>';
	$nav_extra .= '<a href="http://www.facebook.com/apps/application.php?id=116144165091435" class="nav-extra facebook" title="Seguici su Facebook"><span>Seguici su Facebook</span></a>';
	//$nav_extra .= '<a href="http://gwfts.blogspot.com/" class="nav-extra blogger" title="Google Wave Blog"><span>Google Wave Blog</span></a>';
	$nav_extra .= '<a href="http://www.youtube.com/TODO" class="nav-extra youtube" title="Canale YouTube"><span>Canale YouTube</span></a>';
	$nav_extra .= '<a href="contatti" class="nav-extra email" title="Contatti"><span>Contatti</span></a>';
	//$nav_extra .= '<a href="http://www.google.com/profiles/frasten" class="nav-extra googlebuzz" title="Frasten @ Google Buzz"><span>Frasten @ Google Buzz</span></a>';
	//$nav_extra .= '<a href="https://wave.google.com/wave/?pli=1#restored:wave:googlewave.com!w%252Bupyy5rPyA" class="nav-extra googlewave" title="Google Wave"><span>Google Wave</span></a>';

	return $nav_extra;
}


function mystique_imposta_facebook($content) {
	if ( ! function_exists('get_sfc_like_button') ) return $content;

	// is_page() is_home() is_feed() is_single()
	if (/*is_single() || */is_page() ) return $content;

	$button = get_sfc_like_button('show_faces=false&layout=button_count');
	$content = $content . $button;
	return $content;
}


function grandicarnivori_partners_top() {
	$img_path = GRANDICARNIVORI_PLUGIN_URL . '/img/partners';
	$output = <<<EOF
	<div id="partners_top">
		QUI CI SARA' UNO SFONDO BIANCO
		<span>Un progetto di:</span>
		<a href='http://www.cmvallecamonica.bs.it' title="Comunità Montana ValleCamonica" class="partner"><img src="$img_path/comunitamontana.jpg"/></a>
		<a href='http://www.legambiente.org' title="Legambiente Lombardia" class="partner"><img src="$img_path/legambiente.jpg"/></a>
	</div><!-- /partners_top -->
EOF;

/*

<div id="barra_bottom">
	<div id="wrapper_partners">
		
		<div id="partners_right">
			<span>Grazie al contributo di:</span>
			<a href='http://www.fondazionecariplo.it' title="Fondazione Cariplo" class="partner"><img src="$img_path/cariplo.jpg"/></a>
			<a href='http://www.comune.paspardo.bs.it' title="Comune di Paspardo" class="partner"><img src="$img_path/paspardo.jpg"/></a>
		</div><!-- /partners_right  -->
	</div><!-- /wrapper_partners -->
</div><!-- /barra_bottom -->
*/
	echo $output;
}

// Elimino il logo sopra.
function grandicarnivori_logo() {
	return 'QUI CI SARA\' IL LOGO';
}


/* Costante per l'url, in modo da funzionare sia in locale che in remoto
 * (in locale ho un link simbolico */
if ( ! defined('GRANDICARNIVORI_PLUGIN_URL') ) {
	$dir = basename(dirname(__FILE__));
	define( 'GRANDICARNIVORI_PLUGIN_URL', WP_PLUGIN_URL . "/$dir");
}

add_action( 'template_redirect', 'mystique_stili_personalizzati' );

// 20 perche' voglio essere alla fine per resettargli le impostazioni.
add_action('mystique_navigation_extra', 'mystique_custom_nav_icons', 20);

add_filter('the_content', 'mystique_imposta_facebook');

add_action('grandicarnivori_header', 'grandicarnivori_partners_top');

add_filter('mystique_logo', 'grandicarnivori_logo');
?>
