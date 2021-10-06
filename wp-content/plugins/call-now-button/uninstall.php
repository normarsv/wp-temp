<?php

// Doc: https://developer.wordpress.org/plugins/plugin-basics/uninstall-methods/

// if uninstall.php is not called by WordPress, die
if (!defined('WP_UNINSTALL_PLUGIN')) {
die;
}

$option_name = 'cnb';

// Delete the standard options
delete_option($option_name);

// Delete site options in Multisite
delete_site_option($option_name);
