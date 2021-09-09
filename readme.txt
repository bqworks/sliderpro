=== SliderPro ===
Contributors: bqworks
Tags: image slider, content slider, responsive slider, touch slider, carousel slider
Requires at least: 3.6
Tested up to: 5.8.1
Stable tag: 4.7.6
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Fully responsive and touch-enabled slider plugin for WordPress.

== Description ==

[Slider Pro](http://bqworks.net/slider-pro/) is a fully responsive and touch-enabled WordPress slider plugin that allows you to create professional and elegant sliders. This slider plugin was built with user experience in mind, providing a clean and intuitive user interface in the admin area and a smooth navigation experience for the end-users.

See a few examples on the [slider's presentation page](http://bqworks.net/slider-pro/).

Features:

* Fully responsive
* Touch support
* Change the slider's aspect and configuration based on screen size (using breakpoints)
* Load different images based on the size of the slider
* Animated and static layers, which can contain text, images or any HTML content
* Lightbox integration
* Full Width and Full Window support
* Carousel layout
* Auto height
* Lazy loading
* Deep linking
* Keyboard navigation
* Clean and intuitive admin interface
* Preview sliders directly in the admin area
* Drag and drop slide sorting
* Publish sliders in any post (including pages and custom post types), in PHP code, and widget areas
* Caching system for quick loading times
* Optimized file loading. The JavaScript and CSS files are loaded only in pages where there are sliders
* Load images and content dynamically, from posts (including custom post types), WordPress galleries and Flickr
* Action and filter hooks
* Import and export sliders

[These videos](http://bqworks.net/slider-pro/screencasts/) demonstrate the full capabilities of the plugin.

== Installation ==

To install the plugin:

1. Install the plugin through Plugins > Add New > Upload or by copying the unzipped package to wp-content/plugins/.
2. Activate the Slider Pro plugin through the 'Plugins > Installed Plugins' menu in WordPress.

To create sliders:

1. Go to Slider Pro > Add New and click the 'Add Panels' button.
2. Select one or more images from the Media Library and click 'Insert into post'. 
3. After you customized the slider, click the 'Create' button.

To publish sliders:

Copy the [sliderpro id="1"] shortcode in the post or page where you want the slider to appear. You can also insert it in PHP code by using <?php do_shortcode( '[sliderpro id="1"]' ); ?>, or in the widgets area by using the built-in Slider Pro widget.

== Frequently Asked Questions ==

= How can I set the size of the images? =

When you select an image from the Media Library, in the right columns, under 'ATTACHMENT DISPLAY SETTINGS', you can use the 'Size' option to select the most appropriate size for the images.

== Screenshots ==

1. Slider with text thumbnails and animated layers.
2. Slider with carousel layout and captions.
3. Slider with image thumbnails.
4. Slider with mixed content.
5. Slider with right-side thumbnails.
6. The admin interface for creating and editing a slider.
7. The preview window in the admin area.
8. The layer editor in the admin area.
9. The main image editor in the admin area.
10. Adding dynamic tags for sliders generated from posts.

== Changelog ==

= 4.7.0 =
* initial release on WordPress.org

= 4.7.1 =
* fix modal windows' display

= 4.7.2 =
* improve modal windows' display
* fixed some bugs

= 4.7.3 =
* fixed dynamic URL bug

= 4.7.4 =
* fixed layers' display option bug

= 4.7.5 =
* allow more HTML tags inside the slider

= 4.7.6 =
* fixed type of Width and Height from 'number' to 'mixed' to address validation issue