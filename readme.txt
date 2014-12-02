=== TrishZwei\'s Simple Custom Quotes ===
Contributors: trishzwei
Tags: quotes, testimonials
Requires at least: 3.0.1
Tested up to: 4.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Uses a widget to place a random quote or testimonial that you have created into your site.

== Description ==
This plugin creates a custom post type called \'quote\' that allows you to create a set of quotes or testimonials. To create a quote go to the dashboard and underneath posts you should find a post type called \"Quotes\". Click Add New and fill out the fields there.

There is a title region for the quote, so you can have control over the URL of the quote, but the title will not be shown. The editor area works like a normal, but the auto p tag has been stripped so that your quotes will fit nicely inside a blockquote tag. If you want breaks or paragraphs inside, you can set these as you will. The quotes are set inside a blockquote tag with no additional CSS, so it uses your theme\'s CSS automatically.

Below the editor you will find a post meta data field: Quote Attribution. This is where you would put who said the quote or testimonial. The attribution sits inside a span tag with a class of \"quote-attribution\" so that you can style it separately from the blockquote if you desire. If this field is left blank it and the span tag will not show.

To place a randomly generated quote or testimonial on your site, take the widget and move it into a widget area. Set a title for the widget if you want, create some quotes and you are all set. 

The quote post type has an archive called quotes, which will use your theme's default archive page to display its content. This is for your convienence so that you can ensure there are no duplicates.Since there are no categories, if your theme displays a \"filed under\" the value will be blank.

Your quotes content will be excluded from searches so that your quotes do not interfere with the regular content of your site.

You can see this plugin in action at: http://trishladd.com

== Installation ==

1. Upload `plugin-name.php` to the `/wp-content/plugins/` directory
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Add content to the quote custom post type
3. Place the  TZ Quotes Widget into a widget area.

== Frequently Asked Questions ==

= How do I add content? =
In the admin area underneath posts, there should be a new option entitled \"Quotes\" there should be an option to add new. Click on that, fill out the subsequent form and you will have a new quote.

= How do I have it shown on the site? =
In the admin area go to widgets. Select the TZ Quotes Widget, place it into the widget area you want to have it in, set the title (if you wish) the default is: Quote: but this can be easily changed.

= How do I use your quote generator as testimonials? =
Instead of a quote in the content, you put in what the testimonial said and the attribution would still be who said it. Additionally, you can change the title of the quote widget to something like Testimonial:

= What if I want both quotes AND testimonials? =
In and of itself at this time you cannot with this plugin alone since there is no way to categorize . This functionality would be added in a later version.

== Screenshots ==
1. This screen shot shows you the new quote creation process as mentioned in step 3 of installation. You can see where the custom post type is set in the admin menu and the fields you should fill out. screenshot-1.jpg

2. This screen shot shows you what the content looks like in a default post. You can also see the random quote set in the widget below the post. While these quote posts are public, they are not searchable. screenshot-2.jpg

3. This screen shot shows the posts in the quote archive. This is so you can review them in the archive to double check for duplicates and edit them quickly and easily. As mentioned before there are no special taxonomies (categories) associated with this post type so the value after filed under will be blank. While these quote posts are public, they are not searchable, so it would be unlikely that people looking at your site would come across this list unless you pointed them to this 'quotes' archive location. screenshot-3.jpg


== Changelog ==
*this plugin is brand new. Changes that are made to it will be noted here in the future.*