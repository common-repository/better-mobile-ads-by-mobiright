<?php

class Mobiright_Ads {
	protected $loader;
	protected $plugin_name;
	protected $version;

	public function __construct() {
		$this->plugin_name = 'better-mobile-ads-by-mobiright';
		$this->version     = '1.0.0';
		$this->load_dependencies();
		$this->define_admin_hooks();
		$this->define_public_hooks();
	}

	private function load_dependencies() {
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-mobiright-ads-loader.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-mobiright-ads-admin.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-mobiright-ads-public.php';
		$this->loader = new Mobiright_Ads_Loader();
	}

	private function define_admin_hooks() {
		$plugin_admin = new Mobiright_Ads_Admin( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'register_menu_page' );
		$this->loader->add_action( 'admin_post_mobiright_save', $plugin_admin, 'save' );
	}

	private function define_public_hooks() {
		$plugin_public = new Mobiright_Ads_Public( $this->get_plugin_name(), $this->get_version() );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_script_tag' );
		$this->loader->add_filter( 'script_loader_tag', $plugin_public, 'async_scripts' );
	}

	public function run() {
		$this->loader->run();
	}

	public function get_plugin_name() {
		return $this->plugin_name;
	}

	public function get_loader() {
		return $this->loader;
	}

	public function get_version() {
		return $this->version;
	}

}

