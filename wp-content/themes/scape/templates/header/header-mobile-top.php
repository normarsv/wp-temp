<?php
$header_style = wtbx_option_levelled('header-style');

if ( !empty(wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'width')) || !empty(wtbx_option_sub('h'.$header_style.'-mobile-breakpoint', 'height')) ) {
    $header_style = 'm';
    $sections   = wtbx_option_sub('h'.$header_style.'-builder', 'value');
    $sections   = $sections !== '' ? json_decode($sections, true) : '';
    $mobile_sticky  = ' header_sticky_' . wtbx_option('hm-sticky');
    $shadow_class = wtbx_option('h'.$header_style.'-shadow') !== '' ? ' ' . wtbx_option('h'.$header_style.'-shadow') : '';
    ?>

    <div id="header-wrapper-mobile" class="header-mobile header-wrapper header-mobile-top<?php echo esc_attr($mobile_sticky . $shadow_class); ?>">
        <div id="header-container-mobile" class="clearfix">
            <?php
            if ( $sections !== '' && is_array($sections) ) {
                foreach ($sections as $section => $areas) {
                    if ( $section === 'top_header' ) { ?>
                        <div class="wtbx_hs wtbx_hs_<?php echo esc_attr($section); ?>">
                            <div class="wtbx_hs_inner clearfix"><?php
                                    include(locate_template('templates/header/parts/logo.php'));
                                    foreach ($areas as $area => $items) { ?>
                                        <div class="wtbx_ha wtbx_ha_<?php echo esc_attr($section); ?>_<?php echo esc_attr($area); ?> clearfix"><?php
                                            foreach ($items as $item => $props) {
                                                include(locate_template('templates/header/parts/' . $props['id'] . '.php'));
                                            }
                                            if ( $area === 'right' ) { ?>
                                                <div class="wtbx_header_part wtbx_mobile_trigger">
                                                    <div class="wtbx_header_trigger_inner">
                                                        <div class="line first"></div>
                                                        <div class="line second"></div>
                                                        <div class="line third"></div>
                                                    </div>
                                                </div>
                                            <?php }
                                            ?></div>
                                    <?php }
                                ?></div>
                        </div>
                <?php }
                }
            }
            ?>
        </div>
    </div>

<?php } ?>