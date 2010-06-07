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

include 'faq_widget.php';
include 'tinymce/invii.php';
define('GC_VERSIONE', '1.0');

function grandicarnivori_init() {
	$config = get_option('mystique');
	$config['logo'] = GRANDICARNIVORI_PLUGIN_URL . '/img/logo.png';
	update_option('mystique', $config);
}


function mystique_stili_personalizzati() {
	wp_enqueue_style( 'my-mystique', GRANDICARNIVORI_PLUGIN_URL . '/styles.css?' . GC_VERSIONE );
}

function grandicarnivori_ie_di_merda() {
	$ie6_css = GRANDICARNIVORI_PLUGIN_URL . '/ie6.css';
	$ie7_css = GRANDICARNIVORI_PLUGIN_URL . '/ie7.css';
	echo <<<EOF
	<!--[if IE 6]>
	<link rel="stylesheet" type="text/css" href="$ie6_css" />
	<![endif]-->
	<!--[if IE 7]>
	<link rel="stylesheet" type="text/css" href="$ie7_css" />
	<![endif]-->
EOF;
}

function grandicarnivori_slimbox() {
	$img_dir = GRANDICARNIVORI_PLUGIN_URL . '/img/lightbox';
	echo <<<EOF
	<script type="text/javascript">
	/* <![CDATA[ */
	slimbox2_options.prev = "$img_dir/prevlabel.gif";
	slimbox2_options.next = "$img_dir/nextlabel.gif";
	slimbox2_options.close = "$img_dir/closelabel.gif";
	/* ]]> */
	</script>
EOF;
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
	//$nav_extra .= '<a href="http://www.youtube.com/TODO" class="nav-extra youtube" title="Canale YouTube"><span>Canale YouTube</span></a>';
	$nav_extra .= '<a href="'. get_bloginfo('url') .'/contatti" class="nav-extra email" title="Contatti"><span>Contatti</span></a>';
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
		<span>Un progetto di:</span>
		<a href='http://www.cmvallecamonica.bs.it' title="Comunità Montana ValleCamonica" class="partner"><img src="$img_path/comunitamontana.jpg" alt="Comunità Montana ValleCamonica"/></a>
		<a href='http://www.legambiente.org' title="Legambiente Lombardia" class="partner"><img src="$img_path/legambiente.jpg" alt="Legambiente"/></a>
	</div><!-- /partners_top -->
EOF;

	echo $output;
}

// Elimino il logo sopra.
function grandicarnivori_logo($logo) {/*
	$out = "<a href=''>";
	$out .= '<img src="' . GRANDICARNIVORI_PLUGIN_URL . '/img/logo.png" style="vertical-align: middle">';
	$out .= "</a>\n";
	$out .= "<br/>^-- Poi sarà centrato giusto, e con sfondo bianco sfumato.";*/
	//$out .= "<span class='clear-block'>Potrebbe andar bene come proposta di logo?</span>";

	return $logo . $out;
}

// Links alle immagini dei partners, nella sidebar.
function grandicarnivori_partners_widget() {
	$img_path = GRANDICARNIVORI_PLUGIN_URL . '/img/partners';
	$output = <<<EOF
	<div id="partners_widget">
		<span>Progetto realizzato grazie al contributo di:</span>
		<a href='http://www.fondazionecariplo.it' title="Fondazione Cariplo" class="partner"><img src="$img_path/cariplo.jpg" alt="Fondazione Cariplo"/></a><br />
			<a href='http://www.comune.paspardo.bs.it' title="Comune di Paspardo" class="partner"><img src="$img_path/paspardo.jpg" alt="Comune di Paspardo"/> Comune di Paspardo</a>
	</div><!-- /partners_widget -->
EOF;
	return $output;
}


function gc_favicon() {
	echo GRANDICARNIVORI_PLUGIN_URL . '/img/favicon.png';
}

function grandicarnivori_copyright() {
	$anni = "2010";
	$anno_corrente = date('Y');
	if ($anno_corrente != $anni) $anni .= "-$anno_corrente";
	$testo = '<span class="copyright-footer">';
	$testo .= "&copy; $anni ";
	$testo .= "Legambiente Lombardia Onlus - Tel. 02.87.38.64.80 - ";
	$testo .= "E mail: <a href='mailto:info@grandicarnivori.it'>info@grandicarnivori.it</a> - ";
	$testo .= "<a href='mailto:lombardia@legambiente.org'>lombardia@legambiente.org</a> - ";
	$testo .= "<a href='http://www.legambiente.org'>www.legambiente.org</a>";
	$testo .= '</span>';
	return $testo;
}

