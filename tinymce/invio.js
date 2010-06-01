(function() {
	tinymce.create('tinymce.plugins.GCInvio', {
		/**
		 * Initializes the plugin, this will be executed after the plugin has been created.
		 * This call is done before the editor instance has finished it's initialization so use the onInit event
		 * of the editor instance to intercept that event.
		 *
		 * @param {tinymce.Editor} ed Editor instance that the plugin is initialized in.
		 * @param {string} url Absolute URL to where the plugin is located.
		 */
		init : function(ed, url) {
			// Register the command so that it can be invoked by using tinyMCE.activeEditor.execCommand('mceExample');
			ed.addCommand('aggiungiInvio', function() {
				ed.execCommand('mceInsertContent', false, '<p style="height: 1em"></p>');
			});

			// Register example button
			ed.addButton('gc_invio', {
				title : 'Aggiungi a capo forzato',
				cmd : 'aggiungiInvio',
				image : url + '/icona.png'
			});

		},

		/**
		 * Returns information about the plugin as a name/value array.
		 * The current keys are longname, author, authorurl, infourl and version.
		 *
		 * @return {Object} Name/value array containing information about the plugin.
		 */
		getInfo : function() {
			return {
				longname : 'Aggiungi invio forzato',
				author : 'Andrea Piccinelli',
				authorurl : 'http://polpoinodroidi.com',
				infourl : 'http://polpoinodroidi.com',
				version : "1.1"
			};
		}
	});

	// Register plugin
	tinymce.PluginManager.add('gc_invio', tinymce.plugins.GCInvio);
})();
