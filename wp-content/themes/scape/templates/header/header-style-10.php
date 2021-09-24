<?php
$sections   = wtbx_option_sub('h'.$header_style.'-builder', 'value');
$sections   = $sections !== '' ? json_decode($sections, true) : '';
$layout     = ' ' . wtbx_option('h'.$header_style.'-layout');
$borders    = ( wtbx_option('h'.$header_style.'-borders-enable') === '1' ) ? ' with-borders' : '';
$header_skin_class = ' header-skin-' . $header_skin;
$sticky_skin_class = ' sticky-skin-' . $sticky_skin;
$shadow_class = wtbx_option('h'.$header_style.'-shadow') !== '' ? ' ' . wtbx_option('h'.$header_style.'-shadow') : '';
$animation  = wtbx_option('h'.$header_style.'-menu-anim') !== '' ? ' header_' . wtbx_option('h'.$header_style.'-menu-anim') : '';
?>

<div id="header-wrapper" class="header-desktop header-wrapper header-style-<?php echo esc_attr($header_style . ' ' . $layout . $borders . $header_skin_class . $header_sticky . $sticky_skin_class . $animation . $shadow_class); ?>">
	<div id="header-container" class="clearfix">
		<?php
		if ( $sections !== '' ) {
			foreach ($sections as $section => $areas) {
				if ( $section === 'overlay' ) { ?>
					<div class="wtbx_header_overlay_layer">
					<div class="wtbx_header_overlay_inner">
					<div class="wtbx_header_overlay_space"></div>
				<?php } ?>
				<div class="wtbx_hs wtbx_hs_<?php echo esc_attr($section); ?>">
					<div class="wtbx_hs_inner"><?php
						if ( $section === 'header' ) {
							include(locate_template('templates/header/parts/logo.php')); ?>
							<div class="wtbx_header_part wtbx_header_trigger">
								<div class="wtbx_header_trigger_inner">
									<div class="line first"></div>
									<div class="line second"></div>
									<div class="line third"></div>
								</div>
							</div>
						<?php }
						foreach ($areas as $area => $items) { ?>
							<div class="wtbx_ha wtbx_ha_<?php echo esc_attr($section); ?>_<?php echo esc_attr($area); ?> clearfix"><?php
								foreach ($items as $item => $props) {
									include(locate_template('templates/header/parts/' . $props['id'] . '.php'));
								}
								?></div>
						<?php }
						?></div>
				</div>
				<?php if ( $section === 'overlay' ) { ?>
					</div>
					</div>
				<?php }
			}
		}
		?>
	</div>
</div>