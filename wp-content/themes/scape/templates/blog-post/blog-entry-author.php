<?php if ( wtbx_option('post-author-descr') === '1' ) : ?>
	<div class="author-area clearfix">
		<div class="author-image">
			<div class="author-image-inner">
				<?php echo get_avatar( get_the_author_meta( 'ID' ), 120 ); ?>
			</div>

			<?php
				$post_count = count_user_posts(get_the_author_meta( 'ID' ), 'post');
				if ($post_count == 1)
					$post_count .= ' ' . esc_html__( 'Post', 'scape' );
				else
					$post_count .= ' ' . esc_html__( 'Posts', 'scape' );
			?>

			<a href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>" class="author-posts"><?php echo esc_html($post_count); ?></a>
		</div>
		<div class="author-bio">
			<a class="author-name" href="<?php echo esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ); ?>"><?php the_author_meta( 'display_name' ); ?> </a>

			<?php $info = get_the_author_meta( 'author_info' );
			if ($info) : ?>
				<div class="author-position wtbx-text"><?php echo esc_html($info); ?></div>
			<?php endif; ?>

			<?php $description =  get_the_author_meta( 'description' );
			if ($description) : ?>
				<div class="author-info wtbx-text"><?php echo the_author_meta( 'description' ); ?></div>
			<?php endif; ?>

			<?php

			$contactmethods = wtbx_social_networks();
			$contacts       = array();
			$are_contacts = false;

			if ( $contactmethods ) {
                foreach ( $contactmethods as $contact => $props ) {
                    $contacts[$contact] = get_the_author_meta($contact);
                }
                unset($contacts['Author Info']);

                $are_contacts = (array_filter($contacts)) ? true : false;

                if ($are_contacts) : ?><div class="author-contacts clearfix"><?php endif;
                    foreach($contacts as $id => $link) {
                        $title = $contactmethods[$id][0];
                        $icon = $contactmethods[$id][1];
                        if ($link) {
                            echo '<a href="' . esc_url($link) . '"' . ( wtbx_option('social_open_blank') === '1' ? ' target="_blank"' : '' ) . ' class="author-contact-link author-'.esc_attr(str_replace(' ', '',  strtolower($title))).'" aria-label="'.esc_attr($title).'"><i class="'.esc_attr($icon).'"></i></a>';
                        }
                    }
				if ($are_contacts) : ?></div><?php endif;
            } ?>

		</div>
	</div>
<?php endif; ?>