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


function mystique_custom_nav_icons($nav_extra)
{
	// N.B. le icone compaiono in ordine inverso rispetto a quanto imposto qui.

	$nav_extra = '<a href="'.get_bloginfo('rss2_url').'" class="nav-extra rss" title="RSS Feeds"><span>RSS Feeds</span></a>';
	//$nav_extra .= '<a href="http://www.twitter.com/phil_pendlebury" class="nav-extra twitter" title="Twitter"><span>Twitter</span></a>';
	//$nav_extra .= '<a href="http://www.myspace.com/philpendlebury" class="nav-extra myspace" title="MySpace"><span>MySpace</span></a>';
	//$nav_extra .= '<a href="http://uk.linkedin.com/in/pendlebury" class="nav-extra linkedin" title="LinkedIn"><span>LinkedIn</span></a>';
	$nav_extra .= '<a href="http://www.facebook.com/TODO" class="nav-extra facebook" title="Seguici su Facebook"><span>Seguici su Facebook</span></a>';
	//$nav_extra .= '<a href="http://gwfts.blogspot.com/" class="nav-extra blogger" title="Google Wave Blog"><span>Google Wave Blog</span></a>';
	$nav_extra .= '<a href="http://www.youtube.com/TODO" class="nav-extra youtube" title="Canale YouTube"><span>Canale YouTube</span></a>';
	$nav_extra .= '<a href="contatti" class="nav-extra email" title="Contact"><span>Contact</span></a>';
	//$nav_extra .= '<a href="http://www.google.com/profiles/frasten" class="nav-extra googlebuzz" title="Frasten @ Google Buzz"><span>Frasten @ Google Buzz</span></a>';
	//$nav_extra .= '<a href="https://wave.google.com/wave/?pli=1#restored:wave:googlewave.com!w%252Bupyy5rPyA" class="nav-extra googlewave" title="Google Wave"><span>Google Wave</span></a>';

	return $nav_extra;
}



add_action( 'template_redirect', 'mystique_stili_personalizzati' );

// 20 perche' voglio essere alla fine per resettargli le impostazioni.
add_action('mystique_navigation_extra', 'mystique_custom_nav_icons', 20);

?>
