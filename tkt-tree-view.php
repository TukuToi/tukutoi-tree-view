<?php
/**
 * Plugin Name: TukuToi Tree View
 * Description: WordPress Dashboard Widget displaying a Tree View of Hierarchical Pages
 * Plugin URI: https://github.com/TukuToi/ToolWine-TreeView
 * Author: Beda Schmid
 * Author URI: https://tukutoi.com
 * Version: 1.0.0
 * License: GPL2
 * Text Domain: tkt_tree_view
 */

//Do not access directly
if (!defined('ABSPATH')) exit;

if (!defined('PLUGIN_DIR_PATH')) {
	define('PLUGIN_DIR_PATH', plugin_dir_url( __FILE__ ));
}

include_once(plugin_dir_path(__FILE__).'Application/tkt-functions.php');
add_action( 'admin_enqueue_scripts', 'tkt_enqueue_styles_and_scripts' );

include_once(plugin_dir_path(__FILE__).'widget.php');
add_action( 'wp_dashboard_setup', 'tkt_tree_view_dashboard_widget' );

include_once(plugin_dir_path(__FILE__).'update.php');
