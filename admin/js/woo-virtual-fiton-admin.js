(function( $ ) {
	'use strict';

	var plugin_name = plugin_data.plugin_name;
	var plugin_public_name = plugin_data.plugin_public_name;

	$( window ).load(function() {
		$('#' + plugin_name + '_upload_fiton').on( 'click', function() {
			tb_show(plugin_public_name, 'media-upload.php?type=image&TB_iframe=1');
			window.send_to_editor = function( html ) {
				let imgurl = $(html).attr( 'src' );
				$('#' + plugin_name + '_fiton_image').val(imgurl);
				$('#' + plugin_name + '_preview_image').attr( 'src', imgurl);
				tb_remove();
			}
			return false;
		});

		$('.' + plugin_name + '_container .advanced-settings a').click(function() {
			$('.' + plugin_name + '_container').addClass('advanced-on');
		});
	});

})( jQuery );
