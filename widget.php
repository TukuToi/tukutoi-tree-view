<?php

//Do not access directly
if (!defined('ABSPATH')) exit;



/**
 * Register Widget for later displying Tree View of Hierarchical Pages
 * Hooked to wp_dashboard_setup
 *
 * @link https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/
 */
function tkt_treeview_dashboard_widget() {
	$post_type = 'Page';
	$post_type = apply_filters( 'tkt_treeview_posts_type', $post_type );
	$name = 'Hierarchical ' . ucfirst($post_type) . ' Tree View';
	wp_add_dashboard_widget(
		'tkt_treeview_dashboard_widget',// Widget slug.
		$name,// Title.
		'tkt_treeview_dashboard_widget_content_callback'// Display function.
	);	
}

/**
 * Callback to build Tree View of Hierarchical Pages (build content of Widget)
 */
function tkt_treeview_dashboard_widget_content_callback() {

	if (tkt_treeview_posts()) {
		echo '<div class="tkt-treeview-description">';
		echo tkt_render_tree_view_widget_info_header($post_type = apply_filters( 'tkt_treeview_posts_type', 'Pages' ));
		echo '</div>';
		echo '<div class="tkt-treeview-search">';
		echo tkt_render_tree_view_search();
		echo '</div>';
		echo '<div class="tkt-tree-view-max-height">';
		echo tkt_render_tree_view();
		echo '</div>';
	}
	else {
		echo '<h4>You have no hierarchical pages.</h4>';
		echo 'You can query another post type if its hierarchic, by returning a valid post type with the <a href="https://tukutoi.com/doc/tkt_treeview_posts_type">tkt_treeview_posts_type filter</a>.<br>Or, connect some Pages hierarchically to see them here.';
	}

}
