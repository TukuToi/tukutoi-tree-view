<?php
/*
Plugin Name: ToolWine TreeView
Plugin URI: https://github.com/TukuToi/ToolWine-TreeView
Description: Tree View of Contents in WP Dashboard
Version: 0.1
Author: Beda Schmid
Author URI: https://profiles.wordpress.org/bedas
Text Domain: toolwine-tree-view
*/


/**
 * Register Widget
 * @todo Make it so that you can register a View with a specific Slug ({toolwine-tree-view-slug-n}), where n is a number. Then the code should automatically add a new Widget for each such View added with incremented n value
 */
function toolwine_dashboard_widget_tree_view() {

	wp_add_dashboard_widget(
                 'toolwine_dashboard_widget_tree_view',         // Widget slug.
                 'TreeView',         // Title.
                 'toolwine_dashboard_widget_tree_view_function' // Display function.
        );	
}
add_action( 'wp_dashboard_setup', 'toolwine_dashboard_widget_tree_view' );


/**
 * Create the function to output the contents of our Dashboard Widget.
 * @todo Make it so that you can register a View with a specific Slug ({toolwine-tree-view-slug-n}), where n is a number. Then the code should automatically add a new Function to call the View and populate the above created new Widget.
 */
function toolwine_dashboard_widget_tree_view_function() {

	$args = array(
	    'title' => 'Pages',
		);
	echo render_view( $args );
}
