=== Cookie Confirm ===
Contributors: fishcantwhistle
Donate link: http://fishcantwhistle.com
Tags: cookie, confirm, consent, compliance, EU, preference, notification
Requires at least: 3.3.2
Tested up to: 3.3.2
Stable tag: 0.4

Cookie Confirm allows you to easily insert a customisable notification for your users to choose and save their cookie preferences.

== Description ==

By providing an unintrusive notification in a customisable location Cookie Confirm allows you to give your users the choice to accept cookies on your WordPress site.

When a visitor browses to a website with the Cookie Confirm plugin installed for the first time, they are shown a banner asking for their consent to cookies. The banner explains which cookies the website intends to set, and gives the visitor the option to consent or to deny each type of cookie. As well as being able to consent to cookies for the website they visited, the banner allows the visitor to consent to cookies for all websites which use the Cookie Confirm plugin.

If the visitor chooses to set preferences for all sites, we set third party cookies on our domain (cookieconsent.silktide.com) to remembers their choices. This cookies are completely anonymous, non-trackable, and are only used to remember the visitors preferences.

Each time a visitor browses to a website with the Cookie Confirm plugin installed, the plugin checks to see if they have set preferences for all sites. If so, it doesn't need to show the banner and the website already knows which sorts of cookies it is allowed to set.

Current features include-

* Customise position and style of notification
* Specify which type of cookie your site uses and customise the descriptions of these
* Choose from Explicit or Implicit consent
* Allow users to save their choice for all websites using the Cookie Consent software

Coming soon-

* Ability to customise all text strings
* Add your own cookie definitions
* Add proper support for SSL


== Installation ==

1. Upload the folder `cookie-confirm` to the `/wp-content/plugins/` directory keeping the file structure.
2. Activate the plugin through the 'Plugins' menu in WordPress
3. Customise your options through 'Settings' -> 'Cookie Confirm'

== Frequently Asked Questions ==

= How can I test that the plugin is working? =

Add the query parameter ?cctestmode=accept to accept all cookies regardless of settings.  Add the query parameter ?cctestmode=decline to decline all cookies regardless of settings.

For example: http://www.mycompliantsite.com/mypage.html would become http://www.mycompliantsite.com/mypage.html?cctestmode=decline

By using the decline option, you can conduct a manual cookie audit on your site and hopefully see that no intrusive cookies are being set (remember to clear your cookies first).

= Can I use my own 'privacy settings' link?  = 

If you like, you can define your own links to the privacy settings dialog.  Just create a link and add a class of cc-privacy-link.

`<a href="#">Privacy settings</a>`

You will probably want to use this in conjunction with the Hide Privacy Settings Tab option in 'Settings' -> 'Cookie Confirm'.

= Who made this awesome script? =

The original script was built by Skilltide and you can find more info here - http://silktide.com/cookieconsent. Fish Can't Whistle just turned it into a WordPress plugin.

= How much does it cost to use this service? =

Nothing! The good folks at Skilltide have made this a free project!

= Will using this plugin make my site EU Compliant =

Using Cookie Confirm is not a guarantee of compliance with the new law. You are responsible for the cookies which your website sets. This plugin is designed to help you gain consent for (and control the usage of) cookies on your website. After installing, you should carefully assess your use of cookies to ensure it complies with the new law and make sure you have an up-to-date privacy policy.

== Screenshots ==

1. The unobtrusive, customisable notification
2. The admin options area

== Changelog ==

= 0.1 =
* First release

= 0.2 =
* Fixed bug printing code at the bottom of pages

== Upgrade Notice ==

= 0.1 =

First release so no update

= 0.2 =

Fixed bug printing code at the bottom of pages