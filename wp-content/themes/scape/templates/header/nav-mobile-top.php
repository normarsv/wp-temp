<div id="header-wrapper-m" class="header-mobile">
	<div id="header-container" class="clearfix">
		<div id="site-logo">
			<?php
			$logo_mobile        = wtbx_option_sub('m-logo', 'url');
			$logo_mobile_retina = wtbx_option_sub('m-logo-retina', 'url');

			if ( $logo_mobile !== '' ) {
				echo '<a href="'. esc_url( home_url('/') ) .'">
						<img width="'.wtbx_option_sub('m-logo-size','width').'" height="'.wtbx_option_sub('m-logo-size', 'height').'" src="'.$logo_mobile.'" alt="', esc_attr(bloginfo('name')) .'" data-rsrc="'.$logo_mobile_retina.'" />';
				echo '</a>';
			} else {
				echo '<h1 class="site-title"><a href="'. esc_url( home_url('/') ) .'" title="'. esc_attr(bloginfo('name')) .'" rel="home">', bloginfo('name') .'</a></h1>';
			}
			?>
		</div>

		<div class="toggle-mobile-menu">
			<div class="mobile-button">
				<div class="line top"></div>
				<div class="line middle"></div>
				<div class="line bottom"></div>
			</div>
		</div>

		<nav class="site-navigation" role="navigation">
			<div class="header-buttons">
				<!-- widget area 1 -->
				<?php if( wtbx_option_sub('hm-top-elements', '3') === '1' && is_active_sidebar( 'header-widget-area-1' ) ) : ?>
					<div class="h-widget-area h-widget-area-1">
						<ul>
							<?php dynamic_sidebar( 'header-widget-area-1' ); ?>
						</ul>
					</div>
				<?php endif; ?>

				<div class="header-icons">

					<!-- woocommerce icon -->
					<?php if( class_exists( 'WooCommerce' ) && wtbx_option_sub('hm-top-elements', '1') === '1' ) : ?>
						<div class="header_cart_wrapper">
							<?php global $woocommerce; ?>
							<a href="<?php echo esc_url( $woocommerce->cart->get_cart_url() ); ?>" title="<?php esc_attr_e( 'Click to view your shopping cart', 'scape' ); ?>" class="header_cart_link" >
								<?php woocommerce_cart_button(); ?>
							</a>
						</div>
					<?php endif; ?>

					<!-- search icon -->
					<?php if( wtbx_option_sub('hm-top-elements', '2') === '1' ) : ?>
						<button id="trigger-header-search" class="search_button" type="button">
							<i class="icon-magnifier"></i>
						</button>
					<?php endif; ?>

				</div>

				<!-- widget area 2 -->
				<?php if( wtbx_option_sub('hm-top-elements', '4') === '1' && is_active_sidebar( 'header-widget-area-2' ) ) : ?>
					<div class="h-widget-area h-widget-area-2">
						<ul>
							<?php dynamic_sidebar( 'header-widget-area-2' ); ?>
						</ul>
					</div>
				<?php endif; ?>

			</div><!-- .header-buttons -->
		</nav><!-- #site-navigation -->
	</div><!-- #header-container -->
</div><!-- #header-wrapper -->