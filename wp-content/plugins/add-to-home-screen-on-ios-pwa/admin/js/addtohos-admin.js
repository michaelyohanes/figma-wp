(function( $ ) {
	'use strict';

	/**
	 * All of the code for your admin-facing JavaScript source
	 * should reside in this file.
	 *
	 * Note: It has been assumed you will write jQuery code here, so the
	 * $ function reference has been prepared for usage within the scope
	 * of this function.
	 *
	 * This enables you to define handlers, for when the DOM is ready:
	 *
	 * $(function() {
	 *
	 * });
	 *
	 * When the window is loaded:
	 *
	 * $( window ).load(function() {
	 *
	 * });
	 *
	 * ...and/or other possibilities.
	 *
	 * Ideally, it is not considered best practise to attach more than a
	 * single DOM-ready or window-load handler for a particular page.
	 * Although scripts in the WordPress core, Plugins and Themes may be
	 * practising this, we should strive to set a better example in our own work.
	 */

	jQuery(document).ready(function($){
		if(typeof $.fn.spectrum == 'function') {

			$('.addtohos-field-edit input[type="color"]').spectrum({
				showInput: "true",
				showAlpha: true,
				allowEmpty:true,
				
				showInitial: true,       // Optional: show initial color
				clickoutFiresChange: true // Optional: fire change on clickout
			});
		}
		if(typeof $.fn.select2 == 'function') {

			$('.addtohos-field-edit .select_multi').on('change', function(){
                $(this).parent().find('input[type="hidden"]').val(jQuery(this).val().join(','));
            })
		}
		
		if (typeof wp !== 'undefined' && wp.codeEditor && typeof wp.codeEditor.initialize === 'function') {
			$('.addtohos-field-edit textarea.wp-editor-area').each(function() {
				wp.codeEditor.initialize(this, wp.codeEditor.defaultSettings ? wp.codeEditor.defaultSettings : {});
			});
		}

		if(jQuery('.addtohos-tabs-navs').length) {
			jQuery('.addtohos-tabs-navs').find('label').on('click', function(){
				jQuery(this).parent().find('label').removeClass('active');
				jQuery(this).addClass('active');
			});
		}
    });

})( jQuery );
