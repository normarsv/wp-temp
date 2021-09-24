<nav class="wtbx_header_part wtbx_menu_nav">
	<?php
	$menu_array = array();

	if ( !empty($props['nav']) ) {
		$menu = $props['nav'];
		$menu_array = array('menu' => $menu);
	} else {
		if ( $header_style === 'm' ) {
			$menu = wtbx_option_levelled('header-m-menu');
			if ( $menu === '' ) { $menu = wtbx_option_levelled('header-menu'); }
			$mobile_menu = $menu;

			$locations = get_nav_menu_locations();

			if ( !empty($menu) ) {
				$menu_array = array('menu' => $menu);
			} else {
				if ( isset($locations['mobile']) && !empty(wp_get_nav_menu_object( $locations['mobile'] )) ) {
					$menu_array = array('theme_location'  => 'mobile');
				}
			}

		} else {
			$menu = wtbx_option_levelled('header-menu');
			$header_menu = $menu;

			if ( !empty($menu) ) {
				$menu_array = array('menu' => $menu);
			} else {
				$locations = get_nav_menu_locations();
				if ( isset($locations['header']) && !empty(wp_get_nav_menu_object( $locations['header'] )) ) {
					$menu_array = array('theme_location'  => 'header');
				}
			}
		}
	}

	if ( empty($header_menu) ) {
		if ( isset($locations['header']) && !empty(wp_get_nav_menu_object( $locations['header'] )) ) {
			$header_menu = $locations['header'];
		}
    }

	if ( empty($mobile_menu) ) {
        if ( isset($locations['mobile']) && !empty(wp_get_nav_menu_object( $locations['mobile'] ))) {
            $mobile_menu = $locations['mobile'];
        }
	}

	if ( !empty($header_menu) && !empty($mobile_menu) && $header_style === 'm' && $header_menu === $mobile_menu ) {
		$menu_array = array();
		?><span class="wtbx_header_placeholder" data-slug="<?php echo esc_attr(get_term($mobile_menu)->slug); ?>"></span><?php
	}

	if ( !empty($menu_array) ) {
		wp_nav_menu($menu_array);
	}
	?>
</nav>