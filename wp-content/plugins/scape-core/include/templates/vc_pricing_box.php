<?php
$output = $el_class = $unique_class = $style = $description = $price = $price_block = '';

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

wp_enqueue_style( 'scape-pricing' );

$anim_class = wtbx_vc_appearance_animation($css_animation, $css_animation_easing, $css_animation_duration, $css_animation_delay, $disable_css_animation);

// shortcode class
$element_class      = 'wtbx_vc_pricing_box';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class[]  = 'wtbx_' . $style;
$shortcode_class[]  = 'wtbx_skin_' . $skin;
$emphasize !== '' ? $shortcode_class[] = 'wtbx_pricing_box_emphasize' : null;

// price
if ( $price !== '' ) {
	$price_block .= '<div class="wtbx_pricing_box_price_wrapper">';

	if ( $style === 'style_1' || $style === 'style_2' ) {
		$price_block .= '<div class="wtbx_pricing_box_currency wtbx-text">'.esc_html($currency).'</div>';
		$price_block .= '<div class="wtbx_pricing_box_price wtbx-text">'.esc_html($price).'</div>';
		$price_block .= '<div class="wtbx_pricing_box_period wtbx-text">'.esc_html($time).'</div>';
	} elseif ( $style === 'style_3' ) {
		strpos($price, ',') !== false ? $price = str_replace(',', '.', $price) : null;
		if ( strpos($price, '.') !== false ) {
			$price_array = explode('.', $price);
		} else {
			$price_array = array();
			$price_array[0] = $price;
			$price_array[1] = '';
		}
		$price_block .= '<div class="wtbx_pricing_box_currency wtbx-text">'.esc_html($currency).'</div>';
		$price_block .= '<div class="wtbx_pricing_box_price wtbx-text">'.esc_html($price_array[0]).'<div class="wtbx_pricing_box_price_small wtbx-text">'.esc_html($price_array[1]).'</div></div>';
		$price_block .= '<div class="wtbx_pricing_box_period wtbx-text">'.esc_html($time).'</div>';
	}

	$price_block .= '</div>';
}

// button
$link = wtbx_vc_build_link($btn_link, 'wtbx_pricing_box_button style_'.esc_attr($btn_style));
$button = ( !empty($link['open']) ? $link['open'] : '<a href="#" class="wtbx_pricing_box_button style_'.esc_attr($btn_style).'">' ) . esc_html($btn_text) . ( $btn_style === 'link' ? '<i class="scape-ui-chevron-right"></i>' : '' ) . ( !empty($link['close']) ? $link['close'] : '</a>' );


// colors
$accent_color_text      = wtbx_vc_color_styles_text($accent_color);
$accent_color_bg        = wtbx_vc_color_styles_bg($accent_color);
$bg_color               = wtbx_vc_color_styles_bg($bg_color);
$border_color           = wtbx_vc_color_styles_border($border_color);
$btn_text_color         = wtbx_vc_color_styles_text($btn_text_color);
$btn_border_color       = wtbx_vc_color_styles_border($btn_bg_color);
$color_shadow           = wtbx_vc_color_styles_shadow($btn_bg_color_hover, '0 5px 30px -2px', '0.7');
$btn_bg_color           = wtbx_vc_color_styles_bg($btn_bg_color);
$btn_border_color_hover = wtbx_vc_color_styles_border($btn_bg_color);
$btn_text_color_hover   = wtbx_vc_color_styles_text($btn_text_color_hover);
$btn_bg_color_hover     = wtbx_vc_color_styles_bg($btn_bg_color_hover);

// description


if ( $description !== '' ) {
	if ( base64_decode($description, true) === false ) {
		$description = '<div class="wtbx_pricing_box_description">'.wpb_js_remove_wpautop($description, true).'</div>';
	} else {
		$description = rawurldecode( base64_decode( strip_tags( $description ) ) );
		$description = wpb_js_remove_wpautop( apply_filters( 'vc_raw_html_module_content', $description ) );
		$description = '<div class="wtbx_pricing_box_description">'.$description.'</div>';
	}
}

// construct shortcode class
$shortcode_class = implode(' ', $shortcode_class);
$class = $shortcode_class . $this->getExtraClass( $anim_class ) . $this->getExtraClass( $el_class );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

$output  = '';
$output .= '<div class="'.esc_attr($css_class).'">';

// styles
$unique_class_css = '.' . $unique_class . '.' . $element_class;
$js_styles = '';

