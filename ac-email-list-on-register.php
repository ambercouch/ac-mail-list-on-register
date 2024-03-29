<?php
/*
  Plugin Name: AC email list on register
  Plugin URI: https://github.com/ambercouch/ac-wp-simple-modal
  Description: Add your user to Sendinblue when they register
  Version: 0.1.0
  Author: AmberCouch
  Author URI: http://ambercouch.co.uk
  Author Email: richard@ambercouch.co.uk
  Text Domain: acelr
  Domain Path: /lang/
  License:
  Copyright 2018 AmberCouch
  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License as published by
  the Free Software Foundation; either version 2 of the License, or
  (at your option) any later version.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
 */

//echo 'momento mori';
////
////$options = get_option('acelr_sib_key');
////// output the title
////var_dump($options);
////die();

defined('ABSPATH') or die('You do not have the required permissions');

require_once(__DIR__ . '/vendor/autoload.php');

define('ACSIBR_KEY', get_option('acelr_sib_key'));
define( 'AC_EMAIL_LIST_ON_REGISTRATION_PLUGIN_VERSION', '1.0.0' );

// Define path and URL to the ACF plugin.
//define( 'MY_ACF_PATH', 'inc/acf/' );
//define( 'MY_ACF_URL', plugin_dir_url( __FILE__ ) . 'inc/acf/' );

// Include the testimonial custom post type.
//require_once(  'lib/cpt.php' );

// Include the ACF plugin.
//require_once( MY_ACF_PATH . 'acf.php' );

// Include the testimonial custom fields.
//require_once(  'lib/acsm-acf.php' );

// Customize the url setting to fix incorrect asset URLs.
//add_filter('acf/settings/url', 'my_acf_settings_url');
function my_acf_settings_url( $url ) {
    // return MY_ACF_URL;
}

// (Optional) Hide the ACF admin menu item.
//add_filter('acf/settings/show_admin', 'my_acf_settings_show_admin');
function my_acf_settings_show_admin( $show_admin ) {
    //return false;
}

// Include the plugin-code.
require_once(  'lib/acelr.php' );













