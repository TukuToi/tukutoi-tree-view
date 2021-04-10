<?php

//Do not access directly
if (!defined('ABSPATH')) exit;

function tkt_enqueue_styles_and_scripts(){
	$screen = get_current_screen();
	if ( 'dashboard' === $screen->id ) {
		wp_enqueue_script( 'tkt_tree_view_scripts', PLUGIN_DIR_PATH . 'assets/js/script.js', array( 'jquery' ), '1.0', true );
		wp_enqueue_style( 'tkt_tree_view_styles', PLUGIN_DIR_PATH . 'assets/css/style.css', array(), '1.0' );
	}
}

function tkt_tree_view_posts($post_type = 'page'){
	
	$post_type = apply_filters( 'tkt_tree_view_posts_type', $post_type );
	
	if ($post_type == 'page') {
		$all_posts = get_pages();
	}
	else {
		$args = array(
		  'numberposts' => -1,
		  'post_type' => $post_type
		);
		 
		$all_posts = get_posts( $args );
	}
	return $all_posts;
}

function tkt_render_tree_view_widget_info_header($post_type){
	$tkt_header_info_text = '<h3>Complete list of Parent '.ucfirst($post_type).' with their Children.</h3>';
	$tkt_header_info_text = apply_filters( 'tkt_render_tree_view_widget_infor_header_text', $tkt_header_info_text );
	return $tkt_header_info_text;
}

function tkt_render_tree_view_search(){
	$placeholder = 'Search for Pages';
	$placeholder = apply_filters( 'tkt_search_input_placeholder', $placeholder );
	$title = 'Type in a Page Title';
	$title = apply_filters( 'tkt_search_input_title', $title );
	$tkt_search_input = '<input type="text" id="tkt-search-input" onkeyup="tkt_search_on_the_fly_function()" placeholder="'.$placeholder.'" title="'.$title.'">';
	return $tkt_search_input;
}

function tkt_render_tree_view(){
	$out = tkt_build_tree_view_html(tkt_tree_view_posts());
	return $out;
}

function tkt_build_tree_view_html($all_posts_in_type){
	$tkt_build_tree_view_html = '';
	foreach ($all_posts_in_type as $post) {
		if($post->post_parent == '') {
			$parent = '<a class="tkt-parent-link" href="'.get_edit_post_link($post).'"><span class="tkt-edit-icon dashicons dashicons-edit"></span>'.$post->post_title.'</a>';
			$children = wp_list_pages( array('child_of'=>$post->ID,'title_li'=>'', 'depth'=> -1,'echo'=>false, 'link_before'=>'<span class="tkt-edit-icon dashicons dashicons-edit"></span>', 'sort_column'=>'post_parent') );
			$tkt_build_tree_view_html .= '<div class="tkt_tree_view_parent_item active">'.$parent.'</div><div class="child"><ul class="tkt-searchable-contents">'.$children.'</ul></div>';
		}
	}
	return $tkt_build_tree_view_html;
}
