# ToolWine-TreeView
Tree View of Contents displayed with Toolset in the WP Admin Dashboard

# Usage
This plugin *requires* that you create a view with the slug `pages` and title `Pages` BEFORE you activate the plugin. That View should return a List of pages that have no parent. In that View loop you need to include as many Views as you have sublevels of pages.

Those Views need to have a specific Filter set: `Select posts whose parent is the current post in the loop.`, while the View with given slug `pages` needs to have this Querey Filter: `Select top-level posts with no parent.`

For ease, just import [https://www.dropbox.com/s/qhtnox7dz7glmeq/stable.views.2018-09-12.zip?dl=0 this 3 Views] and add some Pages with 2 levels of sub pages (if you have more levels you need to add more views...)

# Future Plans

Wine, and maybe some more stuff.

This is an experimental product.

Use at your own risk.
