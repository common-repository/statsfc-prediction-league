=== StatsFC Prediction League ===
Contributors: willjw
Donate link:
Tags: widget, football, soccer, score, predictor, prediction, league, premier league, fa cup, league cup, champions league, europa league, uefa
Requires at least: 3.3
Tested up to: 6.2.2
Stable tag: 2.0.1
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

This widget will place a prediction league for a competition of your choice on your website.

== Description ==

Add a prediction league to your WordPress website. To request a key sign up for your free trial at [statsfc.com](https://statsfc.com).

For a demo, check out [wp.statsfc.com/prediction-league](https://wp.statsfc.com/prediction-league/).

= Translations =
* Bahasa Indonesia
* Dansk
* Deutsch
* Eesti
* Español
* Français
* Hrvatski Jezik
* Italiano
* Magyar
* Norsk bokmål
* Slovenčina
* Slovenski Jezik
* Suomi
* Svenska

== Installation ==

1. Upload the `statsfc-prediction-league` folder and all files to the `/wp-content/plugins/` directory
2. Activate the widget through the 'Plugins' menu in WordPress
3. Drag the widget to the relevant sidebar on the 'Widgets' page in WordPress
4. Set the StatsFC key and competition. If you don't have a key, sign up for free at [statsfc.com](https://statsfc.com)

You can also use the `[statsfc-prediction-league]` shortcode, with the following options:

* `key` (required): Your StatsFC key
* `id` (required): The ID of your Prediction League. You will need to set this up in your Stats FC account
* `timezone` (optional): The timezone to convert match times to, e.g., `Europe/London` ([complete list](https://php.net/manual/en/timezones.php))

== Frequently asked questions ==



== Screenshots ==



== Changelog ==

= 2.0.1 =
* Hotfix: Check options exist before using them

= 2.0.0 =
* Feature: Allow timezone to be set
* Feature: *Breaking change:* Changed the competition ID parameter to a league ID

= 1.2.1 =
* Hotfix: Check the before/after widget/title bits exist before using them

= 1.2.0 =
* Feature: Added multi-language support. If you're interested in translating for us, please get in touch at [hello@statsfc.com](mailto:hello@statsfc.com)

= 1.1.0 =
* Feature: Use built-in WordPress HTTP API functions

== Upgrade notice ==

= 2.0.0 =
This update has a breaking change. You will now need to set the Prediction League ID (you can get this from your Stats FC account) instead of the Competition Key.
