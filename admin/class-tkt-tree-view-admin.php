<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://www.tukutoi.com/
 * @since      1.0.0
 *
 * @package    Tkt_Tree_View
 * @subpackage Tkt_Tree_View/admin
 */

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, shortname,
 * enqueues the admin-specific stylesheet and JavaScript, as well as builds the query for,
 * and builds/renders the Hierarchical Posts Tree Widget.
 *
 * @package    Tkt_Tree_View
 * @subpackage Tkt_Tree_View/admin
 * @author     bedas <hello@tukutoi.com>
 */
class Tkt_Tree_View_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The Short Name of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_short    The Short Name of this plugin used to prefix.
	 */
	private $plugin_short;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * The Widgets of this Plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      array    $widgets    Determines post types queried by, and names of the widgets.
	 */
	private $widgets;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string $plugin_name       The name of this plugin.
	 * @param      string $plugin_short      The shortname of this plugin.
	 * @param      string $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $plugin_short, $version ) {

		$this->plugin_name  = $plugin_name;
		$this->plugin_short = $plugin_short;
		$this->version      = $version;

		$this->widgets  = array( 'page' => 'Pages' );

	}

	/**
	 * Check for capabilities.
	 *
	 * @since    1.0.0
	 * @return  bool   $is_admin_logged_in  Either abort or return true.
	 */
	private function caps_check() {

		$is_admin_logged_in = false;

		if ( is_admin() && ( current_user_can( 'manage_options' ) || current_user_can( 'manage_network_options' ) ) ) {

			$is_admin_logged_in = true;

		} else {
			return;
		}

		return $is_admin_logged_in;

	}

	/**
	 * Get a healthy instance of the Widgets.
	 *
	 * @since    1.0.0
	 * @return  array   $widgets  Sanitised array of widgets.
	 */
	private function get_widgets() {

		$widgets = array_map( 'sanitize_text_field', $this->widgets );

		return $widgets;

	}

	/**
	 * Modify default pagination.
	 *
	 * @since    1.0.0
	 * @return  array   $pagination  Sanitised modified pagination default with number pages and offset.
	 */
	private function get_amount_per_page() {

		$per_page   = isset( $_GET['_per_page'] ) ? intval( $_GET['_per_page'] ) : 100;
		$offset     = isset( $_GET['_offset'] ) ? intval( $_GET['_offset'] ) : 0;

		$pagination = array(
			'per_page' => $per_page,
			'offset' => $offset,
		);

		return $pagination;

	}

	/**
	 * Get all Posts of defined type.
	 *
	 * @since    1.0.0
	 * @param   string $post_type  The post Type to query.
	 * @return  array   $all_posts  All Posts found by get_pages or get_posts.
	 */
	private function tree_view_posts( $post_type ) {

		$all_posts = array();

		if ( 'page' == $post_type ) {

			$all_posts = get_pages(
				array(
					'offset'    => $this->get_amount_per_page()['offset'],
					'number'    => $this->get_amount_per_page()['per_page'],
				)
			);

		} else {

			$args = array(
				'numberposts' => $this->get_amount_per_page()['per_page'],
				'offset'    => $this->get_amount_per_page()['offset'],
				'post_type' => $post_type,
			);

			$all_posts = get_posts( $args );

		}

		return $all_posts;

	}

	/**
	 * Header Text for Widget.
	 *
	 * @since    1.0.0
	 * @param   string $post_type  the Post Type to query.
	 * @return  string  $tkt_header_info_text   The text used for Widget Header.
	 */
	private function render_tree_view_widget_info_header( $post_type ) {

		// Translators: %s is the Name of a Post Type.
		$tkt_header_info_text = '<h3>' . sanitize_text_field( sprintf( __( 'Complete list of Parent %s with their Children.', 'tkt-tree-view' ), ucfirst( $post_type ) ) ) . '</h3>';
		$tkt_header_info_text = apply_filters( $this->plugin_short . '_' . $post_type . '_widget_info_header_text', $tkt_header_info_text );
		$tkt_header_info_text = wp_kses( $tkt_header_info_text, 'post' );

		return $tkt_header_info_text;

	}

	/**
	 * Search Input Text for Widget.
	 *
	 * @since    1.0.0
	 * @param   string $post_type  The post Type queried.
	 * @return  string  $tkt_search_input   The text used for Widget Search Input.
	 */
	private function render_tree_view_search( $post_type ) {

		$placeholder = sanitize_text_field( __( 'Search for Pages', 'tkt_search_input' ) );
		$placeholder = apply_filters( $this->plugin_short . '_' . $post_type . '_widget_search_input_placeholder', $placeholder );
		$placeholder = sanitize_text_field( $placeholder );

		$title = sanitize_text_field( __( 'Type in a Page Title', 'tkt_search_input' ) );
		$title = apply_filters( $this->plugin_short . '_' . $post_type . '_widget_search_input_title', $title );
		$title = sanitize_text_field( $title );

		$tkt_search_input = '<input type="text" id="' . esc_attr( $this->plugin_short ) . '-' . esc_attr( $post_type ) . '-search-input" placeholder="' . esc_attr( $placeholder ) . '" title="' . esc_attr( $title ) . '">';

		return $tkt_search_input;

	}

	/**
	 * Widget HTML.
	 *
	 * @since    1.0.0
	 * @param   array  $all_posts_in_type    All Posts found in queried Post Type.
	 * @param   string $post_type  The post Type queried.
	 * @return  mixed   $tkt_build_tree_view_html   The Widget HTML output.
	 */
	private function build_tree_view_html( $all_posts_in_type, $post_type ) {

		$tkt_build_tree_view_html = '';

		foreach ( $all_posts_in_type as $post ) {

			if ( '' == $post->post_parent && true === $this->posts_have_children( $post ) ) {

				$parent = '<a class="' . esc_attr( $this->plugin_short ) . '-parent-link" href="' . get_edit_post_link( $post ) . '" target="_blank"><span class="' . esc_attr( $this->plugin_short ) . '-edit-icon dashicons dashicons-edit"></span>' . sanitize_text_field( $post->post_title ) . '</a>';

				$list_pages_args = array(
					'post_type'     => $post_type,
					'child_of'      => $post->ID,
					'title_li'      => '',
					'depth'         => 0,
					'echo'          => false,
					'link_before'   => '<span class="' . esc_attr( $this->plugin_short ) . '-edit-icon dashicons dashicons-edit"></span>',
					'sort_column'   => 'post_parent',
					'item_spacing'  => 'preserve',
				);

				add_filter( 'page_menu_link_attributes', array( $this, 'filter_wp_list_pages_link' ), 10, 5 );
				$children = wp_list_pages( $list_pages_args );
				remove_filter( 'page_menu_link_attributes', array( $this, 'filter_wp_list_pages_link' ), 10 );

				$tkt_build_tree_view_html .= '<div class="' . esc_attr( $this->plugin_short ) . '_parent_item ' . esc_attr( $post->post_name ) . ' active">' . $parent . '</div><div class="' . esc_attr( $this->plugin_short ) . '_child ' . esc_attr( $post->post_name ) . '"><ul class="' . esc_attr( $this->plugin_short ) . '-searchable-contents">' . $children . '</ul></div>';

			}
		}

		return $tkt_build_tree_view_html;

	}

	/**
	 * Test if there is at least a parent.
	 *
	 * @since    1.0.0
	 * @param   array $all_posts_in_type    All Posts found in queried Post Type.
	 * @return  bool    $has_parents    Checks if any of the posts have at least one parent.
	 */
	private function posts_have_parents( $all_posts_in_type ) {

		$has_parents = false;

		foreach ( $all_posts_in_type as $post ) {

			if ( '' != $post->post_parent ) {

				$has_parents = true;

				return $has_parents;

			}
		}

		return $has_parents;

	}

	/**
	 * Test if there is at least a child.
	 *
	 * @since    1.0.0
	 * @param   object $post    The Post tested.
	 * @return  bool    $has_child    Wether the post has any children.
	 */
	private function posts_have_children( $post ) {

		$has_children = false;

		$has_children = get_children(
			array(
				'post_parent'   => $post->ID,
				'post_type'     => $post->post_type,
				'numberposts'   => 1,
			),
			ARRAY_N
		);

		if ( ! empty( $has_children ) ) {
			$has_children = true;
		}

		return $has_children;

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 * @param   string $post_type  The post Type queried.
	 * @return  mixed $out the Widget HTML fully populated.
	 */
	private function render_tree_view( $post_type ) {

		$out = $this->build_tree_view_html( $this->tree_view_posts( $post_type ), $post_type );

		return $out;

	}

	/**
	 * Callback for page_menu_link_attributes filter.
	 *
	 * @since    1.0.0
	 * @see     class Walker_Page extends Walker
	 * @param array   $atts {
	 *       The HTML attributes applied to the menu item's `<a>` element, empty strings are ignored.
	 *
	 *     @type string $href         The href attribute.
	 *     @type string $aria_current The aria-current attribute.
	 * }
	 * @param WP_Post $page         Page data object.
	 * @param int     $depth        Depth of page, used for padding.
	 * @param array   $args         An array of arguments.
	 * @param int     $current_page ID of the current page.
	 * @return  array $atts Link attributes.
	 */
	public function filter_wp_list_pages_link( $atts, $page, $depth, $args, $current_page ) {

		$atts['href']   = get_edit_post_link( $page->ID );
		$atts['target'] = '_blank';

		return $atts;

	}

	/**
	 * Set current screen.
	 *
	 * WordPress get_current_screen is not ready on plugin initialisation.
	 * We need to hook it, so we can use it for our enqueue functions.
	 *
	 * @since    1.0.0
	 */
	public function set_current_screen() {

		$this->caps_check();

		$this->screen   = get_current_screen();

	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		if ( 'dashboard' === $this->screen->id ) {

			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/tkt-tree-view-admin.css', array(), $this->version, 'all' );

		}

	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		if ( 'dashboard' === $this->screen->id ) {

			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/tkt-tree-view-admin.js', array( 'jquery' ), $this->version, true );
			wp_localize_script(
				$this->plugin_name,
				$this->plugin_short . '_localised_object',
				array(
					'widgets' => $this->get_widgets(),
				)
			);

		}

	}

	/**
	 * Callback to build Tree View of Hierarchical Pages (build content of Widget)
	 *
	 * @since   1.0.0
	 * @param   mixed $widget     The Widget.
	 * @param   array $args   The Widget Arguments.
	 */
	public function dashboard_widget_content_callback( $widget, $args ) {

		$post_type = sanitize_text_field( $args['args'][0] );

		$kses_input = array(
			'input' => array(
				'type'          => 'text',
				'id'            => true,
				'placeholder'   => true,
				'title'         => true,
			),
		);

		if ( $this->posts_have_parents( $this->tree_view_posts( $post_type ) ) === true ) {

			echo '<div class="' . esc_attr( $this->plugin_short ) . '-description">';
			echo wp_kses( $this->render_tree_view_widget_info_header( $post_type ), 'post' );
			echo '</div>';
			echo '<div class="' . esc_attr( $this->plugin_short ) . '-search">';
			echo wp_kses( $this->render_tree_view_search( $post_type ), $kses_input );
			echo '</div>';
			echo '<div class="' . esc_attr( $this->plugin_short ) . '-max-height">';
			echo wp_kses( $this->render_tree_view( $post_type ), 'post' );
			echo '</div>';

		} else {

			// Translators: %s is the Name of a Post Type.
			echo wp_kses( sprintf( __( '<h4>You have no hierarchical %s. </h4>', 'tkt-tree-view' ), $post_type ), 'post' );
			// Translators: %s is a link to an external Documentation. Do NOT Translate.
			echo wp_kses( sprintf( __( 'You can query another post type if its hierarchic, by returning a valid post type with the %s filter. Or, connect some Pages hierarchically to see them here.', 'tkt-tree-view' ), '<a href="https://tukutoi.com/doc/tkt_treeview_post_type" target="_blank"><code>tkt_treeview_post_type</code></a>' ), 'post' );

		}

	}

	/**
	 * Register Widget for later displying Tree View of Hierarchical Pages
	 * Hooked to wp_dashboard_setup
	 *
	 * @link https://developer.wordpress.org/reference/functions/wp_add_dashboard_widget/
	 */
	public function tree_view_dashboard_widget() {

		$this->caps_check();

		$this->widgets = apply_filters( $this->plugin_short . '_widgets', $this->get_widgets() );

		foreach ( $this->widgets as $post_type => $post_name ) {

			// Translators: %s represents a Post Type Name.
			$widget_name    = sanitize_text_field( sprintf( __( 'Hierarchical %s Tree View', 'tkt-tree-view' ), ucfirst( $post_name ) ) );
			$widget_id      = sanitize_text_field( $this->plugin_short . '_' . $post_type . '_widget' );

			wp_add_dashboard_widget(
				$widget_id,
				$widget_name, // Title.
				array( $this, 'dashboard_widget_content_callback' ),
				null,
				array( $post_type )
			);

		}

	}

}
