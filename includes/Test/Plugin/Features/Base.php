<?php
/**
 * The plugin features setup
 *
 * @package Test\Plugin\Features
 * @since 1.0.0
 */

if ( ! class_exists( 'Test_Plugin_Features_Base' ) ) {
	/**
	 * The plugin features setup class.
	 *
	 * Implements the functionalities of the plugin.
	 *
	 * This aims to be the most important class of the plugin.
	 * The idea is to have a central place where all functionalities the plugin implements can be quickly overviewed or managed.
	 *
	 * Looking into this file should reveal what the plugin does.
	 *
	 * @since 1.0.0
	 */
	class Test_Plugin_Features_Base extends Test_Base {

		/**
		 * The class arguments.
		 *
		 * @since 1.0.0
		 *
		 * @var array An array of arguments
		 */
		public $arguments = array(
			'features' => array(),
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
			$this->features  = $this->arguments['features'];
		}

		/**
		 * Activates all features.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function activate() {
			if ( ! isset( $this->features ) ) {
				return;
			}

			if ( array() === $this->features ) {
				return;
			}
		}

		/**
		 * Deactivates all features.
		 *
		 * @since 1.0.0
		 *
		 * @return void
		 */
		public function deactivate() {
			if ( ! isset( $this->features ) ) {
				return;
			}

			if ( empty( $this->features ) ) {
				return;
			}
		}
	}
} // End if().
