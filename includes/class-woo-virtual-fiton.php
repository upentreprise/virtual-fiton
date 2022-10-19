<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the admin area.
 *
 * @link       upentreprise.com/prabch
 * @since      1.0.0
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, admin-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/includes
 * @author     UPentreprise <dev@upentreprise.com>
 */
class Woo_Virtual_Fiton {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Woo_Virtual_Fiton_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_name    The string used to uniquely identify this plugin.
	 */
	protected $plugin_name;

	/**
	 * The public identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $plugin_public_name    The string used to publicly identify this plugin.
	 */
	protected $plugin_public_name;

	/**
	 * The config data of plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      array    $plugin_config    The array used to config of this plugin.
	 */
	protected $plugin_config;
	protected $plugin_default_config;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the plugin name and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the admin area and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {
		if ( defined( 'WOO_VIRTUAL_FITON_VERSION' ) ) {
			$this->version = WOO_VIRTUAL_FITON_VERSION;
		} else {
			$this->version = '1.0.0';
		}
		$this->plugin_name = 'woo-virtual-fiton';
		$this->plugin_public_name = 'Essayage virtuel';

		$this->plugin_default_config = [
			'shop_image_dimentions' => '{"width": "200px", "height": "200px"}',
			'product_image_dimentions' => '{"width": "480px", "height": "480px"}',
			'user_image_dimentions' => '{"width": "480", "height": "480"}',
			'fallback_position' => '{"fallback":true,"angle":0,"x":0,"y":0,"scalex":1,"scaley":1,"top":0,"left":0,"matrix":"matrix(1, 0, 0, 1, 0, 0)","container_dimentions":{"width":400,"height":400}}',
			'single_pimg_selector' => '.has-post-thumbnail .woocommerce-product-gallery__wrapper .woocommerce-product-gallery__image:first',
			'products_loop' => 'ul.products li.product',
			'products_prepend' => '.woocommerce-loop-product__link',
			'user_image' => plugin_dir_url( dirname(__FILE__) ) . 'public/images/user_image.png',
			'fiton_image' => plugin_dir_url( dirname(__FILE__) ) . 'public/images/fiton_image.png',
			'instructions'	=> "Prenez une photo à l'aide de votre webcam ou de l'appareil photo de votre téléphone ou téléversez une photo que vous avez déjà.\nAssurez-vous que la photo que vous utilisez est une photo de face claire de vous avec suffisamment d'espace autour de la tête.\nLorsque vous voyez votre photo, repositionnez et redimensionnez le chapeau jusqu'à ce qu'il vous fasse bien.\nCliquez sur enregistrer pour conserver ce positionnement. À partir de ce moment, votre photo sera utilisée pour essayer tous les chapeaux sur ce site.",
			'push_single_placement_after' => false,
			'shortcodes_active' => true,
			'shop_page_active' => true,
			'shop_loop_active' => true,
			'single_product_active' => true,
			'caching_active' => true,
			'disable_single_zoom' => true
		];

		$this->plugin_config = $this->get_plugin_config();

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	public function get_plugin_config() {
		$config = [];
		foreach ($this->plugin_default_config as $key => $value) {
			if ($_value = esc_attr(get_option($this->plugin_name . '_' . $key))) $config[$key] = htmlspecialchars_decode(stripslashes($_value));
			else $config[$key] = (isset($this->plugin_default_config[$key])) ? htmlspecialchars_decode(stripslashes($this->plugin_default_config[$key])) : null ;

			if (get_option($this->plugin_name . '_' . $key) === '') $config[$key] = false;
		}
		return $config;
	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Woo_Virtual_Fiton_Loader. Orchestrates the hooks of the plugin.
	 * - Woo_Virtual_Fiton_i18n. Defines internationalization functionality.
	 * - Woo_Virtual_Fiton_Admin. Defines all hooks for the admin area.
	 * - Woo_Virtual_Fiton_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-virtual-fiton-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-woo-virtual-fiton-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the admin area.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-woo-virtual-fiton-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-woo-virtual-fiton-public.php';

		$this->loader = new Woo_Virtual_Fiton_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Woo_Virtual_Fiton_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Woo_Virtual_Fiton_i18n();

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the admin area functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Woo_Virtual_Fiton_Admin( $this->get_plugin_name(), $this->get_version(), $this->plugin_public_name, $this->plugin_config );

		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		$this->loader->add_action( 'admin_notices', $plugin_admin, 'show_admin_notices' );
		$this->loader->add_action( 'woocommerce_product_options_general_product_data', $plugin_admin, 'add_woocommerce_fiton_image_field' );
		$this->loader->add_action( 'woocommerce_process_product_meta', $plugin_admin, 'save_woocommerce_fiton_image_field' );

		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_admin_menu' );
		$this->loader->add_action( 'admin_init', $plugin_admin, 'register_admin_page_settings' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {
		$plugin_public = new Woo_Virtual_Fiton_Public( $this->get_plugin_name(), $this->get_version(), $this->plugin_public_name, $this->plugin_config  );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

		if ($this->plugin_config['disable_single_zoom']) $this->loader->add_filter( 'woocommerce_single_product_zoom_enabled', null, '__return_false' );

		if ($this->plugin_config['single_product_active']) $this->loader->add_action( 'woocommerce_before_add_to_cart_form', $plugin_public, 'woocom_product_page' );

		if ($this->plugin_config['shop_loop_active']) $this->loader->add_action( 'woocommerce_before_shop_loop', $plugin_public, 'woocom_shop_page' );

		if ($this->plugin_config['shop_page_active']) $this->loader->add_action( 'woocommerce_after_shop_loop_item', $plugin_public, 'woocom_shop_loop' );

		if ($this->plugin_config['shortcodes_active']) {
			$this->loader->add_shortcode( 'woo_vfiton_product_page', $plugin_public, 'woocom_product_page_shortcode' );
			$this->loader->add_shortcode( 'woo_vfiton_shop_page', $plugin_public, 'woocom_shop_page_shortcode' );
			$this->loader->add_shortcode( 'woo_vfiton_shop_loop', $plugin_public, 'woocom_shop_loop_shortcode' );
		}
	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_name() {
		return $this->plugin_name;
	}

	/**
	 * The name of the plugin used to publicly identify it
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_plugin_public_name() {
		return $this->plugin_public_name;
	}
	
	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Woo_Virtual_Fiton_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}
