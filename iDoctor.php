<?php
/**
 * @package iDoctor for WordPress
 */
/*
Plugin Name: iDoctor for WordPress
Plugin URI: https://choclomedia.com/
Description: The purpose of the development of this plugin is to make it possible for doctors to access patient information remotely through WordPress.
Version: 1.0
Author: Jose Rodriguez
Author URI: https://choclomedia.com/
License: GPLv2 or later
Text Domain: idoctor
*/

/*
iDoctor for WordPress is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

iDoctor for WordPress is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program.
*/

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'IDOCTOR_PLUGIN_DIR', trailingslashit( dirname(__FILE__) ) );
define( 'IDOCTOR_PLUGIN_URI', plugins_url('', __FILE__) );
define( 'IDOCTOR_PLUGIN_BASE_NAME', plugin_basename(__FILE__) );

// INCLUDES
require_once 'includes/config.php';
require_once 'includes/posttypes.php';
require_once 'includes/metaboxes.php';