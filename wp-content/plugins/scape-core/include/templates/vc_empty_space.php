<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

$height = $unique_class = $el_class = $css = $height_string =
$tablet_landscape = $tablet_portrait = $mobile_landscape = $mobile_portrait = '';
$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

$element_class      = 'wtbx_vc_empty_space';
$wrapper_class      = 'wtbx_wrapper ';
$unique_class       = $element_class . '-' . hexdec(substr(uniqid(), 6, 7));
$shortcode_class    = array();
$shortcode_class[]  = $element_class;
$shortcode_class[]  = $unique_class;
$shortcode_class    = implode(' ', $shortcode_class);
$unique_class_css   = '.' . $unique_class . ' .wtbx_empty_space_inner';

$pattern = '/^(\d*(?:\.\d+)?)\s*(px|\%|in|cm|mm|em|rem|ex|pt|pc|vw|vh|vmin|vmax)?$/';
$regexr = preg_match( $pattern, $height, $matches );
$value = isset( $matches[1] ) ? (float) $matches[1] : 0;
$unit = isset( $matches[2] ) ? $matches[2] : 'px';
$height = $value . $unit;

$height_array = array();
//$height !== '' ? $height_array['desktop'] = $height : null;

$sizes_array = array(
	'tablet_landscape' => '1024px',
	'tablet_portrait' => '991px',
	'mobile_landscape' => '767px',
	'mobile_portrait' => '479px',
);

foreach ( $sizes_array as $id => $size ) {
	if ( ${$id} !== '' ) {
		$regexr = preg_match( $pattern, ${$id}, $matches );
		$value = isset( $matches[1] ) ? (float) $matches[1] : 0;
		$unit = isset( $matches[2] ) ? $matches[2] : 'px';
		$screen_height = $value . $unit;
		$height_array[$id] = $screen_height;
	}
}

if ( $height !== '' ) {
	$height_string .= $unique_class_css.' {height:'.$height.'}';
}

if ( sizeof($height_array) > 0 ) {
	foreach ( $height_array as $size => $size_height ) {
		$height_string .= ' @media only screen and (max-width:'.$sizes_array[$size].') { '.$unique_class_css.' {height:'.$size_height.'}}';
	}
}


$class = $shortcode_class . $this->getExtraClass( $el_class ) . vc_shortcode_custom_css_class( $css, ' ' );
$css_class = apply_filters( VC_SHORTCODE_CUSTOM_CSS_FILTER_TAG, $class, $this->settings['base'], $atts );

?>


<div class="<?php echo esc_attr( trim( $css_class ) ); ?>">
	<?php echo wtbx_vc_js_styles($height_string); ?>
	<span class="wtbx_empty_space_inner"></span>
</div>
