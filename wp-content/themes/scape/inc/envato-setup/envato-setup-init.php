<?php

// This is the setup wizard init file.
// This file changes for each one of dtbaker's themes
// This is where I extend the default 'Envato_Theme_Setup_Wizard' class and can do things like remove steps from the setup process.

// This particular init file has a custom "Update" step that is triggered on a theme update. If the setup wizard finds some old shortcodes after a theme update then it will go through the content and replace them. Probably remove this from your end product.

if ( ! defined( 'ABSPATH' ) ) exit;


add_filter('envato_setup_logo_image','wtbx_envato_setup_logo_image');
function wtbx_envato_setup_logo_image($old_image_url){
	return get_template_directory_uri().'/library/images/admin/scape-logo.png';
}

if ( ! function_exists( 'envato_theme_setup_wizard' ) ) :
	function envato_theme_setup_wizard() {

		if(class_exists('Envato_Theme_Setup_Wizard')) {
			class WTBX_Envato_Theme_Setup_Wizard extends Envato_Theme_Setup_Wizard {

				/**
				 * Holds the current instance of the theme manager
				 *
				 * @since 1.1.3
				 * @var Envato_Theme_Setup_Wizard
				 */
				private static $instance = null;

				/**
				 * @since 1.1.3
				 *
				 * @return Envato_Theme_Setup_Wizard
				 */
				public static function get_instance() {
					if ( ! self::$instance ) {
						self::$instance = new self;
					}

					return self::$instance;
				}

				public function init_actions() {
					if ( apply_filters( $this->theme_name . '_enable_setup_wizard', true ) && current_user_can( 'manage_options' )  ) {
						add_filter( $this->theme_name . '_theme_setup_wizard_content', array(
							$this,
							'theme_setup_wizard_content'
						) );
						add_filter( $this->theme_name . '_theme_setup_wizard_steps', array(
							$this,
							'theme_setup_wizard_steps'
						) );
					}

					add_action( 'wp_ajax_envato_setup_child_theme', array( $this, 'install_child_theme' ) );

					parent::init_actions();
				}

				public function theme_setup_wizard_steps($steps) {
					unset($steps['style']);
					unset($steps['default_content']);
					unset($steps['design']);
					return $steps;
				}
				public function theme_setup_wizard_content($content) {
					if($this->is_possible_upgrade()) {
						array_unshift_assoc($content,'upgrade',array(
							'title' => esc_html__( 'Upgrade', 'scape' ),
							'description' => esc_html__( 'Upgrade Content and Settings', 'scape' ),
							'pending' => esc_html__( 'Pending.', 'scape' ),
							'installing' => esc_html__( 'Installing Updates.', 'scape' ),
							'success' => esc_html__( 'Success.', 'scape' ),
							'install_callback' => array( $this,'_content_install_updates' ),
							'checked' => 1
						));
					}
					return $content;
				}

				public function is_possible_upgrade() {
					return false;
				}

				public function _content_install_updates() {
					return true;
				}

				public function get_header_logo_width() {
					return '70px';
				}

				public function install_child_theme() {
					$url    = wp_nonce_url( add_query_arg( array( 'child_theme' => 'go' ) ), 'envato-setup' );

					$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
					$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

					if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
						return true; // Stop the normal page form from displaying, credential request form will be shown.
					}

					// Now we have some credentials, setup WP_Filesystem.
					if ( ! WP_Filesystem( $creds ) ) {
						// Our credentials were no good, ask the user for them again.
						request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

						return true;
					}

					global $wp_filesystem;

					$themes_dir = trailingslashit( get_theme_root() );
					$filename   = strtolower( wp_get_theme()->get('Name') ) . '-child';
					$zip_file   = trailingslashit( get_template_directory() ) . 'inc/envato-setup/' .$filename . '.zip';
					$zip_path   = $themes_dir . $filename . '.zip' ;

					if (!copy($zip_file, $zip_path)) {
						esc_html_e('Something went wrong. Please install the Child theme manually from the theme package.', 'scape');
					}

					if ( file_exists($themes_dir . $filename) ) {
						esc_html_e('Child theme has been already installed.', 'scape');
					} else {
						$unzipfile = unzip_file($zip_path, $themes_dir);

						if ($unzipfile) {
							wp_delete_file($zip_path);
							echo wp_kses_post( __('Child theme has been installed successfully. Please activate it from <strong>Appearance > Themes</strong> panel after finishing this setup.', 'scape') );
						} else {
							esc_html_e('Something went wrong. Please install the Child theme manually from the theme package.', 'scape');
						}
					}

					wp_die();
				}

				private function _get_plugins() {
					$instance = call_user_func( array( get_class( $GLOBALS['tgmpa'] ), 'get_instance' ) );
					$plugins  = array(
						'all'      => array(), // Meaning: all plugins which still have open actions.
						'install'  => array(),
						'update'   => array(),
						'activate' => array(),
					);

					foreach ( $instance->plugins as $slug => $plugin ) {
						// Not an "is_plugin_active" function, but a TGMPA class member function
						if ( call_user_func(array($instance, 'is_plugin_active'), $slug) && false === $instance->does_plugin_have_update( $slug ) ) {
							// No need to display plugins if they are installed, up-to-date and active.
							continue;
						} else {
							$plugins['all'][ $slug ] = $plugin;

							if ( ! $instance->is_plugin_installed( $slug ) ) {
								$plugins['install'][ $slug ] = $plugin;
							} else {
								if ( false !== $instance->does_plugin_have_update( $slug ) ) {
									$plugins['update'][ $slug ] = $plugin;
								}

								if ( $instance->can_plugin_activate( $slug ) ) {
									$plugins['activate'][ $slug ] = $plugin;
								}
							}
						}
					}

					return $plugins;
				}

				public function envato_setup_introduction() {

					if ( $this->is_possible_upgrade() ) {
						?>
						<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.', 'scape' ), '<strong>'.wp_get_theme().'</strong>' ); ?></h1>
						<p><?php esc_html_e( 'It looks like you may have recently upgraded to this theme. Great! This setup wizard will help ensure all the default settings are correct. It will also show some information about your new website and support options.', 'scape' ); ?></p>
						<p class="envato-setup-actions step">
							<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
							   class="button button-large"><?php esc_html_e( 'Not right now', 'scape' ); ?></a>
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'scape' ); ?></a>
						</p>
					<?php
					} else if ( get_option( 'envato_setup_complete', false ) ) {
						?>
						<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.', 'scape' ), '<strong>'.wp_get_theme().'</strong>' ); ?></h1>
						<p><?php esc_html_e( 'It looks like you have already run the setup wizard. Below are some options: ', 'scape' ); ?></p>
						<p class="envato-setup-actions step">
							<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
							   class="button button-large"><?php esc_html_e( 'Cancel', 'scape' ); ?></a>
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button-primary button button-next button-large"><?php esc_html_e( 'Run Setup Wizard Again', 'scape' ); ?></a>
						</p>
					<?php
					} else {
						?>
						<h1><?php printf( esc_html__( 'Welcome to the setup wizard for %s.', 'scape' ), '<strong>'.wp_get_theme().'</strong>' ); ?></h1>
						<p><?php printf( esc_html__( 'Thank you for choosing the %s theme from ThemeForest. This quick setup wizard will help you configure your new website. This wizard will install the required WordPress plugins, Child theme, and tell you a little about Help &amp; Support options. It should only take 5 minutes.', 'scape' ), wp_get_theme() ); ?></p>
						<p><?php esc_html_e( 'No time right now? If you don\'t want to go through the wizard, you can skip and return to the WordPress dashboard. Come back anytime if you change your mind!', 'scape' ); ?></p>
						<p class="envato-setup-actions step">
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button-primary button button-large button-next"><?php esc_html_e( 'Let\'s Go!', 'scape' ); ?></a>
							<a href="<?php echo esc_url( wp_get_referer() && ! strpos( wp_get_referer(), 'update.php' ) ? wp_get_referer() : admin_url( '' ) ); ?>"
							   class="button button-large"><?php esc_html_e( 'Not right now', 'scape' ); ?></a>
						</p>
					<?php
					}
				}

				public function envato_setup_default_plugins() {

					tgmpa_load_bulk_installer();
					// install plugins with TGM.
					if ( ! class_exists( 'TGM_Plugin_Activation' ) || ! isset( $GLOBALS['tgmpa'] ) ) {
						wp_die( 'Failed to find TGM' );
					}
					$url     = wp_nonce_url( add_query_arg( array( 'plugins' => 'go' ) ), 'envato-setup' );
					$plugins = $this->_get_plugins();

					// copied from TGM

					$method = ''; // Leave blank so WP_Filesystem can populate it as necessary.
					$fields = array_keys( $_POST ); // Extra fields to pass to WP_Filesystem.

					if ( false === ( $creds = request_filesystem_credentials( esc_url_raw( $url ), $method, false, false, $fields ) ) ) {
						return true; // Stop the normal page form from displaying, credential request form will be shown.
					}

					// Now we have some credentials, setup WP_Filesystem.
					if ( ! WP_Filesystem( $creds ) ) {
						// Our credentials were no good, ask the user for them again.
						request_filesystem_credentials( esc_url_raw( $url ), $method, true, false, $fields );

						return true;
					}

					/* If we arrive here, we have the filesystem */

					?>
					<h1><?php esc_html_e( 'Bundled Plugins', 'scape' ); ?></h1>
					<form method="post">

						<?php
						$plugins = $this->_get_plugins();
						if ( count( $plugins['all'] ) ) {
							?>
							<p><?php esc_html_e( 'Your website needs a few essential plugins. The following plugins will be installed or updated:', 'scape' ); ?></p>
							<ul class="envato-wizard-plugins">
								<?php foreach ( $plugins['all'] as $slug => $plugin ) {
									if ( isset($plugin['required']) && $plugin['required'] ) { ?>
                                        <li data-slug="<?php echo esc_attr($slug); ?>"><?php echo esc_html($plugin['name']); ?>
                                            <span>
                                                <?php
                                                $keys = array();
                                                if (isset($plugins['install'][$slug])) {
                                                    $keys[] = 'Installation';
                                                }
                                                if (isset($plugins['update'][$slug])) {
                                                    $keys[] = 'Update';
                                                }
                                                if (isset($plugins['activate'][$slug])) {
                                                    $keys[] = 'Activation';
                                                }
                                                echo implode(' and ', $keys) . ' required';
                                                ?>
    							            </span>
                                            <div class="spinner"></div>
                                        </li>
                                    <?php }
								} ?>
							</ul>
						<?php
						} else {
							echo '<p><strong>' . esc_html__( 'Good news! All plugins are already installed and up to date. Please continue.', 'scape' ) . '</strong></p>';
						} ?>

						<p><?php esc_html_e( 'You can add and remove plugins later on from within WordPress.', 'scape' ); ?></p>

						<p class="envato-setup-actions step">
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button button-large button-next"><?php esc_html_e( 'Skip this step', 'scape' ); ?></a>
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button-primary button button-large button-next"
							   data-callback="install_plugins"><?php esc_html_e( 'Continue', 'scape' ); ?></a>
							<?php wp_nonce_field( 'envato-setup' ); ?>
						</p>
					</form>
				<?php
				}

				public function envato_setup_updates() {
					?>
                    <h1><?php esc_html_e( 'Theme Activation', 'scape' ); ?></h1>

                    <div class="wtbx-dash-widget no-style">
                        <?php
                        $code = $token = '';
                        if ( get_option('scape_theme_id') ) {
	                        $item_id = get_option('scape_theme_id');
	                        $token = get_option('envato_purchase_token_' . $item_id);
	                        $code = get_option('envato_purchase_code_' . $item_id);

	                        if ( empty($token) && get_option('envato_market') ) {
		                        $envato_market = get_option('envato_market');
		                        if ( isset($envato_market['token']) && !empty($envato_market['token']) ) {
			                        $token = $envato_market['token'];
		                        }
	                        }
                        }

                        $validated = !empty($code);

                        if ( $validated ) { ?>

                            <div class="wtbx-dash-activated">
                                <div class="wtbx-validation-wrapper">
                                    <div class="wtbx-dash-column">
                                        <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Token', 'scape') ?></div>
                                        <input type="text" name="wtbx-validation-token" class="wtbx-validation-input" value="<?php echo esc_attr($token); ?>" readonly="readonly" />
                                    </div>
                                    <div class="wtbx-dash-space"></div>
                                    <div class="wtbx-dash-space"></div>
                                    <div class="wtbx-dash-column">
                                        <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Purchase Code', 'scape') ?></div>
                                        <input type="text" name="wtbx-validation-code" class="wtbx-validation-input" value="<?php echo esc_attr($code); ?>" readonly="readonly" />
                                    </div>
                                    <div class="wtbx-dash-message">
                                        <i class="dashicons dashicons-yes"></i>
                                        <?php esc_html_e('Congratulations, your theme copy is activated!', 'scape'); ?>
                                    </div>
                                    <div class="wtbx-dash-column align-center">
                                        <div class="envato-setup-actions step">
                                            <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                                               class="button-primary button button-large button-next"><?php esc_html_e( 'Continue', 'scape' ); ?></a>
		                                    <?php wp_nonce_field( 'envato-setup' ); ?>
                                        </div>
                                    </div>
                                </div>
                                <div class="wtbx-dash-space"></div>
                            </div>

                        <?php } else { ?>

                            <div class="wtbx-dash-not-activated">
                                <div class="wtbx-validation-wrapper">
                                    <div class="wtbx-dash-space"></div>
                                    <div class="wtbx-dash-column">
                                        <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Token', 'scape') ?></div>
                                        <div class="wtbx-dash-hint"><?php echo sprintf(esc_html__('Please insert your Envato Token. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                        <input type="text" name="wtbx-validation-token" class="wtbx-validation-input" value="<?php echo esc_attr($token); ?>" />
                                    </div>
                                    <div class="wtbx-dash-space"></div>
                                    <div class="wtbx-dash-space"></div>
                                    <div class="wtbx-dash-column">
                                        <div class="wtbx-dash-subtitle"><?php esc_html_e('Envato Purchase Code', 'scape') ?></div>
                                        <div class="wtbx-dash-hint"><?php echo sprintf(esc_html__('Please insert your Envato Purchase Code. %sMore info%s.', 'scape'), '<a target="_blank" href="http://docs.whiteboxstud.io/scape/#2-activation">', '</a>') ?></div>
                                        <input type="text" name="wtbx-validation-code" class="wtbx-validation-input" value="" />
                                    </div>
                                    <div class="wtbx-dash-message">
                                        <i class="dashicons dashicons-yes"></i>
                                        <span></span>
                                    </div>
                                    <div class="wtbx-dash-column align-center">
                                        <div class="envato-setup-actions step">
                                            <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                                               class="button button-large button-next wtbx-wizard-skip"><?php esc_html_e( 'Skip this step', 'scape' ); ?></a>
                                            <a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
                                               class="button-primary button button-large button-next wtbx-wizard-continue"><?php esc_html_e( 'Continue', 'scape' ); ?></a>
                                            <?php wp_nonce_field( 'envato-setup' ); ?>
                                            <div id="wtbx-activate-purchase-code" class="wtbx-activation-button button-primary button button-large"><?php esc_html_e('Activate Code', 'scape') ?></div>
                                        </div>
                                    </div>
                                </div>
                                <div class="wtbx-dash-space"></div>
                                <div class="wtbx-dash-space"></div>
                                <div class="wtbx-dash-column align-center">
                                    <p class="wtbx-dash-actvation-adv"><?php esc_html_e('Theme Purchase Code activation will give you access to theme demo content, templates and other premium features.', 'scape') ?></p>
                                    <p class="wtbx-dash-hint"><?php esc_html_e('You can only register one license per website. If the purchase code is registered elsewhere, please deactivate it on that website first.', 'scape') ?></p>
                                </div>
                                <div class="wtbx-dash-space"></div>
                            </div>

                        <?php } ?>
                    </div>
					<?php
				}

				public function envato_setup_customize() {
					?>
					<h1>Theme Customization</h1>
					<p>
						Most changes to the website can be made through the <strong>Theme Options</strong> menu from the WordPress
						dashboard. Since the theme is highly customizable, you may want to take some time and get acquainted
						with the options and how they influence the website.
					</p>
					<p>
						Please feel free to refer to <strong><a href="http://docs.whiteboxstud.io/scape">Theme Documentation</a></strong> for detailed information on theme
						setup and configuration.
					</p>
					<br/>
					<p class="info large"><em><strong>Advanced Users:</strong> If you are going to make changes to the theme source code please use a <a
								href="//codex.wordpress.org/Child_Themes" target="_blank">Child Theme</a> rather than
							modifying the main theme HTML/CSS/PHP code. This allows the parent theme to receive updates without
							overwriting your source code changes.
							<?php
							$child_theme_path = trailingslashit( get_theme_root() ) . strtolower( wp_get_theme()->get('Name') ) . '-child' ;
							if ( !file_exists($child_theme_path) ) : ?>
								<br/><br/><a id="install-child-theme" href="#" class="button button-medium"><?php esc_html_e( 'Install Child Theme', 'scape' ); ?></a>
							<?php endif; ?>
						</em>
					</p>

						<p class="envato-setup-actions step">
							<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
							   class="button button-primary button-large button-next"><?php esc_html_e( 'Continue', 'scape' ); ?></a>
						</p>

					<?php
				}

				public function envato_setup_help_support() {
					?>
					<h1>Help and Support</h1>
					<p>This theme comes with <strong>6 months item support</strong> from purchase date (with the option to extend this period).
						This license allows you to use this theme on a <strong>single</strong> website. Please purchase an additional license to
						use this theme on another website.
					</p>
					<p>For Item Support please use our dedicated <strong><a href="//whitebox.ticksy.com/" target="_blank">Support Forum</a></strong>.<br/></p>
					<br/>
					<div class="info positive align-left">
						<p>Item Support <strong>INCLUDES</strong>:</p>
						<ul>
							<li>Availability of the author to answer questions</li>
							<li>Answering technical questions about item features</li>
							<li>Assistance with reported bugs and issues</li>
							<li>Help with bundled 3rd party plugins</li>
						</ul>
					</div>
					<br/>
					<br/>
					<div class="info negative align-left">
						<p>Item Support <strong>DOES NOT</strong> Include:</p>
						<ul>
							<li>Customization services (this is available through <a
									href="//studio.envato.com"
									target="_blank">Envato Studio</a>)
							</li>
							<li>Installation services (this is available through <a
									href="//studio.envato.com"
									target="_blank">Envato Studio</a>)
							</li>
							<li>Help and Support for non-bundled 3rd party plugins (i.e. plugins you install yourself later on)</li>
						</ul>
					</div>
					<br/>
					<em><p>More details about item support can be found in the ThemeForest <a
							href="//themeforest.net/page/item_support_policy" target="_blank">Item Support Policy</a>. </p>
					<p class="envato-setup-actions step">
						<a href="<?php echo esc_url( $this->get_next_step_link() ); ?>"
						   class="button button-primary button-large button-next"><?php esc_html_e( 'Agree and Continue', 'scape' ); ?></a>
						<?php wp_nonce_field( 'envato-setup' ); ?>
					</p></em>
					<?php
				}

				public function envato_setup_ready() {
					update_option( 'envato_setup_complete', time() );
					update_option( 'scape_activation_notice', 'false' );
					?>

					<h1><?php esc_html_e( 'Your Website is Ready!', 'scape' ); ?></h1>

					<p>Congratulations! The theme has been activated and your website is ready. Login to your WordPress
						dashboard to make changes and modify any of the default content to suit your needs.</p>
					<p>Please come back and <strong><a href="//themeforest.net/downloads" target="_blank">leave a 5-star rating</a></strong>
						if you are happy with this theme.</p>

					<div class="envato-setup-next-steps">
						<div class="envato-setup-next-steps-first">
							<h2><?php esc_html_e( 'Next Steps', 'scape' ); ?></h2>
							<ul>
								<li class="setup-product">
									<a class="button button-large" href="<?php echo esc_url(admin_url('admin.php?page=Scape&tab=1')) ?>" target="_blank"><?php esc_html_e( 'Start configuring', 'scape' ); ?></a>
								</li>
								<li class="setup-product">
									<a class="button button-large" href="<?php echo esc_url(admin_url('admin.php?page=Scape&tab=72')) ?>" target="_blank"><?php esc_html_e( 'Go to demo import', 'scape' ); ?></a>
								</li>
								<li class="setup-product">
									<a class="button button-primary button-large" href="<?php echo esc_url( home_url('/') ); ?>" target="_blank"><?php esc_html_e( 'View your new website!', 'scape' ); ?></a>
								</li>
							</ul>
						</div>
						<div class="envato-setup-next-steps-last">
							<h2><?php esc_html_e( 'More Resources', 'scape' ); ?></h2>
							<ul>
								<li class="documentation"><a href="http://docs.whiteboxstud.io/scape/"
								                             target="_blank"><?php esc_html_e( 'Read the Theme Documentation', 'scape' ); ?></a>
								</li>
								<li class="howto"><a href="https://wordpress.org/support/"
								                     target="_blank"><?php esc_html_e( 'Learn how to use WordPress', 'scape' ); ?></a>
								</li>
								<li class="rating"><a href="http://themeforest.net/downloads"
								                      target="_blank"><?php esc_html_e( 'Leave an Item Rating', 'scape' ); ?></a></li>
								<li class="support"><a href="http://whitebox.ticksy.com/"
								                       target="_blank"><?php esc_html_e( 'Get Help and Support', 'scape' ); ?></a></li>
							</ul>
						</div>
					</div>
				<?php
				}

				public function admin_theme_auth_notice() {

				    if ( !WtbxVerification::is_theme_activated() ) {
					    $show_notice = get_option('scape_activation_notice');

					    if ( $show_notice === 'false' ) { ?>
                            <div class="notice notice-warning wtbx-activation-notice is-dismissible">
                                <p>
								    <?php esc_html_e( 'Please activate your theme Purchase Code to get access to demo content, templates and other premium features.', 'scape' );?>
                                </p>
                                <p>
								    <?php printf( wp_kses_post( __('<a class="button button-primary" href="%s">Activate License</a>', 'scape' ) ),  esc_url( admin_url('admin.php?page=scape-dashboard') ) ); ?>
                                </p>
                            </div>
                            <script type="text/javascript">
								jQuery(function($) {
									setTimeout(function() {
										$('body').on( 'click', '.wtbx-activation-notice .notice-dismiss', function () {
											$.ajax( ajaxurl,
												{
													type: 'POST',
													data: {
														action: 'wtbx_update_notice_handler',
														security: '<?php echo wp_create_nonce( "scape-notice-ajax-nonce" ); ?>'
													}
												} );
										} );
                                    });
								});
                            </script>
					    <?php }
                    }
				}

				public function ajax_notice_handler() {
					check_ajax_referer( 'scape-notice-ajax-nonce', 'security' );
					// Store it in the options table
					update_option( 'scape_activation_notice', 'true' );
				}

			}

			WTBX_Envato_Theme_Setup_Wizard::get_instance();
		}else{
			// log error?
		}
	}
endif;