<?php 
$shadow = wtbx_option('gf-'.$filter_skin.'-shadow') !== '' ? ' filter-shadow' : '';
if ( !$post_type ) {
    $post_type = 'post';
}

wp_enqueue_style( 'scape-filter' );


if ( sizeof($defaults) > 1 && $filter === 'multi' ) {
	foreach ( $defaults as $key => $category ) {
		if ( 'post' === $post_type ) {
			$category = get_cat_name($category);
		} elseif ( 'portfolio' === $post_type ) {
			$category = get_term( $category, 'portfolio_category' )->slug;
		}
		$default_val[] = strtolower(str_replace(' ', '', $category));
	}
	$default_val = json_encode($default_val);
} elseif ( empty($defaults[0]) ) {
	$default_val = json_encode('*');
} else {
	if ( 'post' === $post_type ) {
		$category = get_cat_name($defaults[0]);
	} elseif ( 'portfolio' === $post_type ) {
		$category = get_term( $defaults[0], 'portfolio_category' )->slug;
	}
	$default_val = json_encode(strtolower(str_replace(' ', '', $category)));
}

if ( $filter_bg !== '' ) {
    wtbx_js_styles(wtbx_vc_color_styles_bg($filter_bg));
}
?>

<div class="wtbx-filter wtbx-skin-<?php echo esc_attr($filter_skin); ?> wtbx-scheme-<?php echo esc_attr($filter_scheme); ?> filter-<?php echo esc_attr($filter); ?><?php echo esc_attr($filter_display), esc_attr($shadow); ?>"
     data-default="<?php echo esc_attr($default_val); ?>"
     data-hash="<?php echo esc_attr($filter_hash); ?>"
    <?php echo (( $filter === 'multi' ) ? ' data-operator="'.$filter_operator.'"' : ''); ?>>
	<div class="wtbx-filter-inner row-inner">
		<ul class="wtbx-filter-buttons clearfix">
			<?php if ( $filter === 'minimal' || $filter === 'slider' ) : ?>
				<li class="wtbx-filter-button show-all wtbx-click" data-filter="*">
					<span><?php echo esc_html__('Show all', 'scape'); ?></span>
				</li>
			<?php endif; ?>
			<?php if ( isset($filter_categories) ) {
				foreach ( $filter_categories as $cat ) {
					if ( 'post' === $post_type ) {
						$cat = get_term( $cat, 'category' );
						$slug = get_term( $cat, 'category' );
					} elseif ( 'portfolio' === $post_type ) {
						$cat = get_term( $cat, 'portfolio_category' );
						$slug = get_term( $cat, 'portfolio_category' );
					}
					?>
                    <li class="wtbx-filter-button wtbx-click" data-filter="<?php echo esc_attr($cat->slug); ?>">
                        <span><?php echo esc_html($cat->name); ?></span>
                    </li>
				<?php }
            } ?>
            <li class="knob hidden"></li>
        </ul>
	</div>
</div>