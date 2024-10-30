<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}
$user_info_option = get_option( 'mobiright_user_info' );
$unserialized = unserialize($user_info_option);
$unserialized['status'] = 'off';
update_option('mobiright_user_info', serialize($unserialized));
delete_option('mobiright_active');
