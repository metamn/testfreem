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
			$this->add_menu_item();
			$this->add_new_setting();
		}

		/**
		 * Deactivates the admin menu.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function deactivate() {
			$this->remove_menu_item();
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
		 * Adds a new setting.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function add_new_setting() {
			register_setting( 'wp_test_menu', 'wp_test_menu_settings' );

			add_settings_section(
				'wp_test_menu_settings_section',
				'WP Test Menu Settings Section',
				array( $this, 'display_menu_page_header' ),
				'wp_test_menu'
			);

			add_settings_field(
				'wp_test_menu_settings_field',
				'WP Test Menu Settings Field',
				array( $this, 'display_menu_page_field' ),
				'wp_test_menu',
				'wp_test_menu_settings_section'
			);
		}

		/**
		 * Displays the content of the admin menu
		 * 
		 * @since 1.0.0
		 * 
		 * @link https://developer.wordpress.org/plugins/settings/custom-settings-page/
		 * 
		 * @return void
		 */
		public function display_menu_page() {
			echo '<h2>WP Test Menu</h2>';

			if ( isset( $_GET['settings-updated'] ) ) {
				add_settings_error( 'wp_test_menu_messages', 'wp_test_menu_message', 'Settings saved', 'updated' );
			}

			settings_errors( 'wp_test_menu_messages' );
			?>

			<form action='options.php' method='post'>
				<?php
					settings_fields( 'wp_test_menu' );
					do_settings_sections( 'wp_test_menu' );
					submit_button( 'Save' );
				?>
			</form>
			
			<?php
		}

		public function display_menu_page_header() {
			echo '<p>Select and item below and press Save</p>';
		}

		/**
		 * Displays a form on the admin
		 * 
		 * @since 1.0.0
		 * @return string
		 */
		public function display_menu_page_field() {
			$ret = '';

			$ret .= '<select id="list" name="list">';
			$ret .= '<option value="list1>List1</option>';
			$ret .= '<option value="list2>List2</option>';
			$ret .= '<option value="list3>List3</option>';
			$ret .= '</select>';

			echo $ret;
		}
	}
} // End if().