<?php
/**
 * Prepend Post
 *
 * @package Test\Plugin\Features
 * @since 1.0.0
 */

if ( ! class_exists( 'Test_Plugin_Features_PrependPost' ) ) {
	/**
	 * The Prepend Post class.
	 *
	 * @since 1.0.0
	 */
	class Test_Plugin_Features_PrependPost extends Test_Base {

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
		 * Activates the prepend.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function activate() {
			add_filter( 'the_title', array( $this, 'prepend_post' ) );
		}

		/**
		 * Deactivates the prepend.
		 * 
		 * @since 1.0.0
		 * @return void
		 */
		public function deactivate() {
			remove_filter( 'the_title', array( $this, 'prepend_post' ) );
		}

		/** 
		 * Prepends a post with a text.
		 * 
		 * @since 1.0.0
		 * @param string $content The original post content
		 * @return string The prepended content
		 */
		public function prepend_post( $content ) {
			$prepend = '';
			$options = get_option( 'wp_test_menu_settings' );

			if ( isset( $options['wp_test_menu_settings_list_name'] ) ) {
				$prepend = $options['wp_test_menu_settings_list_name'];
			}

			return $prepend . $content;
		}
	}
} // End if().