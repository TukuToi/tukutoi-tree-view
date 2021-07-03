=== TukuToi Hierarchical Posts Tree View ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: tree-view, hierarchical, pages, widget, classicpress
Requires at least: 4.9
Tested up to: 5.7
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Hierarchical Posts Tree Plugin adds a WordPress Dashboard Widget to display hierarchical Pages or any Hierarchical Post Type in an organised manner.

== Description ==

When you have a Hierarchical Post Type such as Pages, it is often difficult to keep track of the Hierarchy and the related Child Or Parent posts of a certain item.
In the WordPress posts list, when you search by a given Post, you won't see the related Parent or Child items connected to it, in the resulting posts list.
Thus you need to edit the post, to see what parent Posts it has. You still can't find its children post this way.

The TukuToi Hierarchical Posts Tree View Plugin adds a WordPress Dashboard Widget to display hierarchical Pages or Posts in a searchable list, which keeps showing the parent and child posts of the search result. 
Thus, it resolves this organzational problem.

By default, the Plugin queries the native WordPress Page post type, and it displays a (foldable and searchable) list of each Parent Pages Children posts. 
The entire list is searchable, and the search results will be highlighted. 
The entire "tree" of each search result will keep showing, thus allowing you to very easily find related parent or child posts of a search result.

Links to edit each page are integrated in the results, allowing for a quick navigation to edit each item in the list.

With filters, the post type to query can be changed to any hierarchical post type, and additional Widgets can be added (one each post type).

== Installation ==

1. Download and Install like any other WordPress plugin.
2. Activate the Plugin and navigate to the WordPress Dashboard to find the Widget.
3. If desired, alter the query using the adequate filter or add more widgets (see FAQ).

== Frequently Asked Questions ==

= How can I change the Post Type queried in the default Widget? =

Using the `tkt_htv_default_post_type` filter you can alter the Default Widget's Queried Post Type.
The filter accepts one argument, an array of Post Type Slug and Post Type name.
To change the default, first unset the existing array.

Example usage:
<pre><code>
add_filter('tkt_htv_default_post_type', 'my_default_post_type');
function my_default_post_type( $post_type ){

    unset($post_type);

    $post_type['post_type_slug'] = 'Post Type Name';

    return $post_type;

}
</code></pre>

= Can I have more than Widget, each Widget for a separate Hierarchical Post Type? =

Yes. You can use the `tkt_htv_widgets` filter to add as manu additional Widgets you want.
The filter accepts one argument, being an array of Post Type Slugs and Post Type Names.

Example Usage:
<pre><code>
add_filter('tkt_htv_widgets', 'my_additional_widgets');

function my_additional_widgets( $widgets ){

    $widgets['another-post-type'] = 'Another Post Type';
    $widgets['yet-another-post-type'] = 'Yet Another Post Type';

    return $widgets;

}
</code></pre>

= I do not see all my Hierarchical Posts in the Tree View =

This Plugin shows by default the first 100 Top Level Posts, and only if they have children.
Thus, to show more Posts, you can either use a filter to change the default amount of posts shown,
or paginate using URL parameters.

To paginate using URL paramters, you can use these URL params:
`_per_page` (`?_per_page=100`)
`_offset`   (`?_offset=100`)
For example, this query will show the next 100 posts:
`/?_per_page=100&_offset=100`

If you want to increase the amount of Posts shown by default, or the offset, you can use the filters documented here:
<a href="https://www.tukutoi.com/doc/tkt_htv_pagination_default">`tkt_htv_pagination_default`</a>
<a href="https://www.tukutoi.com/doc/tkt_htv_offset_default">`tkt_htv_offset_default`</a>

= I get the message "You have no hierarchical {Post Type} message" =

This can happen for 2 reasons:
- You indeed have not a single Post that has Children Posts.
- Or, you have more than 100 posts, and the first 100 Posts have no Children assigned.

In the first case, of course you need to assign some Posts as children to others.
In the second case, when you have children posts, but see no results, it is because of the Pagination.
By default, this plugin shows only the first 100 Top Level Posts that have children.
If it so happens that your first 100 Posts returned by the query have no children, you may use pagination and offset URL paramters,
in order to see the subsequent batches of results. For example, if your first Post with a Child is number 156 in the results, 
you would have to add these URL parameters to see the Post in the Widget:
`/?_per_page=100&_offset=100`

= What other filters are available? =

Check the Documentation <a href="https://www.tukutoi.com/doc/?wpv_post_search&wpv-relationship-filter=338&wpv_view_count=4635">here</a>

== Screenshots ==

1. Default Tree View Widget Showing Hierarchical Pages
2. Default Widget showing a Custom Hierarchical Post Type
3. The search results with complete "family tree"
4. Custom Widget added

== Changelog ==

= 1.0.2 =
* Optimised Performance
* Added Capabilites Checks

= 1.0.1 =
* Updated Features

= 1.0.0 =
* Initial Commit.