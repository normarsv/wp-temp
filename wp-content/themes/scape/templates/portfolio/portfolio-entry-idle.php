<?php
$rollhover = $grid_style === 'boxed' ? ' wtbx-rollhover-layer' : '';
?>

<div class="portfolio-overlay-<?php echo esc_attr($overlay_idle);?>">
	<?php if ( $overlay_idle === 'meta_centered' ) { ?>
		<div class="portfolio-overlay-meta_centered-inner">
			<?php
            if ( $meta_primary ) echo wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary');
            if ( $meta_secondary ) echo wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary');
			?>
        </div>
		<?php
	} elseif ( $overlay_idle === 'meta_middle' ) { ?>
        <div class="portfolio-overlay-meta_middle-inner">
            <?php
            if ( $meta_primary ) echo wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary', strpos($meta_primary, '_link') !== false);
            if ( $meta_secondary ) echo wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary', strpos($meta_secondary, '_link') !== false);
            ?>
        </div>
		<?php
	} elseif ( $overlay_idle === 'meta_aligned' ) { ?>
        <div class="portfolio-meta-block">
            <div class="portfolio-overlay-meta_aligned-inner">
				<?php
				if ( $meta_primary ) echo wtbx_portfolio_meta_content($meta_primary, $postID, 'portfolio-meta-primary', strpos($meta_primary, '_link') !== false);
				if ( $meta_secondary ) echo wtbx_portfolio_meta_content($meta_secondary, $postID, 'portfolio-meta-secondary', strpos($meta_secondary, '_link') !== false);
				?>
            </div>
        </div>
	<?php } ?>
</div>