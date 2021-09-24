<?php
/*	
*	---------------------------------------------------------------------
*	WTBX Register the required plugins for this theme
*	--------------------------------------------------------------------- 
*/

add_action( 'tgmpa_register', 'wtbx_required_plugins' );

function wtbx_required_plugins() {

    // Array of plugin arrays.
    $plugins = array(
	    array(
		    'name'               => 'Scape Core', // The plugin name.
		    'slug'               => 'scape-core', // The plugin slug (typically the folder name).
		    'source'             => 'http://whiteboxstud.io/envato/scape/dist/643277/scape-core.zip', // The plugin source.
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '1.5.2', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'WPBakery Page Builder', // The plugin name.
		    'slug'               => 'js_composer', // The plugin slug (typically the folder name).
		    'source'             => 'http://whiteboxstud.io/envato/scape/dist/643277/js_composer.zip', // The plugin source.
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '6.7.0', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => 'https://codecanyon.net/item/visual-composer-page-builder-for-wordpress/242431', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'Redux Framework', // The plugin name.
		    'slug'               => 'redux-framework', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => true, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => 'https://wordpress.org/plugins/redux-framework/', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'Revolution Slider', // The plugin name.
		    'slug'               => 'revslider', // The plugin slug (typically the folder name).
		    'source'             => 'http://whiteboxstud.io/envato/scape/dist/643277/revslider.zip', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '6.5.5', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => 'https://codecanyon.net/item/slider-revolution-responsive-wordpress-plugin/2751380', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'Contact Form 7', // The plugin name.
		    'slug'               => 'contact-form-7', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '',
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'MailChimp for WordPress', // The plugin name.
		    'slug'               => 'mailchimp-for-wp', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '',
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'Envato Market', // The plugin name.
		    'slug'               => 'envato-market', // The plugin slug (typically the folder name).
		    'source'             => 'http://whiteboxstud.io/envato/scape/dist/643277/envato-market.zip', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '2.0.1', // E.g. 1.0.0. If set, the active plugin must be this version or higher.
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => 'https://envato.com/market-plugin/', // If set, overrides default API URL and points to an external URL.
	    ),
	    array(
		    'name'               => 'WooCommerce', // The plugin name.
		    'slug'               => 'woocommerce', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '',
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'YITH WooCommerce Wishlist', // The plugin name.
		    'slug'               => 'yith-woocommerce-wishlist', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '',
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
	    array(
		    'name'               => 'GDPR', // The plugin name.
		    'slug'               => 'gdpr', // The plugin slug (typically the folder name).
		    'source'             => '', // The plugin source.
		    'required'           => false, // If false, the plugin is only 'recommended' instead of required.
		    'version'            => '',
		    'force_activation'   => false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch.
		    'force_deactivation' => false, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins.
		    'external_url'       => '', // If set, overrides default API URL and points to an external URL.
		    'is_callable'        => '', // If set, this callable will be be checked for availability to determine if a plugin is active.
	    ),
    );

    
    // Array of configuration settings.
    $config = array(
        'id'           => 'scape',                  // Unique ID for hashing notices for multiple instances of TGMPA.
        'default_path' => '',                      // Default absolute path to pre-packaged plugins.
        'menu'         => 'tgmpa-install-plugins', // Menu slug.
        'has_notices'  => true,                    // Show admin notices or not.
        'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
        'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
        'is_automatic' => false,                   // Automatically activate plugins after installation or not.
        'message'      => '',                      // Message to output right before the plugins table.
        'strings'      => array(
	        'menu_title'                      => __( 'Plugins', 'scape' ),
	        'nag_type'                        => 'updated' // Determines admin notice type - can only be 'updated', 'update-nag' or 'error'.
        )
    );

    tgmpa( $plugins, $config );

}
