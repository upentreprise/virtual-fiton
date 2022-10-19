(function( $ ) {
	'use strict';

	var plugin_name = plugin_data.plugin_name;
	var plugin_config = plugin_data.plugin_config;

	var product_id = false;
	var shop_page = false;
	var fiton_img_dimentions = false;

	var global_position_key = '_global_pos';

	var shop_image_dimentions = JSON.parse(plugin_config.shop_image_dimentions);
	var product_image_dimentions = JSON.parse(plugin_config.product_image_dimentions);
	var user_image_dimentions = JSON.parse(plugin_config.user_image_dimentions);
	var fallback_position = JSON.parse(plugin_config.fallback_position);

	var single_pimg_selector = plugin_config.single_pimg_selector;
	var products_loop = plugin_config.products_loop;
	var products_prepend = plugin_config.products_prepend;

	//var single_pimg_selector = '.has-post-thumbnail .woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:not(.clone):first';
	//var single_p_prepend = '.has-post-thumbnail .woocommerce-product-gallery';

	//var products_loop = 'ul.fusion-grid li.product';
	//var products_prepend = '.fusion-column-wrapper div:first';

	//global methods

	//catch class change on a selector
	/*$.fn.classChange = function(cb) {
		return $(this).each((_, el) => {
			new MutationObserver(mutations => {
			mutations.forEach(mutation => cb && cb(mutation.target, $(mutation.target).prop(mutation.attributeName)));
			}).observe(el, {
			attributes: true,
			attributeFilter: ['class'] // only listen for class attribute changes 
			});
		});
	}*/

	function get_image_meta(url) {
		return new Promise((resolve, reject) => {
			let img = new Image();
			img.onload = () => resolve(img);
			img.onerror = () => reject();
			img.src = url;
		});
	}
	
	async function get_image_dimentions(img) {
	  let image = await get_image_meta(img);
	  return {width : image.width, height : image.height};
	}

	function handle_user_image_upload() {
		if (!this.files || !this.files[0]) return;
		const FR = new FileReader();
		FR.addEventListener("load", function(evt) {
			set_user_image(evt.target.result);
			if (product_id) {
				set_single_modal_fiton(false);
			} else if (shop_page) {
				set_shop_modal_fiton(false);
			}
		}); 
		FR.readAsDataURL(this.files[0]);
	}

	function set_user_image(img) {
		localStorage.setItem(plugin_name + '_user_img', img);
	}

	function get_user_image() {
		return localStorage.getItem(plugin_name + '_user_img');
	}

	function set_fiton_position(product_id = false) {
		var fiton_img = $('#' + plugin_name + '_fiton_product').freetrans('getOptions');

		var top = parseInt($('#' + plugin_name + '_fiton_product').css('top'));
		var left = parseInt($('#' + plugin_name + '_fiton_product').css('left'));

		const fiton_position = {
			angle: fiton_img.angle,
			x: fiton_img.x,
			y: fiton_img.y,
			scalex: fiton_img.scalex, 
			scaley: fiton_img.scaley,
			top: top/user_image_dimentions.height,
			left: left/user_image_dimentions.width,
			matrix: $('#' + plugin_name + '_fiton_product').css('transform'),
			container_dimentions: user_image_dimentions
		};
		
		let position_key = global_position_key;
		if (product_id) position_key = '_p_' + product_id + '_pos';
		localStorage.setItem(plugin_name + position_key, JSON.stringify(fiton_position));
	}

	function get_fiton_position(product_id = false, container_dimentions) {
		var fiton_position = false;
		if (product_id) fiton_position = localStorage.getItem(plugin_name + '_p_' + product_id + '_pos'); 

		if (fiton_position) {
			fiton_position = JSON.parse(fiton_position);
			fiton_position.fallback = false;
		} else if(localStorage.getItem(plugin_name + global_position_key)) {
			fiton_position = JSON.parse(localStorage.getItem(plugin_name + global_position_key));
		} else {
			fiton_position = fallback_position;
		}

		fiton_position.dimentions_match = true;
		fiton_position.top = fiton_position.top*container_dimentions.height + 'px';
		fiton_position.left = fiton_position.left*container_dimentions.width + 'px';

		if ((fiton_position.container_dimentions.width != container_dimentions.width) || (fiton_position.container_dimentions.height != container_dimentions.height)) {
			fiton_position.dimentions_match = false;
		}

		return fiton_position;
	}

	function delete_fiton_position(product_id) {
		return localStorage.removeItem(plugin_name + '_p_' + product_id + '_pos');
	}

	function fiton_available(product_id) {
		if (localStorage.getItem(plugin_name + '_p_' + product_id + '_pos')) return true;
		return false;
	}

	function _disable_fiton_edit() {
		$('.' + plugin_name + '_container #' + plugin_name + '_fiton_product').freetrans('controls', false);
		$('.' + plugin_name + '_container .ft-container').css('pointer-events', 'none');
		$('.' + plugin_name + '_container').removeClass('on_edit').addClass('off_edit');
	}

	//single product methods
	function _revert_single_product_image() {
		$(single_pimg_selector + ' a img')
			.attr('src', $(single_pimg_selector + ' img').attr('data-fitoff-src'))
			.attr('data-src', $(single_pimg_selector + ' img').attr('data-fitoff-datasrcsrc'))
			.attr('data-large_image', $(single_pimg_selector + ' img').attr('data-fitoff-large_image'))
			.attr('srcset', $(single_pimg_selector + ' img').attr('data-fitoff-srcset'))
			.removeClass(plugin_name + '_single_usr_img');
	}

	async function set_single_fiton (revert_imgs = false, disable_edit = true) {
		//get product fiton image, if not found we do not continue
		let fiton_img = $('#' + plugin_name + '_fiton_image').val();
		if (!fiton_img) return false;

		//get user image, if not found we do not continue
		let user_img = get_user_image();
		if (!user_img) return false;
		
		//toggle
		$('.' + plugin_name + '_container #' + plugin_name + '_toggle').prop('checked', true);
		$('.' + plugin_name + '_container').removeClass('fiton-disabled').addClass('fiton-enabled');

		if (revert_imgs) _revert_single_product_image();

		//save original product image
		$(single_pimg_selector + ' a img')
			.attr('data-fitoff-src', $(single_pimg_selector + ' img').attr('src'))
			.attr('data-fitoff-datasrc', $(single_pimg_selector + ' img').attr('data-src'))
			.attr('data-fitoff-large_image', $(single_pimg_selector + ' img').attr('data-large_image'))
			.attr('data-fitoff-srcset', $(single_pimg_selector + ' img').attr('srcset'));

		//replace product image with user image
		$(single_pimg_selector + ' a img')
			.attr('src', user_img)
			.attr('data-src', user_img)
			.attr('data-large_image', user_img)
			.attr('srcset', user_img)
			.addClass(plugin_name + '_single_usr_img');

		$(single_pimg_selector)
			.css ({
				'height': product_image_dimentions.height,
				'width': product_image_dimentions.width,
				'overflow': 'hidden'
			});

		//destroy & remove any existing fiton elements (just in case)
		if ($('.' + plugin_name + '_fiton_product').length) $('.' + plugin_name + '_fiton_product').remove();

		//get fiton image dimentions (only once)
		if (!fiton_img_dimentions)fiton_img_dimentions = await get_image_dimentions(fiton_img);

		//prepend image
		$(single_pimg_selector).prepend('<img class="' + plugin_name + '_fiton_product" src="' + fiton_img + '" style="display:none;">');
		position_single_fiton();
	}

	function position_single_fiton(){
		var _user_image_dimentions = {width: $(single_pimg_selector + ' a img').width(), height: $(single_pimg_selector + ' a img').height()};
		let calculated_fiton_img_height = fiton_img_dimentions.height/(fiton_img_dimentions.width/_user_image_dimentions.width);

		//check if fiton position is already saved for this product
		var check_fiton_img_position = get_fiton_position(product_id, _user_image_dimentions);

		//set position
		$('.' + plugin_name + '_fiton_product')
			.fadeIn()
			.css('width', _user_image_dimentions.width + 'px')
			.css('height', calculated_fiton_img_height + 'px')
			.css('max-width', 'unset')
			.css('position', 'absolute')
			.css('top', check_fiton_img_position.top)
			.css('left', check_fiton_img_position.left)
			.css('transform', check_fiton_img_position.matrix);
	}

	async function set_single_modal_fiton (disable_edit = true) {
		//get product fiton image, if not found we do not continue
		let fiton_img = $('#' + plugin_name + '_fiton_image').val();
		if (!fiton_img) return false;

		//get user image, if not found we do not continue
		let user_img = get_user_image();
		if (!user_img) {
			$('#' + plugin_name + '_modal #' + plugin_name + '_webcam_btn .caption').html('Prendre une photo');
			$('#' + plugin_name + '_modal #' + plugin_name + '_upload_btn .caption').html('Téléverser une photo');
			return false;
		} else{
			$('#' + plugin_name + '_modal #' + plugin_name + '_upload_btn .caption, #' + plugin_name + '_modal #' + plugin_name + '_webcam_btn .caption').html('Changer la photo');
		}
		
		//ux
		$('.' + plugin_name + '_container').addClass('file_uploaded');

		//save original product image
		$('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('data-fitoff-src', $('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('src'));

		//replace product image with user image
		$('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('src', user_img);

		//destroy & remove any existing fiton elements (just in case)
		if ($('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').length) $('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').freetrans('destroy').remove();

		//get fiton image dimentions (only once)
		if (!fiton_img_dimentions) fiton_img_dimentions = await get_image_dimentions(fiton_img);

		//prepend image
		$('#' + plugin_name + '_modal .image-block').prepend('<img id="' + plugin_name + '_fiton_product" src="' + fiton_img + '">');

		$('#' + plugin_name + '_fiton_product').load(function(){
			position_modal_fiton();

			//disable editing
			if (disable_edit) {
				_disable_fiton_edit();
			} else {
				$('.' + plugin_name + '_container').removeClass('off_edit').addClass('on_edit');
			}
		});
	}

	//@TODO : not perfectly responsive
	function position_modal_fiton(){
		user_image_dimentions = {width: $('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').width(), height: $('.' + plugin_name + '_container #' + plugin_name + '_preview_image').height()};
		let calculated_fiton_img_height = fiton_img_dimentions.height/(fiton_img_dimentions.width/user_image_dimentions.width);

		/*console.log('~~~~~~~~~~~~~~~~~~~~~');
		console.log('user_image_dimentions');
		console.log(user_image_dimentions);
		console.log('calculated_fiton_img_height : ' + calculated_fiton_img_height);
		console.log('fiton_img_position');
		console.log(fiton_img_position);
		console.log('---------------------');*/

		$('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product')
			.css('width', user_image_dimentions.width + 'px')
			.css('height', calculated_fiton_img_height + 'px')
			.css('max-width', 'unset');

		//check if fiton position is already saved for this product
		var get_position = get_fiton_position(product_id, user_image_dimentions);

		const fiton_img_position = {
			maintainAspectRatio: true,
			angle: get_position.angle,
			x: get_position.x,
			y: get_position.y,
			scalex:get_position.scalex,
			scaley:get_position.scaley
		};

		//mount tranformable fiton element
		$('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').freetrans(fiton_img_position).css('position', 'relative');

		//@TODO : controls do not resize with the image itself
		/*$('.ft-container .ft-controls')
			.css('width', user_image_dimentions.width + 'px')
			.css('height', calculated_fiton_img_height + 'px');*/
	}

	function toggle_single_fiton_edit () {
		if ($('.' + plugin_name + '_container .ft-controls').css('visibility') == 'hidden') {
			$('.' + plugin_name + '_container #' + plugin_name + '_fiton_product').freetrans('controls', true);
			$('.' + plugin_name + '_container .ft-container').css('pointer-events', 'unset');
			$('.' + plugin_name + '_container').removeClass('off_edit').addClass('on_edit');
		} else {
			$('.' + plugin_name + '_container #' + plugin_name + '_fiton_product').freetrans('controls', false);
			$('.' + plugin_name + '_container .ft-container').css('pointer-events', 'none');
			$('.' + plugin_name + '_container').removeClass('on_edit').addClass('off_edit');
		}
	}

	function toggle_single_fiton () {
		if ($('.' + plugin_name + '_fiton_product').length) {
			$('.' + plugin_name + '_fiton_product').remove();
			_revert_single_product_image();
		} else {
			set_single_fiton();
		}
	}

	function remove_single_fiton() {
		$('#' + plugin_name + '_fiton_product').freetrans('destroy').remove();
		_revert_single_product_image();
		delete_fiton_position(product_id);
	}

	//shop archive methods
	function set_shop_fiton (revert_imgs = false) {
		//get user image, if not found we do not continue
		var user_img = get_user_image();
		if (!user_img) return false;

		var container_dimentions = false;
		if (revert_imgs) _revert_shop_product_images();

		//toggle
		$('.' + plugin_name + '_container #' + plugin_name + '_toggle').prop('checked', true);
		$('.' + plugin_name + '_container').removeClass('fiton-disabled').addClass('fiton-enabled');

		$(products_loop).each(async function() {

			//get product fiton image, if not found we do not continue
			let fiton_img = $(this).find('.' + plugin_name + '_fiton_image').val();
			if (!fiton_img) return true;

			//save original product images & replace product images with user image 
			$(this).find('img')
				.removeAttr('width')
				.removeAttr('height')
				.attr('data-fitoff-src', $(this).find('img').attr('src'))
				.attr('data-fitoff-srcset', $(this).find('img').attr('srcset'))
				.attr('src', user_img)
				.attr('srcset', user_img)
				.css('aspect-ratio', 'unset')
				.addClass(plugin_name + '_shop_usr_img');

			//destroy & remove any existing fiton elements (just in case)
			if ($(this).find('.' + plugin_name + '_fiton_product').length) $(this).find('.' + plugin_name + '_fiton_product').remove();

			//get fiton image dimentions
			let fiton_img_dimentions = await get_image_dimentions(fiton_img);

			//prepend image
			$(this).find(products_prepend).prepend('<img class="' + plugin_name + '_fiton_product" src="' + fiton_img + '" data-fitonwidth="' + fiton_img_dimentions.width + '" data-fitonheight="' + fiton_img_dimentions.height + '" style="display:none;">');
		});

		//we need a timeout before positioning fiton (reason unknown)
		setTimeout(function(){ position_shop_fiton(); }, 100);
	}

	function position_shop_fiton(){

		var _shop_image_dimentions = false;

		$(products_loop).each( function() {

			if (!$(this).find('.' + plugin_name + '_fiton_image').val()) return true;
			let product_id = $(this).find('.' + plugin_name + '_product_id').val();

			if (!_shop_image_dimentions) _shop_image_dimentions = {width: $(this).find('img.' + plugin_name + '_shop_usr_img').width(), height: $(this).find('img.' + plugin_name + '_shop_usr_img').height()};

			//@TO-DO : user_img height currently does not respect original product image height
			/*$(this).find('img.' + plugin_name + '_shop_usr_img')
				.css('max-height', shop_image_dimentions.height)
				.css('width', '100%')
				.css('object-fit', 'cover')
				.css('object-position', 'top');*/

			let fiton_img_dimentions = {
				height: $(this).find('.' + plugin_name + '_fiton_product').attr('data-fitonheight'), 
				width: $(this).find('.' + plugin_name + '_fiton_product').attr('data-fitonwidth')
			};

			let calculated_fiton_img_height = fiton_img_dimentions.height/(fiton_img_dimentions.width/_shop_image_dimentions.width);

			//check if fiton position is already saved for this product
			var check_fiton_img_position = get_fiton_position(product_id, _shop_image_dimentions);

			//set position
			$(this).find('.' + plugin_name + '_fiton_product')
				.fadeIn()
				.css('width', _shop_image_dimentions.width + 'px')
				.css('height', calculated_fiton_img_height + 'px')
				.css('max-width', 'unset')
				.css('position', 'absolute')
				.css('top', check_fiton_img_position.top)
				.css('left', check_fiton_img_position.left)
				.css('transform', check_fiton_img_position.matrix);

		});
	}

	async function set_shop_modal_fiton (disable_edit = true) {
		//get product fiton image, if not found we do not continue
		let fiton_img = plugin_config.fiton_image;
		if (!fiton_img) return false;

		//get user image, if not found we do not continue
		let user_img = get_user_image();
		if (!user_img) {
			$('#' + plugin_name + '_modal #' + plugin_name + '_webcam_btn .caption').html('Prendre une photo');
			$('#' + plugin_name + '_modal #' + plugin_name + '_upload_btn .caption').html('Téléverser une photo');
			return false;
		} else{
			$('#' + plugin_name + '_modal #' + plugin_name + '_upload_btn .caption, #' + plugin_name + '_modal #' + plugin_name + '_webcam_btn .caption').html('Changer la photo');
		}
		
		//ux
		$('.' + plugin_name + '_container').addClass('file_uploaded');

		//save original preview image
		$('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('data-fitoff-src', $('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('src'));

		//replace preview image with user image
		$('#' + plugin_name + '_modal #' + plugin_name + '_preview_image').attr('src', user_img);

		//destroy & remove any existing fiton elements (just in case)
		if ($('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').length) $('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').freetrans('destroy').remove();

		//get fiton image dimentions (only once)
		if (!fiton_img_dimentions) fiton_img_dimentions = await get_image_dimentions(fiton_img);

		//prepend image
		$('#' + plugin_name + '_modal .image-block').prepend('<img id="' + plugin_name + '_fiton_product" src="' + fiton_img + '">');

		$('#' + plugin_name + '_fiton_product').load(function(){
			position_modal_fiton();

			//disable editing
			if (disable_edit) {
				_disable_fiton_edit();
			} else {
				$('.' + plugin_name + '_container').removeClass('off_edit').addClass('on_edit');
			}
		});
	}

	function _revert_shop_product_images () {
		$(products_loop).each(function() {
			if ($(this).find('img').attr('data-fitoff-src')) {
				$(this).find('img')
					.attr('src', $(this).find('img').attr('data-fitoff-src'))
					.attr('srcset', $(this).find('img').attr('data-fitoff-srcset'))
					.removeClass(plugin_name + '_shop_usr_img')
					.css ({
						'max-height': '',
						'max-width': ''
					});
			}
		});
	}

	function toggle_shop_fiton () {
		if ($(products_loop + ':first').find('.' + plugin_name + '_fiton_product').length) {
			$(products_loop + ' .' + plugin_name + '_fiton_product').remove();
			_revert_shop_product_images();
		} else {
			set_shop_fiton();
		}
	}

	$( window ).load(function() {
		//read selected image file (with no upload to server)
		document.querySelector('#' + plugin_name + '_user_image').addEventListener("change", handle_user_image_upload);

		//auto fiton on single page
		if ($('#' + plugin_name + '_product_id').length) {
			product_id = $('#' + plugin_name + '_product_id').val();

			// set default product image dimentions 
			//@TODO :below function does not return actual dimentions as drawn in client, so we will use the fallback values from plugin config
			//product_image_dimentions = {width: $(single_pimg_selector + ' a img').width() + 'px', height: $(single_pimg_selector + ' a img').height() + 'px'};

			//if (plugin_config.force_single_placement)$('.' + plugin_name + '_single_section_container').insertAfter('.fusion-woo-price-tb');

			if (fiton_available(product_id)) set_single_fiton();
		}

		//auto fiton on shop page
		if ($('#' + plugin_name + '_shop').val() == 'true' || $('#' + plugin_name + '_shop').val() == '1') {
			shop_page = true;

			//set default shop image dimentions	
			let shop_image_width = $(products_loop + ':first img:first').width();
			let shop_image_height = $(products_loop + ':first img:first').height();
			if (shop_image_width > 0 && shop_image_height >0) shop_image_dimentions = {width: $(products_loop + ':first img:first').width() + 'px', height: $(products_loop + ' :first img:first').height() + 'px'};

			set_shop_fiton();
		}

		//fiton toggle (trigger toggle on label)
		$('.' + plugin_name + '_container .toggle-section div').click( function() {
			$('.' + plugin_name + '_container .toggle-section input').click();
		});

		//fiton toggle
		$('.' + plugin_name + '_container .toggle-section input').change(function() {
			if (shop_page) toggle_shop_fiton();
			else toggle_single_fiton();

			if(this.checked) $(this).parents('.' + plugin_name + '_container').removeClass('fiton-disabled').addClass('fiton-enabled');
			else $(this).parents('.' + plugin_name + '_container').removeClass('fiton-enabled').addClass('fiton-disabled');
		});
		
		//fiton save btn
		$('.' + plugin_name + '_container #' + plugin_name + '_save_btn').click( function() {
			set_fiton_position(product_id);
			_disable_fiton_edit();
			$.magnificPopup.close();

			if (shop_page) set_shop_fiton();
			else set_single_fiton();
		});

		//fiton edit btn
		$('#' + plugin_name + '_edit_btn').click( function() {
			toggle_single_fiton_edit();
		});

		//upload btn -> trigger file upload
		$('#' + plugin_name + '_upload_btn').click( function() {
			$('#' + plugin_name + '_user_image').click();
		});

		//setup model before model trigger
		$('.' + plugin_name + '_container #' + plugin_name + '_open_modal').click( function() {
			if (shop_page) set_shop_modal_fiton(false);
			else set_single_modal_fiton(false);
		});

		//modal trigger
		$('.' + plugin_name + '_container #' + plugin_name + '_open_modal').magnificPopup({
			type:'inline',
			midClick: true
		});

		//dynamically place the fiton as the window+user image resizes
		$(window).on('resize', function(){
			if ($('.' + plugin_name + '_fiton_product').length) {
				if (shop_page) position_shop_fiton();
				else position_single_fiton();
			}

			if ($('#' + plugin_name + '_modal #' + plugin_name + '_fiton_product').length) {
				//@TO-DO - save current position (as user might have edited the position already)
				position_modal_fiton();
			}
		});

		//hide fiton when user navigate to other single producgt images (no longer needed, keeping the code as its cool)
		/*const $foo = $(".flex-control-nav li:first img").classChange((el, newClass) => woo_single_img_nav(newClass));
		function woo_single_img_nav(newClass) {
			if (newClass.indexOf("flex-active") >= 0) $('.' + plugin_name + '_fiton_product').fadeIn();
			else $('.' + plugin_name + '_fiton_product').hide();
		}*/
	});

})( jQuery );