<?php

class Mobiright_Ads_Public {
	private $plugin_name;
	private $version;
	public $config;

	public function __construct( $plugin_name, $version ) {
		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->config      = mobiright_get_config();
	}

	public function enqueue_script_tag() {
		if ( get_option( 'mobiright_active' ) == "on" ) {
			wp_enqueue_script( 'mobiright-script', $this->config['discovery'], array(), $this->version, false );
		}
	}

	public function async_scripts( $url ) {
		if ( strpos( $url, '#asyncload' ) === false ) {
			return $url;
		} else if ( is_admin() ) {
			return str_replace( '#asyncload', '', $url );
		} else {
			return str_replace( '#asyncload\'',  '\' async', $url );
		}
	}
}