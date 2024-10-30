<?php

class Mobiright_Ads_Admin {
	private $plugin_name;
	private $version;
	public $config;
	public $plugin_dir_name;
	public $plugin_dir_url;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->config      = mobiright_get_config();
		$this->plugin_dir_name = plugin_basename( dirname( __FILE__ ) );
		$this->plugin_dir_url = plugin_dir_url( __FILE__ );
	}

	function register_menu_page() {
		$icon_url = plugins_url( 'images/logo.png', __FILE__ );
		$plugin_dir_name = $this->plugin_dir_name;
		add_menu_page( 'Better Mobile Ads by Mobiright', 'Better Mobile Ads by Mobiright', 'manage_options', $plugin_dir_name . '/partials/mobiright-ads-admin-display.php', '', $icon_url, '80.5759999919' );
		add_action( 'load-' . $plugin_dir_name . '/partials/mobiright-ads-admin-display.php', array( $this, 'load_admin_js' ) );
		add_action( 'load-' . $plugin_dir_name . '/partials/mobiright-ads-admin-display.php', array( $this, 'load_admin_css' ) );

	}

	public function load_admin_js() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_js' ) );
	}

	public function load_admin_css() {
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_css' ) );
	}

	public function enqueue_admin_js() {
		$plugin_dir_url = $this->plugin_dir_url;
		wp_enqueue_script( $this->plugin_name, $plugin_dir_url . 'js/mobiright-ads-admin.js', array( 'jquery' ), $this->version, false );
		wp_enqueue_script( 'jquery.onoff', $plugin_dir_url . 'bower_components/jquery.onoff/jquery.onoff.js', array( $this->plugin_name ), $this->version, false );
		wp_enqueue_script( 'jquery.are-you-sure', $plugin_dir_url . 'bower_components/jquery.are-you-sure/jquery.are-you-sure.js', array( $this->plugin_name ), $this->version, false );
	}

	public function enqueue_admin_css() {
		$plugin_dir_url = $this->plugin_dir_url;
		wp_enqueue_style( $this->plugin_name, $plugin_dir_url . 'css/mobiright-ads-admin.css', array(), $this->version, 'all' );
		wp_enqueue_style( 'jquery.onoff', $plugin_dir_url . 'bower_components/jquery.onoff/jquery.onoff.css', array( $this->plugin_name ), $this->version, 'all' );
	}

	public function save() {
		$new_data = array(
			'url'       => site_url(),
			'fname'     => $_POST['fname'],
			'lname'     => $_POST['lname'],
			'email'     => $_POST['email'],
			'paypal'    => $_POST['paypal'],
			'ad_format' => $_POST['ad_format'],
			'status'    => $_POST['status'] ? $_POST['status'] : 'off'
		);

		$serialized_new_data = serialize( $new_data );
		$old_data            = get_option( 'mobiright_user_info' );
		if ( $old_data ) {
			$old_data = unserialize( $old_data );
		}
		$response = $this->send_data_to_mobiright( $new_data, $old_data );

		if ( is_wp_error( $response ) ) {
			wp_redirect( add_query_arg( array(
				'page'  => $this->plugin_dir_name . '/partials/mobiright-ads-admin-display.php',
				'error' => '1'
			), admin_url( 'admin.php' ) ) );
		} else {
			update_option( 'mobiright_user_info', $serialized_new_data );
			update_option( 'mobiright_active', $new_data['status'] );
			wp_redirect( add_query_arg( array( 'page' => $this->plugin_dir_name . '/partials/mobiright-ads-admin-display.php' ),
				admin_url( 'admin.php' ) ) );
		}
	}

	public function send_data_to_mobiright( $new_data, $old_user_info ) {
		$response = wp_remote_post( $this->config['server'], array(
			'method'      => 'POST',
			'timeout'     => 45,
			'redirection' => 5,
			'httpversion' => '1.0',
			'blocking'    => true,
			'headers'     => array(),
			'body'        => array(
				'new_data' => $new_data,
				'old_data' => $old_user_info
			),
			'cookies'     => array()
		) );

		return $response;
	}
}
