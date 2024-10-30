<?php

// Link to support and pro page from plugins screen
function webtica_users_integration_filter_action_links( $links ) {

	$links['support'] = '<a href="https://plugins.webtica.be/support/?ref=plugin-settings-page" target="_blank">Support</a>';
	return $links;

}
add_filter( 'plugin_action_links_integration-for-elementor-forms-users/users-elementor-integration.php', 'webtica_users_integration_filter_action_links', 10, 3 );