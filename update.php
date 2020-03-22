<?php
/**
 * This file ensures automatic update notifications to the WordPress Update UI
 * Thanks to https://kaspars.net for the original idea
 * @link https://kaspars.net/blog/automatic-updates-for-plugins-and-themes-hosted-outside-wordpress-extend
 *
 * @since Hierarchical Posts Tree 1.0
 */


$tkt_tree_view_api_url = 'https://updates.tukutoi.com';
$tkt_tree_view_plugin_slug = 'tkt-tree-view';

function tkt_tree_view_check_for_plugin_updates($checked_data) {
	global $tkt_tree_view_api_url, $tkt_tree_view_plugin_slug, $wp_version;
	
	//Comment out these two lines during testing.
	if (empty($checked_data->checked))
		return $checked_data;
	
	$tkt_tree_view_seo_args = array(
		'slug' => $tkt_tree_view_plugin_slug,
		'version' => $checked_data->checked[$tkt_tree_view_plugin_slug .'/'. $tkt_tree_view_plugin_slug .'.php'],
	);
	$tkt_tree_view_request_string = array(
			'body' => array(
				'action' => 'basic_check', 
				'request' => serialize($tkt_tree_view_seo_args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	// Start checking for an update
	$tkt_tree_view_raw_response = wp_remote_post($tkt_tree_view_api_url, $tkt_tree_view_request_string);
	
	if (!is_wp_error($tkt_tree_view_raw_response) && ($tkt_tree_view_raw_response['response']['code'] == 200))
		$tkt_tree_view_response = unserialize($tkt_tree_view_raw_response['body']);
	
	if (is_object($tkt_tree_view_response) && !empty($tkt_tree_view_response)) // Feed the update data into WP updater
		$checked_data->response[$tkt_tree_view_plugin_slug .'/'. $tkt_tree_view_plugin_slug .'.php'] = $tkt_tree_view_response;
	
	return $checked_data;
}

function tkt_tree_view_plugin_api_callback($action, $args) {
	global $tkt_tree_view_plugin_slug, $tkt_tree_view_api_url, $wp_version;
	
	if (!isset($args->slug) || ($args->slug != $tkt_tree_view_plugin_slug))
		return false;
	
	// Get the current version
	$tkt_tree_view_plugin_info = get_site_transient('update_plugins');
	$tkt_tree_view_current_version = $tkt_tree_view_plugin_info->checked[$tkt_tree_view_plugin_slug .'/'. $tkt_tree_view_plugin_slug .'.php'];
	$args->version = $tkt_tree_view_current_version;
	
	$tkt_tree_view_request_string = array(
			'body' => array(
				'action' => $action, 
				'request' => serialize($args),
				'api-key' => md5(get_bloginfo('url'))
			),
			'user-agent' => 'WordPress/' . $wp_version . '; ' . get_bloginfo('url')
		);
	
	$tkt_tree_view_request = wp_remote_post($tkt_tree_view_api_url, $tkt_tree_view_request_string);
	
	if (is_wp_error($tkt_tree_view_request)) {
		$tkt_tree_view_response = new WP_Error('plugins_api_failed', __('An Unexpected HTTP Error occurred during the API request.</p> <p><a href="?" onclick="document.location.reload(); return false;">Try again</a>'), $tkt_tree_view_request->get_error_message());
	} else {
		$tkt_tree_view_response = unserialize($tkt_tree_view_request['body']);
		
		if ($tkt_tree_view_response === false)
			$tkt_tree_view_response = new WP_Error('plugins_api_failed', __('An unknown error occurred'), $tkt_tree_view_request['body']);
	}
	
	return $tkt_tree_view_response;
}


add_filter('pre_set_site_transient_update_plugins', 'tkt_tree_view_check_for_plugin_updates');

// Take over the Plugin info screen
add_filter('plugins_api', 'tkt_tree_view_plugin_api_callback', 10, 3);
