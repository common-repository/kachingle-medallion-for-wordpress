=== Kachingle Medallion for WordPress ===

Contributors: billsaysthis
Tags: kachingle, crowdfunding, micropayments, social, payment, micropayment, paypal
Requires at least: 2.9.2
Tested up to: 3.1
Stable tag: trunk
Donate link: none

Add a Kachingle Medallion to your blog so your regular readers can offer ongoing financial support with a single click! It's currently available in both English and German.

Add the Who's Kachingling Whom widget to show the world who puts their money where their mouse is to support your site and other voices in the Kachingle family.

== Description ==

Add a Kachingle Medallion to your blog so your regular readers can offer ongoing financial support with a single click! It's currently available in both English and German.

Add the Who's Kachingling Whom widget to show the world who puts their money where their mouse is to support your site and other voices in the Kachingle family.

= How the Kachingle Medallion works: =

* You create one or more Kachingle Medallions at Kachingle.com, then add the Plugin to your WordPress following the installation instructions.
* Once on your blog, the Medallion will be able to recognize registered users ("Kachinglers") who visit.
* When Kachinglers (who contribute $5/mo to support to their favorite sites) want to support your blog, they click your Medallion once, and it will count each day they visit thereafter.
* Once a month, each Kachingler's $5 is divvied up proportionally (based on daily visits) among the sites and content creators they support, including yours.
* Each Medallion includes links to pages that lists all your Kachinglers, their profiles, and how much they spend supporting your site and others.
* [Learn more about Kachingle and the Medallion.](http://kachingle.com/help/howto)

At Kachingle we are passionate about the value of online content and services, whether they be created by individuals, groups, or organizations. We also believe that because it takes real time, money, and insight to create and maintain valued online content and services, a business model for sustaining them must be available. Advertising, freemium, product sales, and subscription business models are partial answers, but Kachingle is a more direct mechanism that can complement these forms of revenue.

== Installation ==

<b>Note:</b> To use this plugin you'll need to have created a Kachingle account and at least one Medallion on [Kachingle.com](http://www.kachingle.com/).

If practical you should use the automated WordPress plugin installation process:

1. Go to the Add Plugin screen on your blog's Admin page
1. Enter 'Kachingle Medallion' into the search field
1. When the results are shown click the Install link and complete the wizard steps
1. Be sure you activate the plugin afterwards

Otherwise fall back to the manual install:

1. Upload all files to the `/wp-content/plugins/kachingle-medallion` directory
1. Activate the plugin through the 'Plugins' menu in WordPress

= Setup =

If you’ve created separate Medallion for various authors (or groups of authors) to display with their posts&mdash;go to the Kachingle Medallion Settings screen on your blog's Admin page, enter the separate Medallion numbers for each author who has one, and click the Save button.

= Add to Site =

= Sidebar Widgets =

Go to the Widgets screen on your blog's Admin page to:

* Add a Kachingle Medallion by dragging one into the Sidebar
* Add a Kachingle Who's Kachingling Whom widget by dragging one into the Sidebar

= Use the custom template tags in your templates: =

* For site-wide Medallions `<?php show_kachingle_medallion('YOUR MEDALLION NUMBER', '<b>Regular Reader?</b> Kachingle is a simple way to support my site and other sites you love', 'neoclassical'); ?>`
* For per-author Medallions `<?php show_kachingle_author_medallion(get_the_author_meta( 'ID' ), '<b>Fan of This Author?</b> Kachingle is a simple way to support this author, this site and other sites you love', 'neoclassical'); ?>`

= Add a shortcode to a blog post: =

* For site-wide Medallions `[kachingle_medallion medallion_no='YOUR MEDALLION NUMBER' stylename='neoclassical' msg='<b>Regular Reader?</b> Kachingle is a simple way to support my site and other sites you love']`
* For per-author Medallions `[ka_medallion author_id='AUTHOR ID' stylename='neoclassical' msg='<b>Fan of This Author?</b> Kachingle is a simple way to support this author, this site and other sites you love']`

== Frequently Asked Questions ==

= What is Kachingle? =

<b>Kachingle is an effortless way to support your favorite sites</b>, online publications, and blogs just by visiting those sites after becoming a Kachingler. 

Kachingle is also a way for Site Owners, apps, authors, artists, and other content creators to monetize their online content without resorting to paywalls, per-story "tipping" or other cumbersome, easily-bypassed (and traffic-killing) methods of revenue collection.

<b>Kachingle is also a social-networking system</b>‚ a way to share the sites and other content you love with colleagues, friends and family‚ building an online persona around your Kachingle contributions by enabling an optional automated Twitter feed of your kachingling (Facebook tools are coming soon as well) and linking to your Kachingle profile (called Sites I Visit) in your email signature or your profile on Facebook, LinkedIn, MySpace, etc.

Most importantly, <b>Kachingle is user-centric</b>. You, the Kachingler, the consumer of online content, determine the sites you want to support.

= How do I add Kachingle Medallions to my WordPress? =

Simple&mdash;Sign up for an account at [Kachingle.com](http://www.kachingle.com)then after your account is created, click the “Add Site” button on your Sites I Own tab, and follow the instructions.

= How can I get better results with Kachingle? =

Like most things, promotion and marketing are the key. Your early support will most likely come from your most regular readers and to go beyond them will necessitate action from you:

* Write a blog post about why you've added Kachingle and add the content to your About page (to keep the information easily accessible over time)
* If you use Twitter, tweet to your followers
* If you use Facebook, post about adding Kachingle to your wall

= How do I have Medallions shown in languages other than English? =

Currently the Kachingle Medallion is only available in English and German, though we're working on additional languages. The Kachingle Medallion will display in, say, German when loaded by a browser which has German set as the default language. Other visitors to your site will see the Medallion in English.

= How do I install multiple Medallions on the same page? =

You can:

* put multiple site-wide Medallion widgets in sidebars or other widget containers
* use the site-wide or per-author custom template tag to insert a Medallion into posts or pages at specific spots
* insert the site-wide or per-author shortcode into any posts or pages using any Medallion number as often as you like
* ANY combination of the above techniques

If you need separate Medallions for different sections of your site, you can create new Medallions at Kachingle.com and follow the same steps as you did with your first.

= In what sizes are the Medallion available? =

* Classical: 234 x 73 pixels
* Neoclassical: 160 x 75 pixels
* Jazz: 61 by 61 pixels

For most WordPress templates the Neoclassical style fits better in the sidebar, which is why neoclassical is the default value for this option. The Jazz style fits well embedded in posts (alongside other social buttons if you have them).

= Can I use HTML formatting for the marketing message displayed with my Medallions? =

You can in the widget and custom template tag methods but not in the shortcode&mdash;this is a security constraint imposed by WordPress. In the widget and template tag, you may use the following HTML tags for formatting:

* b/strong
* i/em
* a href (note that the href can only point to http and https URLs, not javascript or other protocols)

= How do I set Medallion numbers for each author on the blog? =

1. Once each author’s Medallion has been created at Kachingle.com, go to the Admin page
2. Under Settings, click the 'Kachingle Author Medallion Settings' link
3. Enter each Author's Medallion number in the respective input fields
4. Save

Be sure to add the custom template tag or shortcode where you want the per-author Medallions to be displayed on your templates or posts.

= What is the Who's Kachingling Whom widget? =

This widget shows the most recent visits by Kachinglersto their favorite sites and content. Each entry in the widget (which shows 6-7 at a time) includes:

* The Kachingler's name and avatar (which link to his or her Sites I Visit page)
* The name of the site (or other content) they kachingled (linked to a Kachingle page showing into about the site and its Kachinglers)
* The logo of site (linked to the site itself)

= What are the dimensions of the Who's Kachingling Whom widget? =

* Width: 200 pixels
* Height: 370 pixels

= Where can I find more information about Kachingle? =

[Kachingle Help](http://www.kachingle.com/help/overview)

== Screenshots ==

1. Medallion in Sidebar
2. Kachingle Author Medallions options page
3. Sample Author Archives page showing an author shortcode inside the post, the author template tag after the posts and the site-wide widget in the sidebar
4. Who's Kachingling Whom widget

== Changelog ==

= 1.4 =

* Added support for the new, smaller Jazz Medallion style
* Renamed narrow and wide Medallion styles to neoclassical and classsical, respectively (the old style names will continue to work for backwards compatibility)
* Removed the allowtransparency="true" attribute and the text only seen by browsers which do not support iFrames from the generated Medallion HTML
* Added the Who's Kachingling Whom widget

= 1.3 =

* New Options page for storing individual author Medallion numbers
* Added custom template tag and shortcode for individual author Medallions

= 1.2.1 =

* Fixed an issue in how widget is initialized

= 1.2 =

* Added support for multiple Medallions on same page
* No more options page, options set in the widget or passing parameters to shortcode or custom template tag

= 1.1.2 = 

* Fixed small bug due to Medallion style always being specified

= 1.1.1 = 

* Fixed small bug due to change in Medallion JavaScript file path

= 1.1 =

* Updated to new Medallion code, which supports multiple Medallions per page
* Removed the Special Expander option since the new code removes the need for it

= 1.0.2 =

* Updated README to better explain Kachingle service to WordPress audience

= 1.0.1 =

* Better position the Medallion when no marketing message is used

= 1.0 =

* Initial public release

== Upgrade Notice ==

= 1.4 =

* Added support for the new, smaller Jazz Medallion style
* Renamed narrow and wide Medallion styles to neoclassical and classsical, respectively (the old style names will continue to work for backwards compatibility)
* Removed the allowtransparency="true" attribute and the text only seen by browsers which do not support iFrames from the generated Medallion HTML
* Added the Who's Kachingling Whom widget

= 1.3 =

* New Options page for storing individual author Medallion numbers
* Added custom template tag and shortcode for individual author Medallions

= 1.2.1 =

* Fixed an issue in how widget is initialized (should correct conflicts with certain other plugins)

= 1.2 =

* Support for multiple Medallions on same page
* No more options page

= 1.1.2 = 

* Fixed small bug due to Medallion style always being specified

= 1.1.1 = 

* Fixed small bug due to change in Medallion JavaScript file path

= 1.1 =

* Updated to new Medallion code, which supports multiple Medallions per page

Please note that this version of the plugin only supports multiple instances of the same Medallion on a page, support for multiple Medallions where two or more medallion numbers are used will be in a forthcoming version.

= 1.0.2 =

* Updated README to better explain Kachingle service to WordPress audience 

= 1.0.1 =

* Better position the Medallion when no marketing message is used

= 1.0 =

* Initial release