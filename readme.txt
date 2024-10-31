=== Facebook Photo Album ===
Contributors: ram108
Donate link: http://www.ram108.ru/donate
Tags: facebook, photo, photos, album, slider, image, images, gallery, media, picasa, flickr, pinterest, instagram, widget, shortcode, ram108, lightbox, colorbox, fancybox, thickbox
Requires at least: 3.3.3
Tested up to: 3.7.1
Stable tag: 0.5.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

The plugin brings Facebook Photo Albums to your WordPress site. Now with Facebook slider!

== Description ==

**Easy way to add Facebook photos to your site**. Includes widget, shortcode and Facebook slider. Made with love for everyone.

= NEW with version 0.5 =

* Share Facebook personal profile photos (to do this visit plugin settings page) 
* Mark Facebook photos with #hide tag to exclude from display on your site

= Plugin features =

* Use widget or Easy plugin button to post Facebook albums on your site
* Display Facebook photos in album or slider style
* Choose from different thumbnail shapes and sizes
* Get random images from Facebook Timeline or any album
* Realtime updates from Facebook for installed albums
* Easy to use, SEO optimized, responsive layout
* It is free

[LIVE DEMO](http://www.ram108.ru/plugins/ram108-fbalbum/demo) — visit plugin home page.

= Why to use Facebook photo albums =

* No need to upload large files on your server. Save space and traffic
* Unlimited space to keep your photos. Post everything
* Facebook cloud network is very fast. Your photos will be served quickly
* Easy to create new albums, sort photos, add titles and descriptions
* Share your photos with Facebook Photo Album plugin

= Double image appearing or image not appearing on click =

Please read Troubleshooting section in FAQ.

= Translations =

English, Русский. Send your translations to the plugin author.

= Thank you =

If you are happy with plugin your feedback is very appreciated. **Rate plugin** (see stars at the right) in Wordpress plugin directory or **write review** on your blog. 

== Installation ==

1. Install and activate plugin through builtin WordPress plugin interface
1. Fill 'Facebook Connect' in settings page to access to personal timeline photos
1. Use widget or Easy plugin button to post Facebook albums into your site
1. [Read FAQ](../faq) to know more

== Frequently Asked Questions ==

= How to find Album URL =

Navigate to any Facebook page → Open 'Photos' tab → Choose 'Albums' → Click an album you would like to post to your site. Copy an Album URL from the browser navigation bar. 

Example of Album URL: 
`https://www.facebook.com/media/set/?set=a.543768855700007.1073741836.495358777207682&type=3`

Don't put shortcode in Album URL. This is not Album URL: 
`[fbalbum url=https://www.facebook.com/media/set/?set=a.543768855700007.1073741836.495358777207682&type=3]`

To get latest photos of Page Timeline, choose 'Timeline Photos' in 'Albums' tab. The plugin will refresh posted albums every 6 hours (you can change it in plugin settings page).

If you want Facebook Photo Album plugin to access to your **personal timeline photos**, visit plugin settings page and fill 'Facebook Connect' section.

= Easy plugin button in Wordpress editor =

Create new or open to edit any post in Wordpress. Use Easy plugin button in Wordpress editor to install albums into your post.

= Widget =

Open Wordpress widgets page. From the available widgets choose '[ram108] Facebook Photo Album' and drag and drop it to widget area. 

Add title, Album URL, number of images to show. Choose 'Random pick' if you want to get random photos. 'Add hidden images' will post more images from Facebook that will be visible in popup only. Select 'Slider style' to get a slider.

= Shortcode =

This information is for advanced users. You don't need to use shortcode manually with Facebook Photo Album plugin. What is shortcode you can read [here](http://codex.wordpress.org/Shortcode).

Get all photos from the album:
`[fbalbum url=https://www.facebook.com/media/set/?set=a.543768855700007.1073741836.495358777207682&type=3]`

Choose how many photos to display:
`[fbalbum url=... limit=30]` 

Post album title and description from Facebook:
`[fbalbum url=... desc=1]`

Display random photos from the album:
`[fbalbum url=... limit=10 random=1]`

Specify thumbnail size:
`[fbalbum url=... size=160]`

Specify thumbnail shape (0=Rectangular, 1=Square, 2=Circle):
`[fbalbum url=... shape=1]`

Display album is slider style:
`[fbalbum url=... slider=1]`

= Troubleshooting =

***Double image appearing or image not appearing*** on click. Facebook Photo Album plugin comes with builtin Fancybox script. Disable builtin Fancybox in plugin settings page or deactivate installed lightbox, colorbox or prettyPhoto plugin in Wordpress plugins page.

***Facebook error response: Unsupported get request***. If you fill 'Facebook connect' section and try to access to YOUR personal profile photos but still get this error, contact plugin author for help.

= Contacts =

My name is Kirill Borodin and I am developer from Russia. For any questions, suggestions or plugin assistance feel free to contact me at plugin@ram108.ru

== Screenshots ==

1. Facebook Photo Album widget
2. Easy plugin button in Wordpress editor
3. Easy plugin button dialog box
4. Plugn settings page in Wordpress Dashboard
5. Example with different types of Facebook albums installed

== Changelog ==

= 0.5.1 = 
* Maintenance release

= 0.5 =
* Access to personal profile photos
* Do not display #hide tagged images
* Albums refresh time in settings page
* Plugin news widget in settings page
* Broken HTML slider fix (issue report http://wordpress.org/support/topic/destroy-posts-with-shortcodes)

= 0.4.9 =
* Use Wordpress Transients API instead of APC cache
* Fancybox fix (html & z-index)
* short_open_tag fix

= 0.4.8.1 =
* Option: Hide Facebook button in widget
* Fancybox CSS fix

= 0.4.8 =
* Remove short_open_tag for compatibility support

= 0.4.7 = 
* Update Fancybox script
* Remove Facebook #tags from image description
* Minor fixes

= 0.4.6 =
* Slider CSS fix

= 0.4.5 = 
* Translation ready
* English & Russain translations
* Hide wp_remote_get error message if not admin
* HTML makeup change to stop double image appearing

= 0.4 =
* Facebook slider
* Facebook like button
* Set user-agent in wp_remote_get
* Many minor fixes

= 0.3.1 =
* Enable builtin Fancybox by default
* Remove lightbox, colorbox & etc classes from HTML if Fancybox is enabled

= 0.3 =
* Plugin button in Wordpress editor
* Remove Facebook meta data in album description
* Use wp_remote_get instead of direct cURL request

= 0.2.3 =
* Drop APC cache on thumbnail size change

= 0.2.2 =
* Downgrade Fancybox to v.1 (v.2 is GPL incompatible)
* Fancybox options in settings page
* Hidden image fix
* Data transfer function fix

= 0.2.1 =
* Overall speed and memory usage improvements
* Fancybox fix
* External extensions fix

= 0.2 =
* Plugin settings page
* Different thumbnail sizes
* Rectangular, square, circle thumbnails
* Include of Fancybox script
* Improve image quality

= 0.1 =
* Initial release
