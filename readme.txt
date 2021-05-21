=== UCF Page Assets Plugin ===
Contributors: ucfwebcom
Tags: ucf, page assets
Requires at least: 4.7.5
Tested up to: 5.3
Stable tag: 1.0.5
License: GPLv3 or later
License URI: http://www.gnu.org/copyleft/gpl-3.0.html

Provides the ability to add a custom stylesheet and/or javascript file to individual pages.


== Description ==

Provides the ability to add a custom stylesheet and/or javascript file to individual pages or other registered post types.


== Installation ==

= Manual Installation =
1. Upload the plugin files (unzipped) to the `/wp-content/plugins` directory, or install the plugin through the WordPress plugins screen directly.
2. Activate the plugin through the "Plugins" screen in WordPress
3. Configure plugin settings from the WordPress admin under "Settings > UCF Page Assets".

= WP CLI Installation =
1. `$ wp plugin install --activate https://github.com/UCF/UCF-Page-Assets-Plugin/archive/master.zip`.  See [WP-CLI Docs](http://wp-cli.org/commands/plugin/install/) for more command options.
2. Configure plugin settings from the WordPress admin under "Settings > UCF Page Assets".


== Changelog ==

= 1.0.5 =
Enhancements:
* Modified filtering options for files that are selectable from the media library modal when choosing a CSS or JS file for a page/post.  Both CSS and JS will now be filtered by their respective file extensions by default (to filter out other files with the `text/plain` type), and JS filtering now includes the `text/javascript` type.
* Updated packages.

= 1.0.4 =
Bug Fixes:
* Fixed issue where css files and js files would not show up in the media library.

= 1.0.3 =
Bug Fixes:
* Corrected php warning where that is thrown when the global `$post` object is null.

= 1.0.2 =
Bugfixes:
* Added media library upload support for CSS and JS file types

= 1.0.1 =
Enhancements:
* Updated admin js logic to display asset filenames when a new file is selected
* Added mimetype filtering to the media library modal on asset fields (so only existing CSS files are shown when selecting a stylesheet, and JS files for the JS meta field)

Bugfixes:
* Fixed logic in `UCF_Page_Assets_Metabox::save_metabox()` that prevented empty meta values from updating at all, which prevented the removal of css/js files
* Added metabox display logic and a `delete_metadata` hook to prevent invalid/removed attachments from being referenced and/or displayed on the frontend
* Fixed plugin name in readme
* Fixed undefined index notice on New Post screen
* Fixed issue with admin js not being loaded on the New Post screen

= 1.0.0 =
* Initial release


== Upgrade Notice ==

n/a


== Installation Requirements ==

None


== Development & Contributing ==

NOTE: this plugin's readme.md file is automatically generated.  Please only make modifications to the readme.txt file, and make sure the `gulp readme` command has been run before committing readme changes.
