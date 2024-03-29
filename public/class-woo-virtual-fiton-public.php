<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       upentreprise.com/prabch
 * @since      1.0.0
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the public-facing stylesheet and JavaScript.
 *
 * @package    Woo_Virtual_Fiton
 * @subpackage Woo_Virtual_Fiton/public
 * @author     UPentreprise <dev@upentreprise.com>
 */
class Woo_Virtual_Fiton_Public {

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
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version, $plugin_public_name, $plugin_config  ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
		$this->plugin_public_name  = $plugin_public_name;
		$this->plugin_config = $plugin_config;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		$version = ($this->plugin_config['caching_active']) ? $this->version : '?v=1.' . rand(1,9999999);

		wp_enqueue_style( 'dashicons' );
		wp_enqueue_style( $this->plugin_name . '_core', plugin_dir_url( __FILE__ ) . 'css/woo-virtual-fiton-public.css', array(), $version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_freetrans', plugin_dir_url( __FILE__ ) . 'css/jquery.freetrans.css', array(), $version, 'all' );
		wp_enqueue_style( $this->plugin_name . '_magnific', plugin_dir_url( __FILE__ ) . 'css/magnific-popup.css', array(), $version, 'all' );
	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		$version = ($this->plugin_config['caching_active']) ? $this->version : '?v=1.' . rand(1,9999999);

		wp_enqueue_script( $this->plugin_name . '_matrix', plugin_dir_url( __FILE__ ) . 'js/Matrix.js', array( 'jquery' ), $version, false );
		wp_enqueue_script( $this->plugin_name . '_freetrans', plugin_dir_url( __FILE__ ) . 'js/jquery.freetrans.js', array( 'jquery' ), $version, false );
		wp_enqueue_script( $this->plugin_name . '_core', plugin_dir_url( __FILE__ ) . 'js/woo-virtual-fiton-public.js', array( 'jquery' ), $version, false );
		wp_enqueue_script( $this->plugin_name . '_magnific', plugin_dir_url( __FILE__ ) . 'js/jquery.magnific-popup.js', array( 'jquery' ), $version, false );

		$plugin_data = [
			'plugin_name'               => $this->plugin_name,
			'plugin_public_name'		=> $this->plugin_public_name,
			'plugin_config'				=> $this->plugin_config
		];
		wp_localize_script( $this->plugin_name . '_core', 'plugin_data', $plugin_data ); 
	}

	public function woocom_product_page() {
		global $post;
		$page = 'single';
		$product = wc_get_product( $post->ID );

		$product_image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
		$preview_image = isset($product_image[0]) ? $product_image[0] : false;
		if (!$preview_image) return;

		$fiton_image = ($product->get_meta($this->plugin_name . '_fiton_image') ? $product->get_meta($this->plugin_name . '_fiton_image') : false);
		if (!$fiton_image) return;

		include 'partials/woo-virtual-fiton-modal.php';
	}

	public function woocom_shop_page() {
		$page = 'shop';
		$preview_image = $this->plugin_config['user_image'];
		include 'partials/woo-virtual-fiton-modal.php';
	}

	public function woocom_shop_loop() {
		global $post;
		$product = wc_get_product( $post->ID );
		$fiton_image = ($product->get_meta($this->plugin_name . '_fiton_image') ? $product->get_meta($this->plugin_name . '_fiton_image') : false);
		include 'partials/woo-virtual-fiton-shop-loop.php';
	}
	
	public function woocom_product_page_shortcode() {
		ob_start();
		$this->woocom_product_page();
		$output = ob_get_clean();
		return $output;
	}

	public function woocom_shop_page_shortcode() {
		ob_start();
		$this->woocom_shop_page();
		$output = ob_get_clean();
		return $output;
	}
	
	public function woocom_shop_loop_shortcode() {
		ob_start();
		$this->woocom_shop_loop();
		$output = ob_get_clean();
		return $output;
	}

}