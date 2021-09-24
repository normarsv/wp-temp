<?php
$sections   = wtbx_option_sub('h'.$header_style.'-builder', 'value');
$sections   = $sections !== '' ? json_decode($sections, true) : '';
$header_skin_class = ' header-skin-' . $header_skin;
$shadow_class = wtbx_option('h'.$header_style.'-shadow') !== '' ? ' header_shadow' : '';
$animation  = wtbx_option('h'.$header_style.'-menu-anim') !== '' ? ' header_' . wtbx_option('h'.$header_style.'-menu-anim') : '';
?>

<div class="header_backdrop"></div>
<div id="header-wrapper" class="header-desktop header-wrapper header-style-<?php echo esc_attr($header_style . $header_skin_class . $animation . $shadow_class); ?>">
	<div id="header-container" class="clearfix">
		<div class="wtbx_hs">
        <?php
            $header_skin = 'light';
            include(locate_template('templates/header/parts/logo.php'));
        ?>
        </div>
        <?php if ( $sections !== '' ) {
				foreach ($sections as $section => $areas) { ?>
					<div class="wtbx_hs wtbx_hs_<?php echo esc_attr($section); ?>">
						<div class="wtbx_hs_inner clearfix"><?php
						foreach ($areas as $area => $items) { ?>
							<div class="wtbx_ha wtbx_ha_<?php echo esc_attr($section); ?>_<?php echo esc_attr($area); ?> clearfix"><?php
								foreach ($items as $item => $props) {
									include(locate_template('templates/header/parts/' . $props['id'] . '.php'));
								}
								?></div>
						<?php }
						?></div>
					</div>
				<?php }
			}
		?>
	</div>
	<div class="wtbx_header_trigger_wrapper header-style-<?php echo esc_attr($header_style . $header_skin_class); ?>">
		<?php
		$header_style   = '14-trigger';
		$header_skin    = wtbx_option_levelled('header-skin');
		include(locate_template('templates/header/parts/logo.php')); ?>
		<div class="wtbx_header_trigger">
			<div class="wtbx_header_trigger_inner">
				<div class="line first"></div>
				<div class="line second"></div>
				<div class="line third"></div>
			</div>
		</div>
	</div>
</div>