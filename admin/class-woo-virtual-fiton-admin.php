<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       upentreprise.com/prabch
 * @since      1.0.0
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/admin
 * @author     UPentreprise <dev@upentreprise.com>
 */
class Woo_Virtual_Fiton_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;
	private $plugin_public_name;
	private $plugin_config;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_public_name, $plugin_config ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_public_name = $plugin_public_name;
		$this->plugin_config = $plugin_config;

		// Check if WooCommerce is active
		include_once( ABSPATH . 'wp-admin/includes/plugin.php' );
		if ( !is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
			$notices= get_option($this->plugin_name  . '_deferred_admin_notices', []);
			$notices[]= $this->plugin_public_name . ": WooCommerce is required to use this plugin";
			update_option($this->plugin_name  . '_deferred_admin_notices', $notices);
		}

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Virtual_Fiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Virtual_Fiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/woo-virtual-fiton-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Woo_Virtual_Fiton_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Woo_Virtual_Fiton_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/woo-virtual-fiton-admin.js', array( 'jquery' ), $this->version, false );

	}

	public function add_admin_menu() {
		add_submenu_page( 'woocommerce', $this->plugin_public_name, $this->plugin_public_name, 'manage_options', $this->plugin_name, array( $this, 'admin_page_view' ) );
	}

	public function register_admin_page_settings() {
		register_setting( $this->plugin_name, $this->plugin_name . '_shop_image_dimentions' );
		register_setting( $this->plugin_name, $this->plugin_name . '_product_image_dimentions' );
		register_setting( $this->plugin_name, $this->plugin_name . '_user_image_dimentions' );
		register_setting( $this->plugin_name, $this->plugin_name . '_fallback_position' );
		register_setting( $this->plugin_name, $this->plugin_name . '_single_pimg_selector' );
		register_setting( $this->plugin_name, $this->plugin_name . '_products_loop' );
		register_setting( $this->plugin_name, $this->plugin_name . '_products_prepend' );
		register_setting( $this->plugin_name, $this->plugin_name . '_user_image' );
		register_setting( $this->plugin_name, $this->plugin_name . '_fiton_image' );
		register_setting( $this->plugin_name, $this->plugin_name . '_instructions' );
	}

	public function admin_page_view(){
		include 'partials/woo-virtual-fiton-admin.php';
	}

	public function show_setting_input($type = 'text', $name = null, $id = null, $options = [], $value = null) {
		$output = '';
		$value = htmlspecialchars($value);

		switch ($type) {
			case 'select':
				$output = '<select name="' . $name . '" ';
				if ($id) $output .= 'id="' . $id . '" ';
				$output .= '>';
				foreach($options as $key => $option) {
					$selected = ($key==$value) ? 'selected="selected"' : '';
					$output .= '<option value="' . $key . '" ' . $selected . '>' . $option . '</option>';
				}
				$output .= '</select>';
				break;
			
			case 'textarea':
				$output = '<textarea name="' . $name . '" rows="10" cols="100" ';
				if ($id) $output .= 'id="' . $id . '" ';
				$output .= '>' . htmlspecialchars_decode($value) . '</textarea>';
				break;

			default:
				$output = '<input type="text" name="' . $name . '" ';
				if ($id) $output .= 'id="' . $id . '" ';
				$output .= 'value="' . $value . '" />';
				break;
		}

		echo $output;
	}

	public function show_admin_notices() {
		if ($notices = get_option( $this->plugin_name . '_deferred_admin_notices')) {
			foreach ($notices as $notice) {
				echo "<div class='updated'><p>$notice</p></div>";
			}
			delete_option($this->plugin_name . '_deferred_admin_notices');
		}
	}

	public function add_woocommerce_fiton_image_field() {
		$args = [
			'id' => $this->plugin_name . '_fiton_image',
			'label' => __( 'Transparent FitOn Image', 'hvto' ),
			'class' => $this->plugin_name . '-fiton-image',
			'desc_tip' => true,
			'description' => __( 'This image will be used when user fits on this product', $this->plugin_name ),
		];
		woocommerce_wp_text_input( $args );
	}

	public function save_woocommerce_fiton_image_field( $post_id ) {
		$product = wc_get_product( $post_id );
		$title = isset( $_POST[$this->plugin_name . '_fiton_image'] ) ? $_POST[ $this->plugin_name . '_fiton_image'] : '';
		$product->update_meta_data( $this->plugin_name . '_fiton_image', sanitize_text_field( $title ) );
		$product->save();
	}

}
