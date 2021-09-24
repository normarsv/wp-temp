<?php
$item_layout = get_post_meta($postID, 'portfolio-item-media', true);
$rollhover = $grid_style === 'boxed' ? ' wtbx-rollhover-layer' : '';
?>

<div class="portfolio-overlay-<?php echo esc_attr($overlay_hover);?>">

	<?php if ( $overlay_hover === 'empty' ) {
		?>
		<div class="portfolio-overlay-link">
			<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
		</div>
	     <?php
	} elseif ( $overlay_hover === 'color' ) {
		?>
		<div class="portfolio-overlay-link">
			<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
		</div>
		<?php
	} elseif ( $overlay_hover === 'icon' ) {
		if ( $click_action === 'link' ) {
			echo '<i class="scape-ui-link portfolio-icon"></i>';
		} else {
			if ( $item_layout === 'audio' ) {
				echo '<i class="scape-ui-play portfolio-icon"></i>';
			} elseif ( $item_layout === 'video' ) {
				echo '<i class="scape-ui-play portfolio-icon"></i>';
			} else {
				echo '<div class="portfolio-icon-plus portfolio-icon"></div>';
			}
		}
		?>
		<div class="portfolio-overlay-link">
			<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
		</div>
		<?php
	} elseif ( $overlay_hover === 'meta_centered' ) { ?>
		<div class="portfolio-overlay-meta_centered-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
			<?php
			if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false );
			if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
			?>
			<div class="portfolio-overlay-link">
				<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
			</div>
		</div>
		<?php
	} elseif ( $overlay_hover === 'meta_middle' ) {
		?>
		<div class="portfolio-overlay-meta_middle-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
			<?php
			if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false);
			if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
			?>
			<div class="portfolio-overlay-link">
				<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
			</div>
		</div>
		<?php
	} elseif ( $overlay_hover === 'meta_middle_inside' ) { ?>
        <div class="portfolio-overlay-meta_middle_inside-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
			<?php
			if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false );
			if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
			?>
            <div class="portfolio-overlay-link">
				<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
            </div>
        </div>
		<?php
	} elseif ( $overlay_hover === 'meta_boxed' ) { ?>
        <div class="portfolio-overlay-meta_boxed-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
			<?php
			if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false );
			if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
			?>
        </div>
        <div class="portfolio-overlay-link">
			<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
        </div>
		<?php
	} elseif ( $overlay_hover === 'meta_border' ) { ?>
        <div class="portfolio-overlay-meta_border-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
			<?php
			if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false );
			if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
			?>
            <div class="portfolio-overlay-link">
		        <?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
            </div>
        </div>
        <div class="portfolio-overlay-border<?php echo esc_attr($rollhover)?>" data-layer="1"></div>
		<?php
	}  elseif ( $overlay_hover === 'meta_aligned' ) { ?>
		<div class="portfolio-meta-block">
			<div class="portfolio-overlay-meta_aligned-inner<?php echo esc_attr($rollhover)?>" data-layer="2">
				<?php
				if ( $meta_primary_hover ) echo wtbx_portfolio_meta_content($meta_primary_hover, $postID, 'portfolio-meta-primary', strpos($meta_primary_hover, '_link') !== false);
				if ( $meta_secondary_hover ) echo wtbx_portfolio_meta_content($meta_secondary_hover, $postID, 'portfolio-meta-secondary', strpos($meta_secondary_hover, '_link') !== false);
				?>
			</div>
		</div>
        <div class="portfolio-overlay-link">
			<?php echo wtbx_portfolio_link($postID, $click_action, $caption_primary, $caption_secondary, $share) ?>
        </div>
	<?php
	} elseif ( $overlay_hover === 'buttons' ) {
		?>
		<div class="<?php echo esc_attr($rollhover)?>" data-layer="2">
			<div class="portfolio-overlay-buttons-inner">
				<?php
				if ( $action_button_link ) {
					echo wtbx_portfolio_link($postID, 'link');
				}
				if ( $action_button_gallery_all ) {
					echo wtbx_portfolio_link($postID, 'gallery_all', $caption_primary, $caption_secondary, $share);
				}
				if ( $action_button_gallery_item ) {
					echo wtbx_portfolio_link($postID, 'gallery_item', $caption_primary, $caption_secondary, $share);
				}
				?>
			</div>
		</div>
		<?php
	} ?>
	</div>