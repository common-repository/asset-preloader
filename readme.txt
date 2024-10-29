=== Asset Preloader: preload the assets only on the pages where you need it ===
Tested up to: 6.5
Stable tag: 0.0.7
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Contributors:      giuse
Requires at least: 4.6
Requires PHP:      5.6
Tags:              speed optimization, performance, rendering, http requests order


Decide which assets you want to preload depending on the page.


== Description ==

Decide which assets you want to preload depending on the page.
If a specific page needs a specific asset before others, you should preload it only on that page, not everywhere.
This plugin gives you the possibility to preload assets per page.
You will find a section in each single page and post in the backend, but also a global settings page where you can decide the assets that you want to preload everywhere.

== How to preload a specific asset only on a specific page ==
* Install Asset Preloader
* Go to that single page in the backend, and add the URL of the asset in the textarea that you see below Asset Preloader

== How to preload a specific asset on all pages ==
* Install Asset Preloader
* Go to Asset Preloader
* Add the URL of the asset in the textarea that you see in the global settings

== Other useful plugins to speed up the rendering of the page ==
* <a href="https://wordpress.org/plugins/freesoul-deactivate-plugins/" target="_blank">Freesoul Deactivate Plugins</a>
* <a href="https://wordpress.org/plugins/inline-image-base64/" target="_blank">Inline Image Base64</a>


For better speed performance, of course, don't forget to use a caching plugin like  <a href="https://wordpress.org/plugins/w3-total-cache/">W3 Total Cache</a>, <a href="https://wordpress.org/plugins/wp-fastest-cache/">WP Fastest Cache</a>, <a href="https://wordpress.org/plugins/wp-optimize/">WP Optimize</a>, <a href="https://wordpress.org/plugins/comet-cache/">Comet Cache</a>, <a href="https://wordpress.org/plugins/cache-enabler/">Cache Enabler</a>, <a href="https://wordpress.org/plugins/hyper-cache/">Hyper Cache</a>, <a href="https://wordpress.org/plugins/wp-super-cache/">WP Super Cache</a>, <a href="https://wordpress.org/plugins/litespeed-cache/">LiteSpeed Cache</a>, <a href="https://wordpress.org/plugins/sg-cachepress/">SiteGround Optmizer</a>
Some of the amazing plugins above give you also the opportunity to preload assets, but not per page. This is why we created Asset Preloader.

== Help ==
If you have questions or something doesn't work as expected don't hesitate to open a thread on the <a href="https://wordpress.org/support/plugin/asset-preloader/" target="_blank">Support Forum</a>

== Changelog ==

= 0.0.7 =
*Enhanced: Example in the backend

= 0.0.6 =
*Checked: WordPress v. 6.4

= 0.0.5 =
*Fix: conflict with WPML

= 0.0.4 =
*Fix: post meta not working if global settings are empty

= 0.0.3 =
*Fix: error when saving global settings

= 0.0.2 =
*Fix: meta data not saved in the single backend pages

= 0.0.1 =
*Initial release
