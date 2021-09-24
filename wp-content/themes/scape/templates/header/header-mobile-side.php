<?php
$header_style = wtbx_option_levelled('header-style');
if ( !empty(wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'width')) || !empty(wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'height')) ) {
    $header_style = 'm';
    $sections   = wtbx_option_sub('h'.$header_style.'-builder', 'value');
    $sections   = $sections !== '' ? json_decode($sections, true) : '';
    $header_design = wtbx_option('hm-design');
    if ( empty($header_design) ) { $header_design = 'default'; }
    ?>

    <div class="wtbx_mobile_backdrop"></div>
    <nav id="mobile-header" class="header-mobile-side wtbx_skin_<?php echo esc_attr(wtbx_option('hm-side-skin')); ?> wtbx_design_<?php echo esc_attr($header_design); ?>" data-width="<?php echo esc_attr(wtbx_option('hm-s-width')); ?>">
        <div class="mobile-nav-wrapper">
            <div class="mobile-nav-header">
                <div class="wtbx_mobile_close"></div>
            </div>
            <?php
            if ( $sections !== '' && is_array($sections) ) {
                foreach ($sections as $section => $areas) {
                    if ( $section === 'header' || $section === 'main' || $section === 'footer' ) { ?>
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
            }
            ?>
        </div>
    </nav>

<?php } ?>