<?php
wtbx_script_queue('scape-language-switch');

if ( wtbx_demo() ) {?>
    <div class="wtbx_header_part header_language_wrapper">
        <div class="header_language_trigger wtbx_h_text_color wtbx_h_text_color_hover">
            <img src="<?php echo WTBX_URI . '/library/images/demo/gb.png' ?>" alt="GB">
            <span>En</span>
        </div>
        <div class="header_language_dropdown">
            <ul>
                <li>
                    <a href="#" class="clearfix">
                        <div class="cell">
                            <img src="<?php echo WTBX_URI . '/library/images/demo/de.png' ?>" alt="DE">
                        </div>
                        <div class="cell">
                            <span>French</span>
                        </div></a>
                </li>
                <li>
                    <a href="#" class="clearfix">
                        <div class="cell">
                            <img src="<?php echo WTBX_URI . '/library/images/demo/fr.png' ?>" alt="FR">
                        </div>
                        <div class="cell">
                            <span>German</span>
                        </div>
                    </a>
                </li>
            </ul>
        </div>
    </div>
<?php } else {
	if ( class_exists('SitePress') ) { ?>
        <div class="wtbx_header_part header_language_wrapper">
			<?php
			$languages = apply_filters( 'wpml_active_languages', NULL, 'skip_missing=0&orderby=code' );
			$current_lang_flag = $select = '';

			if (!empty($languages)) {
				foreach ($languages as $l) {
					if ( defined('ICL_LANGUAGE_CODE') && $l['language_code'] === ICL_LANGUAGE_CODE ) {
						$current_lang_flag = $l['country_flag_url'];
					}
				}
			}
			?>
            <div class="header_language_trigger wtbx_h_text_color wtbx_h_text_color_hover header_button_height">
                <img src="<?php echo esc_url($current_lang_flag); ?>">
                <span><?php echo ( defined('ICL_LANGUAGE_CODE') ) ? ucfirst(ICL_LANGUAGE_CODE) : ''; ?></span>
            </div>
            <div class="header_language_dropdown">
                <ul>
                    <?php if (!empty($languages)) {
	                    foreach ($languages as $l) {
		                    if ( defined('ICL_LANGUAGE_CODE') && $l['language_code'] !== ICL_LANGUAGE_CODE ) {
			                    $select .= '<li>';
			                    $select .= '<a href="'.esc_url($l['url']).'" class="clearfix">';
			                    $select .= '<div class="cell"><img src="'.esc_url($l['country_flag_url']).'"></div>';
			                    $select .= '<div class="cell"><span>'.esc_html($l['translated_name']).'</span></div>';
			                    $select .= '</a>';
			                    $select .= '</li>';
		                    }
	                    }
	                    print_r($select);
                    } ?>
                </ul>
            </div>
        </div>
	<?php }
}



