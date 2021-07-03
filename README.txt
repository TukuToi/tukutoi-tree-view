=== TukuToi Tree View ===
Contributors: bedas
Donate link: https://www.tukutoi.com/
Tags: treeview, hierarchical, posts, pages, widget
Requires at least: 4.9
Tested up to: 5.7
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The Hierarchical Posts Tree Plugin adds a WordPress Dashboard Widget to display hierarchical Pages or any Hierarchical Post Type in an organised manner.

== Description ==

When you have a Hierarchical Post Type such as Pages, it is often difficult to keep track of the Hierarchy and the related Child Or Parent posts of a certain item.
In the WordPress posts list, when you search by a given Post, you won't see the related Parent or Child items connected to it, in the posts list.
Thus you need to edit the post, to see what parent Posts it has. You still can't find it's children post this way.

The TukuToi Hierarchical Posts Tree Plugin adds a WordPress Dashboard Widget to display hierarchical Pages or Posts in a searchable list, which keeps showing the parent and child posts of the search result. Thus, it resolves this organzational problem.

By default, the Plugin queries the native WordPress Page post type, and it displays a (foldable) list of each Page's Children posts. 
The entire list is searchable, and the search results will be highlighted. The entire "tree" of the search result will keep showing, thus allowing you to very easily find related parent or child posts of a search result.

Links to edit each page are integrated in the widget, allowing for a quick navigation to edit each item in the list.

With filters, the post type to query can be changed to any hierarchical post type.

== Installation ==

1. Download and Install like any other WordPress plugin.
2. Activate the Plugin and navigate to the WordPress Dashboard to find the Widget.
3. If desired, alter the query using the adequate filter (see FAQ)

== Frequently Asked Questions ==

= How can I change the Post Type queried in the Widget? =

Using the `tkt_treeview_post_type` filter you can alter the Queried Post Type.

Example usage:
<pre><code>
add_filter( 'tkt_treeview_post_type', 'change_the_post_type' );
function change_the_post_type($post_type){     

    $post_type = 'my-custom-post-type';//change this to the post type you want to query 

    return $post_type;

}
</code></pre>

== Screenshots ==

1. The Hierarchical Tree View Widget in action

== Changelog ==

= 1.0.2 =
* Optimised Performance
* Added Capabilites Checks

= 1.0.1 =
* Updated Features

= 1.0.0 =
* Initial Commit.