function grandicarnivori_banner() {
	$banner = array();
	// Url, Immagine, Testo
	$banner[] = array('http://www.cbd.int/2010/welcome', 'biodiversita.gif', 'Anno internazionale della biodiversit&agrave;');
	$banner[] = array('http://www.legambiente.eu/documenti/2010/0326_5x1000/index.php', 'cinquexmille.gif', '5 x 1000 a Legambiente');
	$banner[] = array('http://www.iucn.org', 'iucn.gif', 'IUCN');

	$out =  "<ul id='banners'>\n";
	foreach ($banner as $ban) {
		$out .= "<li>\n";
		$img_path = GRANDICARNIVORI_PLUGIN_URL . '/img/banner/' . $ban[1];
		$desc = esc_attr($ban[2]);
		$out .= "<a href='{$ban[0]}' title='$desc'><img src='$img_path' alt='$desc' /></a>\n";
		$out .= "</li>\n";
	}
	$out .= "</ul>";
	return $out;
}

/* Questa funzione permette di inserire lo shortcode gc_mostrafigli
 * per mostrare le pagine figlia nella pagina madre.
 * (es. Clicco su Lupo e mi mostra l'albero dei figli)
 *
 * Nota: se una voce appare piu' volte nel menu, mostro l'albero della
 * prima ricorrenza. */
function grandicarnivori_mostrafigli() {
	global $post;
	// Prendo l'id del menu superiore dalle impostazioni di mystique
	$navtype = get_mystique_option('navigation');
	$menu = wp_get_nav_menu_object(substr($navtype, 5));
	$menu_items = wp_get_nav_menu_items($menu->term_id);
	$sorted_menu_items = array();
	foreach ((array) $menu_items as $key => $menu_item) $sorted_menu_items[$menu_item->menu_order] = wp_setup_nav_menu_item($menu_item);

	/* Scorro rapidamente tutti gli elementi del menu, per vedere se io
	 * sono un parent di menu, ed in caso ne prendo l'id. */
	$id_nel_menu = 0;
	foreach ($sorted_menu_items as $item) {
		// Scarto i figli
		if ($item->menu_item_parent != 0) continue;
		// Se la pagina corrente e' un parent di menu:
		if ($item->object_id == $post->ID) {
			$id_nel_menu = $item->ID;
			break;
		}
	}
	// Se non l'ho trovato, esco.
	if ($id_nel_menu <= 0) return;

	// Ora riscorro un'altra volta, cercando i figli.
	// NOTA: per ora sto codice prende solo i figli DIRETTI, non i "nipoti"
	$out = "<p>Pagine in questa sezione:</p>";
	$out .= "<ul>";
	foreach ($sorted_menu_items as $item) {
		// Scarto i figli di altri
		if ($item->menu_item_parent != $id_nel_menu) continue;
		$out .= "<li>";
		$out .= "<a href='{$item->url}'>" . esc_html($item->title) . "</a>";
		$out .= "</li>";
	}
	$out .= "</ul>";
	return $out;
}


function stampa_immagini_utenza() {
	global $wp_query;
	// Lo stampo prima del primo post sulla home
	if(is_home() && !is_paged() && ($wp_query->current_post)==0) {
		$links = array(
			array(
				'img' => 'allevatori.jpg',
				'id' => '272',
				'testo' => 'Sono un allevatore',
			),
			array(
				'img' => 'cacciatori.jpg',
				'id' => '281',
				'testo' => 'Sono un cacciatore',
			),
			array(
				'img' => 'turisti.jpg',
				'id' => '283',
				'testo' => 'Sono un turista',
			),
		);
		echo "<div id='linkutenza' class='clear-block'>";
		foreach ($links as $l) {
			$url = get_permalink( $l['id'] );
			if (! $url) continue;
			$img_path = GRANDICARNIVORI_PLUGIN_URL . "/img/utenti/{$l['img']}";
			echo "<div class='utenza'><a href='$url'><img src='$img_path' alt='" . esc_attr($l['testo']) . "' width='150' height='150' /><br />" .esc_html($l['testo']). "</a></div>";
		}
		echo "</div>";
	}
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

add_action('mystique_header_start', 'grandicarnivori_partners_top');

add_filter('mystique_logo', 'grandicarnivori_logo');

// Richiesto per abilitare gli shortcodes nel widget HTML libero.
add_filter('widget_text', 'do_shortcode' );

add_shortcode('gc_partners', 'grandicarnivori_partners_widget');

add_shortcode('gc_copyright', 'grandicarnivori_copyright');
add_shortcode('gc_banner', 'grandicarnivori_banner');
add_shortcode('gc_mostrafigli', 'grandicarnivori_mostrafigli');

add_action('init', 'grandicarnivori_init');

add_action('wp_head', 'grandicarnivori_ie_di_merda', 20);
add_action('wp_head', 'grandicarnivori_slimbox', 20);

add_action('mystique_before_post', 'stampa_immagini_utenza');
?>
