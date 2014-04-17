<?php
/*
Plugin Name: Pronamic Photo Contest
Plugin URI: http://www.happywp.com/plugins/pronamic-photo-contest/
Description: The Pronamic Photo Contest plugin allows you to setup an photo contest on your WordPress site. 
 
Version: 1.0.1
Requires at least: 3.0

Author: Pronamic
Author URI: http://www.pronamic.eu/

Text Domain: pronamic_photo_contest
Domain Path: /languages/

License: GPL

GitHub URI: https://github.com/pronamic/wp-pronamic-photo-contest
*/

require_once dirname( __FILE__ ) . '/classes/Pronamic_WP_PhotoContestPlugin.php';
require_once dirname( __FILE__ ) . '/classes/Pronamic_WP_PhotoContestPlugin_Admin.php';
require_once dirname( __FILE__ ) . '/classes/Pronamic_WP_PhotoContestPlugin_LatestEntriesWidget.php';

global $pronamic_photo_contest_plugin;

$pronamic_photo_contest_plugin = new Pronamic_WP_PhotoContestPlugin( __FILE__ );
