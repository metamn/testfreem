<?php
/**
 * Admin Test Menu
 *
 * @package Test\Plugin\Features
 * @since 1.0.0
 */

if ( ! class_exists( 'Test_Plugin_Features_AdminTestMenu' ) ) {
	/**
	 * The Admin Test Menut class.
	 *
	 * @since 1.0.0
	 */
	class Test_Plugin_Features_AdminTestMenu extends Test_Base {

		/**
		 * Class arguments.
		 *
		 * @since 1.0.0
		 *
		 * @var array $arguments An Array of arguments.
		 */
		public $arguments = array();

		/**
		 * Sets up the class.
		 *
		 * @since 1.0.0
		 *
		 * @param array $arguments The class setup arguments array.
		 * @return void
		 */
		public function __construct( $arguments = array() ) {
			$this->arguments = $this->array_merge( $this->arguments, $arguments );
		}

		/**
		 * Activates the admin menu.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function activate() {
			add_action( 'admin_init', $this->add_menu_item() );
		}

		/**
		 * Deactivates the admin menu.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function deactivate() {
			add_action( 'admin_menu', $this->remove_menu_item() );
		}

		/**
		 * Adds a new admin menu.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function add_menu_item() {
			add_menu_page(
				'WP Test Menu',
				'WP Test Menu',
				'manage_options',
				'wp_test_menu',
				array( $this, 'display_menu_page' )
			);
		}

		/**
		 * Removes the admin menu.
		 * 
		 * @since 1.0.0
		 * @return void
		*/
		public function remove_menu_item() {
			remove_menu_page( 'wp_test_menu' );
		}

		/**
		 * Displays the content of the admin menu
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function display_menu_page() {
			echo 'xxx';
		}
	}
} // End if().