$accent_color_bg !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_feature_badge {' . $accent_color_bg .  '}' : null;
$accent_color_text !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_feature_icon {' . $accent_color_text .  '}' : null;
$radius !== '' ? $js_styles .= $unique_class_css.'.wtbx_vc_pricing_box .wtbx_vc_pricing_box_inner .wtbx_pricing_box_wrapper {border-radius:' . intval($radius) .  'px}' : null;

if ( $style === 'style_1' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_pricing_box_subtitle {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1.wtbx_pricing_box_emphasize .wtbx_pricing_box_wrapper:before {' . $accent_color_bg .  '}' : null;
	$bg_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_pricing_box_wrapper {' . $bg_color .  '}' : null;
	$border_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_1 .wtbx_pricing_box_wrapper {border-style:solid;border-width:1px;' . $border_color .  '}' : null;
} elseif ( $style === 'style_2' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2 .wtbx_pricing_box_subtitle {' . $accent_color_text .  '}' : null;
	$accent_color_bg !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2 .wtbx_pricing_box_title_wrapper:before {' . $accent_color_bg .  '}' : null;
	$bg_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2 .wtbx_pricing_box_wrapper {' . $bg_color .  '}' : null;
	$border_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_2 .wtbx_pricing_box_wrapper {border-style:solid;border-width:1px;' . $border_color .  '}' : null;
} elseif ( $style === 'style_3' ) {
	$accent_color_text !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_pricing_box_subtitle {' . $accent_color_text .  '}' : null;
	$bg_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_pricing_box_wrapper {' . $bg_color .  '}' : null;
	$border_color !== '' ? $js_styles .= $unique_class_css.'.wtbx_style_3 .wtbx_pricing_box_wrapper {border-style:solid;border-width:1px;' . $border_color .  '}' : null;
}

$btn_style !== 'link' && $btn_radius !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button { border-radius:' . intval($btn_radius) .  'px}' : null;
if ( $btn_style === 'btn' ) {
	$btn_bg_color !== '' || $btn_text_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_btn {' . $btn_bg_color . $btn_text_color.  '}' : null;
	$btn_bg_color_hover !== '' || $btn_text_color_hover !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_btn:hover {' . $btn_bg_color_hover . $btn_text_color_hover.  '}' : null;
	$btn_bg_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_btn:hover {' . $color_shadow .  '}' : null;
} elseif ($btn_style === 'ghost') {
	$btn_text_color !== '' || $btn_border_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_ghost {' . $btn_text_color . $btn_border_color .  '}' : null;
	$btn_text_color_hover !== '' || $btn_bg_color_hover !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_ghost:hover {' . $btn_text_color_hover . $btn_bg_color_hover . $btn_border_color_hover . '}' : null;
	$btn_bg_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_ghost:hover {' . $color_shadow . '}' : null;
} elseif ($btn_style === 'link') {
	$btn_text_color !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_link {' . $btn_text_color .  '}' : null;
	$btn_text_color_hover !== '' ? $js_styles .= $unique_class_css.' .wtbx_pricing_box_button.style_link:hover {' . $btn_text_color_hover .  '}' : null;
}



$output .= wtbx_vc_js_styles($js_styles);

// shortcode
$output .= '<div class="wtbx_vc_el_container '.esc_attr($element_class).'_container">';
$output .= '<div class="wtbx_vc_el_inner '.esc_attr($element_class).'_inner">';
$output .= '<div class="wtbx_pricing_box_wrapper">';

$output .= '<div class="wtbx_pricing_box_header clearfix">';
if ( $style === 'style_2' ) {
	$output .= $price_block;
}
$output .= '<div class="wtbx_pricing_box_title_wrapper">';
$output .= '<div class="wtbx_pricing_box_title wtbx-text">'.esc_html($title).'</div>';
$output .= '<div class="wtbx_pricing_box_subtitle wtbx-text">'.esc_html($meta).'</div>';
$output .= '</div>';

if ( $style === 'style_1' ) {
	$output .= $price_block;
}

$output .= $description;
$output .= '</div>';

if ( $style === 'style_3' ) {
	$output .= $price_block;
}



$output .= '<div class="wtbx_pricing_box_content">';
$output .= wpb_js_remove_wpautop($content, true);
$output .= '</div>';

$output .= $button;

$output .= '</div>';
$output .= '</div>';
$output .= '</div>';
$output .= '</div>';

echo $output;
