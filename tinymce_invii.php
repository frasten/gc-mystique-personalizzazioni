<?php

class GC_Pulsante_tinymce {
	function init() {
		// Don't bother doing this stuff if the current user lacks permissions
		if ( ! current_user_can('edit_posts') && ! current_user_can('edit_pages') )
			return;

		// Add only in Rich Editor mode
		if ( get_user_option('rich_editing') == 'true') {
			add_filter("mce_external_plugins", array(&$this, 'aggiungi_plugin_tinymce'));
			add_filter('mce_buttons', array(&$this, 'registra_pulsante_invio'));
		}
	}

	function registra_pulsante_invio($buttons) {
		array_push($buttons, "separator", "gc_invio");
		return $buttons;
	}

	// Load the TinyMCE plugin : editor_plugin.js (wp2.5)
	function aggiungi_plugin_tinymce($plugin_array) {
		$plugin_array['gc_invio'] = GRANDICARNIVORI_PLUGIN_URL.'/tinymce/invio.js';
		return $plugin_array;
	}
}

// init process for button control
$gc_pulsante = new GC_Pulsante_tinymce();
add_action('init', array(&$gc_pulsante, 'init'));
?>
