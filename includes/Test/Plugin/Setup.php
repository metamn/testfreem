<?php
/**
 * The plugin setup
 *
 * @package Test\Plugin
 * @since 1.0.0
 */

if ( ! class_exists( 'Test_Plugin_Setup' ) ) {
	/**
	 * The plugin setup class.
	 *
	 * Sets up plugin variables, assets and activation / deactivation methods.
	 *
	 * @since 1.0.0
	 */
	class Test_Plugin_Setup extends Test_Base {

		/**
		 * Class arguments.
		 *
		 * @since 1.0.0
		 *
		 * @var array $arguments An Array of arguments.
		 */
		public $arguments = array(
			'theme_feature_set' => '',
			'theme_features'    => array(),
			'assets'            => array(),
		);

		/**
		 * Arguments for assets.
		 *
		 * @since 1.0.0
		 *
		 * @var array.
		 */
		public $arguments_assets = array(
			'src_url'              => '',
			'admin_assets_folder'  => 'admin',
			'public_assets_folder' => 'public',
			'javascript_folder'    => 'js',
			'css_folder'           => 'css',
			'images_folder'        => 'images',
		);

		/**
		 * Sets up the class.
		 *
		 * @since 1.0.0
		 *
		 * @param array $arguments An array of arguments.
		 * @return void
		 */
		public function __construct( $arguments ) {
			$this->arguments = $this->array_merge( $this->arguments, $arguments );
			$this->assets    = $this->array_merge( $this->arguments_assets, $arguments['assets'] );

			$this->setup_variables();
			$this->setup_assets();

			add_action( 'admin_init', array( $this, 'get_theme_features' ), 11, 0 );

			add_action( 'admin_init', array( $this, 'activate_plugin' ), 12, 0 );
		}


		/**
		 * Gets theme features.
		 *
		 * And saves into `this->theme_features`.
		 *
		 * @since 1.0.0
		 *
		 * @return void.
		 */
		public function get_theme_features() {
			$this->theme_features = array(
				'prepend_post',
				'admin_test_menu',
			);
		}

		/**
		 * Activates the plugin.
		 *
		 * First this method is called in the plugin main file with the `register_activation_hook`.
		 * Since the theme features are not yet set up it will probably do nothing.
		 *
		 * Second is called after the theme features are set up.
		 * As the features are set up now they can be enabled.
		 *
		 * @since 1.0.0
		 *
		 * @link https://developer.wordpress.org/plugins/the-basics/activation-deactivation-hooks/
		 * @return void
		 */
		public function activate_plugin() {
			if ( ! isset( $this->theme_features ) ) {
				return;
			}

			if ( array() === $this->theme_features ) {
				return;
			}

			$features = new Test_Plugin_Features_Base(
				array(
					'features' => $this->theme_features,
				)
			);

			$features->activate();
		}

		/**
		 * Deactivates the plugin.
		 *
		 * Called in the plugin main file with the `register_deactivation_hook`.
		 * The theme features are all set up since deactivation is executed at the end of the hook chain.
		 *
		 * @since 1.0.0
		 *
		 * @link https://developer.wordpress.org/plugins/the-basics/activation-deactivation-hooks/
		 * @return void
		 */
		public function deactivate_plugin() {
			if ( ! isset( $this->theme_features ) ) {
				return;
			}

			if ( array() === $this->theme_features ) {
				return;
			}

			$features = new Test_Plugin_Features_Base(
				array(
					'features' => $this->theme_features,
				)
			);

			$features->deactivate();
		}

		/**
		 * Uninstalls the plugin.
		 *
		 * Called in the plugin main file with the `register_uninstall_hook`.
		 *
		 * @since 1.0.0
		 *
		 * @link https://developer.wordpress.org/plugins/the-basics/uninstall-methods/
		 * @return void
		 */
		public function uninstall_plugin() {
			// Do nothing for now.
		}

		/**
		 * Sets up plugin variables.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function setup_variables() {
			/**
			 * `get_plugin_data` must be loaded first ...
			 *
			 * @link https://wordpress.stackexchange.com/questions/17948/call-to-undefined-function-get-plugin-data
			 */
			if ( ! function_exists( 'get_plugin_data' ) ) {
				require_once ABSPATH . 'wp-admin/includes/plugin.php';
			}

			$plugin = get_plugin_data( PLUGIN_FILE_PATH );

			$this->name        = $plugin['Name'];
			$this->version     = $plugin['Version'];
			$this->text_domain = $plugin['TextDomain'];

			$this->has_admin_interface  = $this->arguments['has_admin_interface'];
			$this->has_public_interface = $this->arguments['has_public_interface'];

			$this->theme_feature_set = $this->arguments['theme_feature_set'];
			$this->theme_features    = $this->arguments['theme_features'];
		}

		/**
		 * Sets up plugin assets.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function setup_assets() {
			$common_arguments = array(
				'src_url'      => $this->assets['src_url'],
				'admin_folder' => $this->assets['admin_assets_folder'],
				'version'      => $this->version,
				'text_domain'  => $this->text_domain,
			);

			if ( true === $this->has_admin_interface ) {
				$arguments = $this->array_merge(
					$common_arguments,
					array(
						'folder'       => $this->assets['admin_assets_folder'],
						'action'       => 'admin_enqueue_scripts',
					)
				);

				$mo_assets = new Test_Assets( $arguments );
				$mo_assets->add();
			}

			if ( true === $this->has_public_interface ) {
				$arguments = $this->array_merge(
					$common_arguments,
					array(
						'folder'       => $this->assets['public_assets_folder'],
						'action'       => 'wp_enqueue_scripts',
					)
				);

				$mo_assets = new Test_Assets( $arguments );
				$mo_assets->add();
			}
		}
	}
} // End if().
