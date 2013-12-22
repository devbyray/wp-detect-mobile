<?php
/*
Plugin Name: WP Detect Mobile
Plugin URI: http://www.webmediahelden.nl
Description: Add body class mobile, tablet or desktop
Version: 1.0
Author: Web Media Helden
Author Email: raymon@webmediahelden.nl
License:

  Copyright 2013 Web Media Helden (raymon@webmediahelden.nl)

  This program is free software; you can redistribute it and/or modify
  it under the terms of the GNU General Public License, version 2, as 
  published by the Free Software Foundation.

  This program is distributed in the hope that it will be useful,
  but WITHOUT ANY WARRANTY; without even the implied warranty of
  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
  GNU General Public License for more details.

  You should have received a copy of the GNU General Public License
  along with this program; if not, write to the Free Software
  Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
  
*/

// Here are all the functions of the shortcodes
require_once('mobile-detect.php');

$detect = new wp_Mobile_Detect();


//* Add custom body class to the head
add_filter( 'body_class', 'wp_md_body_class' );

function wp_md_body_class( $classes ) {
  $classes[] = wp_md_device_classes();

  $classes[] = wp_md_mobile_classes();
  $classes[] = wp_md_tablet_classes();

  // $classes[] = wp_md_iphone_classes();

  $classes[] = wp_md_android_classes();
  $classes[] = wp_md_ios_classes();
  return $classes;
}

// add_action( 'wp_footer', 'wp_md_report_class' );

function wp_md_report_class() {
  $classes[] = wp_md_device_classes();

  $classes[] = wp_md_mobile_classes();
  $classes[] = wp_md_tablet_classes();

  // $classes[] = wp_md_iphone_classes();

  $classes[] = wp_md_android_classes();
  $classes[] = wp_md_ios_classes();
  echo '<div class="wp_md_device_report">';
  foreach ($classes as $class) {
    echo '<strong>'.$class.'</strong>, ';
  }
  echo '</div>';
}


function wp_md_device_classes() {
    global $detect;
    $deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'is-tablet-device' : 'is-phone') : 'is-computer');
    return ' dt-'.$deviceType;
}

function wp_md_mobile_classes() {
    global $detect;
    if($detect->isMobile() == true){
      return 'dt-is-mobile';
    } else {
      return 'dt-no-mobile';
    }
}

// Used for themes
function is_mobile_detect() {
    global $detect;
    if($detect->isMobile() == true){
      return true;
    } else {
      return false;
    }
}

function wp_md_tablet_classes() {
    global $detect;
    if($detect->isTablet() == true){
      return 'dt-is-tablet';
    } else {
      return 'dt-no-tablet';
    }
}


function wp_md_ios_classes() {
    global $detect;
    if($detect->isIOS() == true){
      return 'os-is-ios';
    } else {
      return 'os-no-ios';
    }
}

function wp_md_android_classes() {
    global $detect;
    if($detect->isAndroidOS() == true){
      return 'os-is-android';
    } else {
      return 'os-no-android';
    }
}


/* Style frontend functions */
function wp_md_css_style() { 
  $forecload = time();
  wp_register_style( 'wp-md-css', plugins_url( '/css/wp-detect-mobile.css' , __FILE__ ), '', true, 'screen');
  wp_enqueue_style( 'wp-md-css' );
}
add_action('wp_enqueue_scripts', 'wp_md_css_style');



?>