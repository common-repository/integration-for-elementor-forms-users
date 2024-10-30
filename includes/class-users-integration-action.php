<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit; 
}

class Users_Integration_Action_After_Submit extends \ElementorPro\Modules\Forms\Classes\Action_Base {

	/**
	 * Get Name
	 *
	 * Return the action name
	 *
	 * @access public
	 * @return string
	 */
	public function get_name() {
		return 'users creation integration';
	}

	/**
	 * Get Label
	 *
	 * Returns the action label
	 *
	 * @access public
	 * @return string
	 */
	public function get_label() {
		return __( 'Create User', 'users-elementor-integration' );
	}

	/**
	 * Register Settings Section
	 *
	 * Registers the Action controls
	 *
	 * @access public
	 * @param \Elementor\Widget_Base $widget
	 */
	public function register_settings_section( $widget ) {
		$widget->start_controls_section(
			'section_users-elementor-integration',
			[
				'label' => __( 'Create User', 'users-elementor-integration' ),
				'condition' => [
					'submit_actions' => $this->get_name(),
				],
			]
		);

		$widget->add_control(
			'users_email_field',
			[
				'label' => __( 'Email Field ID', 'users-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'email',
				'description' => __( 'Enter the email field id - you can find this under the email field advanced tab', 'users-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'users_first_name_field',
			[
				'label' => __( 'Firstname Field ID', 'users-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'name',
				'description' => __( 'Enter the firstname field id - you can find this under the name field advanced tab', 'users-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'users_last_name_field',
			[
				'label' => __( 'Lastname Field ID', 'users-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'lastname',
				'description' => __( 'Enter the lastname field id - you can find this under the lastname field advanced tab', 'users-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'users_password_field',
			[
				'label' => __( 'Password Field ID', 'users-elementor-integration' ),
				'type' => \Elementor\Controls_Manager::TEXT,
				'placeholder' => 'password',
				'description' => __( 'Enter the password field id - you can find this under the lastname field advanced tab', 'users-elementor-integration' ),
				'dynamic' => [
					'active' => true,
				],
			]
		);

		$widget->add_control(
			'need_help_note',
			[
				'type' => \Elementor\Controls_Manager::RAW_HTML,
				'raw' => __('Need help? <a href="https://plugins.webtica.be/support/?ref=plugin-widget" target="_blank">Check out our support page.</a>', 'users-elementor-integration'),
			]
		);

		$widget->end_controls_section();

	}

	/**
	 * On Export
	 *
	 * Clears form settings on export
	 * @access Public
	 * @param array $element
	 */
	public function on_export( $element ) {
		unset(
			$element['users_email_field'],
			$element['users_first_name_field'],
			$element['users_last_name_field'],
			$element['users_password_field']
		);

		return $element;
	}

	/**
	 * Run
	 *
	 * Runs the action after submit
	 *
	 * @access public
	 * @param \ElementorPro\Modules\Forms\Classes\Form_Record $record
	 * @param \ElementorPro\Modules\Forms\Classes\Ajax_Handler $ajax_handler
	 */
	public function run( $record, $ajax_handler ) {
		$settings = $record->get( 'form_settings' );

		//  Make sure that there is an email field ID set
		if ( empty( $settings['users_email_field'] ) ) {
			return;
		}

		//  Make sure that there is an password field ID set
		if ( empty( $settings['users_password_field'] ) ) {
			return;
		}

		// Get submitted Form data
		$raw_fields = $record->get( 'fields' );

		// Normalize the Form Data
		$fields = [];
		foreach ( $raw_fields as $id => $field ) {
			$fields[ $id ] = $field['value'];
		}

		// Make sure that the user has an email
		if ( empty( $fields[ $settings['users_email_field'] ] ) ) {
			return;
		}

		// Make sure that the user has a password
		if ( empty( $fields[ $settings['users_password_field'] ] ) ) {
			return;
		}

		// Generate Userlogin
		$userloginori = $fields[$settings['users_first_name_field']] . $fields[$settings['users_last_name_field']];
		$userlogin = strtolower($userloginori);

		//set userlogin by 
		$userdata = array(
			'user_login' => $userlogin,
			'user_pass' => $fields[$settings['users_password_field']],
			'user_email' => $fields[$settings['users_email_field']],
			'first_name' => $fields[$settings['users_first_name_field']],
			'last_name' => $fields[$settings['users_last_name_field']],
			'role' => 'subscriber',
		);
		$userid = wp_insert_user($userdata);
		
	}
}