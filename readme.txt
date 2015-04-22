=== Facebook Like To Reveal ===
Contributors: Tips and Tricks HQ, wptipsntricks
Donate link: https://www.tipsandtricks-hq.com/
Tags: wordpress, facebook, like, social, fb, facebook platform, friends, like button, open graph, page, plugin, posts, publish Facebook, sidebar, Social Plugins 
Requires at least: 3.5
Tested up to: 4.1
Stable tag: 1.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Add Facebook Like Button to a post or page and increase the number of likes by revealing a special message to the users.

== Description ==

Facebook Like to Reveal plugin allows you to add facebook like buttons to your website using shortcodes. The difference between this plugin and a normal facebook like plugin is that you can specify a hidden message inside a shortcode which will get revealed when a user likes it. It can be a coupon, discount code, serial key etc. This is a great incentive for users to like your posts/pages.

= Features = 

* Easily embed a shortcode to create a Facebook Like Button
* Add custom messages to the Facebook like window
* Offer special discount or coupon code in the like shortcode
* Use both simple and special like buttons
* No configuration required
* Lightweight and user-friendly setup with shortcodes
* Add SEO value to your content by increasing Facebook likes
* Compatible with WordPress Multi-site Installation
* It works great with a responsive WordPress theme
* Can be translated into any language

= Usage = 

Insert the following shortcode into a post/page to create a special Facebook like button:

`[fb_like_to_reveal message="your message" url="URL of the resource that you want to give a like"]`

Description of attributes:

"message"
    Displays a message inside the popup window when a like button is clicked.

Example:

    `[fb_like_to_reveal]` - creates a like button without a message.
    `[fb_like_to_reveal message="your message"]` - creates a like button with a message inside the like window

== Installation == 

1. Upload the `facebook-like-to-reveal` folder to `/wp-content/plugins/` directory.
2. Activate the plugin from the 'Plugins' menu on your WordPress admin dashboard.
4. Create a page or a post and insert the shortcode [fb_like_to_reveal] to add a like button.

== Frequently Asked Questions ==

= How can I add a Facebook Like button to my website? =

You can copy and paste the shortcode `[fb_like_to_reveal]` into your page or post.

= When I click on the button It does not show the message that I specified in the shortcode.

The URL that you have specified in the shortcode might be different from the one where you inserted the shortcode.

= Is it possible to insert the shortcode into a PHP file using the function do_shortcode( 'fb_like_to_reveal' )?

Yes

= How can I change the look of the button?

Unfortunately, It is not possible since the plugin uses the standard Facebook API to provide this functionality.

== Screenshots == 

1. Facebook like button
2. Hidden message revealed when the like button is clicked

== Upgrade Notice ==
none

== Changelog == 

= 1.0.1 = 
* First Commit