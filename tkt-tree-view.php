<?php
/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://www.tukutoi.com/
 * @since             1.0.0
 * @package           Tkt_Tree_View
 *
 * @wordpress-plugin
 * Plugin Name:       TukuToi Hierarchical Posts Tree View
 * Plugin URI:        https://www.tukutoi.com/program/hierarchical-posts-tree/
 * Description:       WordPress Dashboard Widget displaying a Tree View of Hierarchical Pages or Posts.
 * Version:           1.0.3
 * Author:            bedas
 * Author URI:        https://www.tukutoi.com/
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       tkt-tree-view
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'TKT_TREE_VIEW_VERSION', '1.0.3' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-tkt-tree-view.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_tkt_tree_view() {

	$plugin = new Tkt_Tree_View();
	$plugin->run();

}
// This plugin only has Admin side functionality.
add_action( 'admin_init', 'run_tkt_tree_view' );
